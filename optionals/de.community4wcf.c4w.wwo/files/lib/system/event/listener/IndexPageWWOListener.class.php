<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Renders the WWO on the index page.
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.wwo
 * @orginal by	@author  Roul
 */
 
class IndexPageWWOListener implements EventListener {
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (INDEX_ENABLE_WASONLINE_LIST && WCF::getUser()->getPermission('user.c4w.canSeeWWO')) {
		
			// C4W support
			if (version_compare(PACKAGE_VERSION, '2.*', '>')) {
				// C4W 2.*
				if(!defined('PORTAL_COMPATIBILITY_MODE')) define('PORTAL_COMPATIBILITY_MODE', 1);
			}
			else {
				// No support because userOnlineMarking
				if(!defined('PORTAL_COMPATIBILITY_MODE')) define('PORTAL_COMPATIBILITY_MODE', 0);
			}		
		
			require_once(WCF_DIR.'lib/data/user/usersOnline/UsersWasOnlineList.class.php');
			if (INDEX_LIMIT_WASONLINE_LIST && INDEX_LIMIT_WASONLINE_LIST_AMOUNT > 0) $usersWasOnlineList = new UsersWasOnlineList('', true, INDEX_LIMIT_WASONLINE_LIST_AMOUNT);
			else $usersWasOnlineList = new UsersWasOnlineList('', true);
			$usersWasOnlineList->renderWasOnlineList();

			// check users was online record
			if ($usersWasOnlineList->getUsersWasOnlineTotal() > USERS_WASONLINE_RECORD) {
				// save new users was online record
				$sql = "UPDATE	wcf".WCF_N."_option
					SET	optionValue = ".$usersWasOnlineList->getUsersWasOnlineTotal()."
					WHERE	optionName = 'users_wasonline_record'
					AND packageID = (
        			SELECT packageID
        			FROM wcf".WCF_N."_package
        			WHERE parentPackageID = ".PACKAGE_ID."
        			AND package = 'de.community4wcf.c4w.wwo')";
				WCF::getDB()->registerShutdownUpdate($sql);

				// save new record time
				if (TIME_NOW != USERS_WASONLINE_RECORD_TIME) {
					$sql = "UPDATE	wcf".WCF_N."_option
						SET	optionValue = ".TIME_NOW."
						WHERE	optionName = 'users_wasonline_record_time'
						AND packageID = (
	        			SELECT packageID
        				FROM wcf".WCF_N."_package
        				WHERE parentPackageID = ".PACKAGE_ID."
        				AND package = 'de.community4wcf.c4w.wwo')";
					WCF::getDB()->registerShutdownUpdate($sql);
				}

				// delete options file
				@unlink(C4W_DIR.'options.inc.php');
			}
			
			WCF::getTPL()->append('additionalBoxes', WCF::getTPL()->fetch('wwo'));
		}
	}
}
?>