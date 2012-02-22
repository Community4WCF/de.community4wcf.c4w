<?php
// c4w imports
require_once(C4W_DIR.'lib/data/user/AbstractC4WUserSession.class.php');

/**
 * Represents a guest session in c4w.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class C4WGuestSession extends AbstractC4WUserSession {
	protected $lastVisitTime = null;
	
	/**
	 * Initialises the user session.
	 */
	public function init() {
		parent::init();
		
		$this->lastVisitTime = null;
	}
	
	/**
	 * Sets the global c4w last visit timestamp.
	 */
	public function setLastVisitTime($timestamp) {
		$this->lastVisitTime = $timestamp;
		// cookie
		HeaderUtil::setCookie('c4wLastVisitTime', $this->lastVisitTime, TIME_NOW + 365 * 24 * 3600);
		// session
		SessionFactory::getActiveSession()->register('c4wLastVisitTime', $this->lastVisitTime);
	}
	
	/**
	 * Returns the last visit time of this user.
	 * 
	 * @return	integer
	 */
	public function getLastVisitTime() {
		if ($this->lastVisitTime === null) {
			$this->lastVisitTime = 0;
			if (isset($_COOKIE[COOKIE_PREFIX.'c4wLastVisitTime'])) {
				$this->lastVisitTime = intval($_COOKIE[COOKIE_PREFIX.'c4wLastVisitTime']);
			}
			else {
				$this->lastVisitTime = intval(SessionFactory::getActiveSession()->getVar('c4wLastVisitTime'));
			}
		}
		
		return $this->lastVisitTime;
	}
}
?>