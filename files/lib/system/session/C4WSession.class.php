<?php
// c4w imports
require_once(C4W_DIR.'lib/data/user/C4WUserSession.class.php');
require_once(C4W_DIR.'lib/data/user/C4WGuestSession.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/session/CookieSession.class.php');
require_once(WCF_DIR.'lib/data/user/User.class.php');

/**
 * C4WSession extends the CookieSession class with c4w specific functions.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class C4WSession extends CookieSession {
	protected $userSessionClassName = 'C4WUserSession';
	protected $guestSessionClassName = 'C4WGuestSession';
	protected $styleID = 0;
	
	/**
	 * Initialises the session.
	 */
	public function init() {
		parent::init();
		
		// handle style id
		if ($this->user->userID) $this->styleID = $this->user->styleID;
		if (($styleID = $this->getVar('styleID')) !== null) $this->styleID = $styleID;
	}
	
	/**
	 * Sets the active style id.
	 * 
	 * @param 	integer		$newStyleID
	 */
	public function setStyleID($newStyleID) {
		$this->styleID = $newStyleID;
		if ($newStyleID > 0) $this->register('styleID', $newStyleID);
		else $this->unregister('styleID');
	}
	
	/**
	 * Returns the active style id.
	 * 
	 * @return	integer
	 */
	public function getStyleID() {
		return $this->styleID;
	}
}
?>