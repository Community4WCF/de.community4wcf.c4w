<?php
// c4w imports
require_once(C4W_DIR.'lib/data/user/AbstractC4WUserSession.class.php');

// wcf imports
require_once(WCF_DIR.'lib/data/user/avatar/Gravatar.class.php');
require_once(WCF_DIR.'lib/data/user/avatar/Avatar.class.php');

/**
 * Represents a user session in c4w.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class C4WUserSession extends AbstractC4WUserSession {
	protected $ignores = null;
	protected $invitations = null;
	
	/**
	 * displayable avatar object.
	 *
	 * @var DisplayableAvatar
	 */
	protected $avatar = null;
	
	/**
	 * @see UserSession::__construct()
	 */
	public function __construct($userID = null, $row = null, $username = null) {
		$this->sqlSelects .= "	c4w_user.*, avatar.*, c4w_user.userID AS c4wUserID,
					(SELECT COUNT(*) FROM wcf".WCF_N."_user_whitelist WHERE whiteUserID = user.userID AND confirmed = 0 AND notified = 0) AS numberOfInvitations,";
		$this->sqlJoins .= " 	LEFT JOIN c4w".C4W_N."_user c4w_user ON (c4w_user.userID = user.userID)
					LEFT JOIN wcf".WCF_N."_avatar avatar ON (avatar.avatarID = user.avatarID) ";
		parent::__construct($userID, $row, $username);
	}
	
	/**
	 * @see User::handleData()
	 */
	protected function handleData($data) {
		parent::handleData($data);
		
		if (MODULE_AVATAR == 1 && !$this->disableAvatar && $this->showAvatar) {
			if (MODULE_GRAVATAR == 1 && $this->gravatar) {
				$this->avatar = new Gravatar($this->gravatar);
			}
			else if ($this->avatarID) {
				$this->avatar = new Avatar(null, $data);
			}
		}
	}
	
	/**
	 * Updates the user session.
	 */
	public function update() {
		// update global last activity timestamp
		C4WUserSession::updateLastActivityTime($this->userID);
		
		if (!$this->c4wUserID) {
			$sql = "INSERT IGNORE INTO	c4w".C4W_N."_user
							(userID)
				VALUES			(".$this->userID.")";
			WCF::getDB()->registerShutdownUpdate($sql);
		}
	}
	
	/**
	 * Initialises the user session.
	 */
	public function init() {
		parent::init();
		
		$this->invitations = $this->ignores = null;
	}
	
	/**
	 * Updates the global last activity timestamp in user database.
	 * 
	 * @param	integer		$userID
	 * @param	integer		$timestamp
	 */
	public static function updateLastActivityTime($userID, $timestamp = TIME_NOW) {
		$sql = "UPDATE	wcf".WCF_N."_user
			SET	lastActivityTime = ".$timestamp."
			WHERE	userID = ".$userID;
		WCF::getDB()->registerShutdownUpdate($sql);
	}
	
	/**
	 * Returns the outstanding invitations.
	 */
	public function getInvitations() {
		if ($this->invitations === null) {
			$this->invitations = array();
			$sql = "SELECT		user_table.userID, user_table.username
				FROM		wcf".WCF_N."_user_whitelist whitelist
				LEFT JOIN	wcf".WCF_N."_user user_table
				ON		(user_table.userID = whitelist.userID)
				WHERE		whitelist.whiteUserID = ".$this->userID."
						AND whitelist.confirmed = 0
						AND whitelist.notified = 0
				ORDER BY	whitelist.time";
			$result = WCF::getDB()->sendQuery($sql);
			while ($row = WCF::getDB()->fetchArray($result)) {
				$this->invitations[] = new User(null, $row);
			}
		}
		return $this->invitations;
	}
	
	/**
	 * Returns the avatar of this user.
	 * 
	 * @return	DisplayableAvatar
	 */
	public function getAvatar() {
		return $this->avatar;
	}
}
?>