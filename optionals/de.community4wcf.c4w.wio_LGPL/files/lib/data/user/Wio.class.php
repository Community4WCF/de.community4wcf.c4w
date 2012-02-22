<?php
// wcf imports
require_once(WCF_DIR.'lib/data/user/User.class.php');

/**
 * WIO
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.wio
 * @orginal by	@author  Sani9000
 */

abstract class WhoIsOnline {
	// system
	public $sqlSelects = '';
	public $sqlJoins = '';
	public $sqlOrderBy = 'session.username';

	// get WiO
	public function getWiO() {
		$sql = "SELECT                 ".$this->sqlSelects."
		user_option.userOption".User::getUserOptionID('invisible').", session.userID, session.ipAddress,
		session.userAgent, session.lastActivityTime, user.username
		FROM              wcf".WCF_N."_session session
		LEFT JOIN         wcf".WCF_N."_user user
		ON                (user.userID = session.userID)
		LEFT JOIN         wcf".WCF_N."_user_option_value user_option
		ON                (user_option.userID = session.userID)
		".$this->sqlJoins."
		WHERE            session.lastActivityTime > ".(TIME_NOW - USER_ONLINE_TIMEOUT)."
		ORDER BY         ".$this->sqlOrderBy;
		$result = WCF::getDB()->sendQuery($sql);
		while ($row = WCF::getDB()->fetchArray($result)) {
		$this->handleRow($row, new User(null, $row));
		}
	}

	// check user invisible
	protected function isVisible($row, User $user) {
		return (WCF::getUser()->userID == $user->userID || !$user->invisible || WCF::getUser()->getPermission('admin.general.canViewInvisible'));
	}

	// get users
	public static function getUsername($row, User $user) {
		$row['username'] = StringUtil::encodeHTML($row['username']);

		if ($user->invisible) {
			$row['username'] .= WCF::getLanguage()->get('wcf.wio.invisible');
		}

		return $row['username'];
	}
}
?>