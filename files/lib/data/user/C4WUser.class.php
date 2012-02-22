<?php
// wcf imports
require_once(WCF_DIR.'lib/data/user/UserProfile.class.php');

/**
 * Represents a user in c4w.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class C4WUser extends UserProfile {
	protected $avatar = null;
	
	/**
	 * @see UserProfile::__construct()
	 */
	public function __construct($userID = null, $row = null, $username = null, $email = null) {
		$this->sqlJoins .= ' LEFT JOIN c4w'.C4W_N.'_user c4w_user ON (c4w_user.userID = user.userID) ';
		parent::__construct($userID, $row, $username, $email);
	}
}
?>