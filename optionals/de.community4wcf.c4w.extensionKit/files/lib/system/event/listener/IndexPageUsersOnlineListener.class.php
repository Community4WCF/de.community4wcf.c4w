<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Renders the users online list on the index page.
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.extensionKit
 * @orginal by	@author  Sebastian Oettl / @copyright  2009-2010 WCF Solutions <http://www.wcfsolutions.com/index.php>
 */
class IndexPageUsersOnlineListener implements EventListener {
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (MODULE_USERS_ONLINE && INDEX_ENABLE_ONLINE_LIST) {
			require_once(WCF_DIR.'lib/data/user/usersOnline/UsersOnlineList.class.php');
			$usersOnlineList = new UsersOnlineList('', true);
			$usersOnlineList->renderOnlineList();
			
			// check users online record
			$usersOnlineTotal = (USERS_ONLINE_RECORD_NO_GUESTS ? $usersOnlineList->usersOnlineMembers : $usersOnlineList->usersOnlineTotal);
			if ($usersOnlineTotal > USERS_ONLINE_RECORD) {
				$packageID = WCF::getPackageID('de.community4wcf.c4w.extensionKit');
				
				// save new users online record
				$sql = "UPDATE	wcf".WCF_N."_option
					SET	optionValue = ".$usersOnlineTotal."
					WHERE	optionName = 'users_online_record'
						AND packageID = ".$packageID;
				WCF::getDB()->registerShutdownUpdate($sql);
				
				// save new record time
				if (TIME_NOW > USERS_ONLINE_RECORD_TIME) {
					$sql = "UPDATE	wcf".WCF_N."_option
						SET	optionValue = ".TIME_NOW."
						WHERE	optionName = 'users_online_record_time'
							AND packageID = ".$packageID;
					WCF::getDB()->registerShutdownUpdate($sql);
				}
				
				// reset options file
				require_once(WCF_DIR.'lib/acp/option/Options.class.php');
				Options::resetFile();
			}
			
			// append template
			if ($usersOnlineList->usersOnlineTotal) {
				WCF::getTPL()->append('additionalBoxes', WCF::getTPL()->fetch('indexUsersOnline'));
			}
		}
	}
}
?>