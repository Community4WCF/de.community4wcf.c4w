<?php
// c4w imports
require_once(C4W_DIR.'lib/system/session/C4WSession.class.php');
require_once(C4W_DIR.'lib/data/user/C4WUserSession.class.php');
require_once(C4W_DIR.'lib/data/user/C4WGuestSession.class.php');

// wcf imports
require_once(WCF_DIR.'lib/system/session/CookieSessionFactory.class.php');

/**
 * WSIFSessionFactory extends the CookieSessionFactory class with c4w specific functions.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class C4WSessionFactory extends CookieSessionFactory {
	protected $guestClassName = 'C4WGuestSession';
	protected $userClassName = 'C4WUserSession';
	protected $sessionClassName = 'C4WSession';
}
?>