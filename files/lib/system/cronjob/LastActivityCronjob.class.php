<?php
require_once(WCF_DIR.'lib/data/cronjobs/Cronjob.class.php');

/**
 * Updates the lastactivity timestamp in the user table.
 * 
 * @svn			$Id: LastActivityCronjob.class.php 1324 2010-04-28 18:55:57Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class LastActivityCronjob implements Cronjob {
	/**
	 * @see Cronjob::execute()
	 */
	public function execute($data) {
		// update global last activity
		$sql = "UPDATE	wcf".WCF_N."_user user_table,
				wcf".WCF_N."_session session
			SET	user_table.lastActivityTime = session.lastActivityTime
			WHERE	user_table.userID = session.userID
				AND session.userID <> 0";
		WCF::getDB()->registerShutdownUpdate($sql);
		}
}
?>