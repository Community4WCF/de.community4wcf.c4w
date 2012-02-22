<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Shows the personal messages, the group management link in the user panel and the outstanding pm notifications.
 * 
 * @svn			$Id: StructuredTemplateExtensionKitListener.class.php 1845 2012-02-03 20:08:19Z TobiasH87 $
 * @package		de.community4wcf.c4w.extensionKit
 * @orginal by	@author  Sebastian Oettl / @copyright  2009-2010 WCF Solutions <http://www.wcfsolutions.com/index.php>
 */
class StructuredTemplateExtensionKitListener implements EventListener {
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (WCF::getUser()->userID) {
			// personal messages
			if (MODULE_PM == 1) {
				// user panel
				if (WCF::getUser()->getPermission('user.pm.canUsePm')) {
					WCF::getTPL()->append('additionalUserMenuItems', '<li '.(WCF::getUser()->pmUnreadCount ? ' class="new"' : '').' id="userMenuPm"><a href="index.php?page=PMList'.SID_ARG_2ND.'"><img src="'.StyleManager::getStyle()->getIconPath('pm'.(WCF::getUser()->pmUnreadCount ? 'Full' : 'Empty').'S.png').'" alt="" /> <span>'.WCF::getLanguage()->get('c4w.header.userMenu.pm').(WCF::getUser()->pmUnreadCount ? ' ('.StringUtil::formatInteger(WCF::getUser()->pmUnreadCount).')' : '').'</span></a>'.(WCF::getUser()->pmTotalCount >= WCF::getUser()->getPermission('user.pm.maxPm') ? ' <span class="pmBoxFull">'.WCF::getLanguage()->get('wcf.pm.userMenu.mailboxIsFull').'</span>' : '').'</li>');
				}
				
				// outstanding notifications
				require_once(WCF_DIR.'lib/data/message/pm/PM.class.php');
				$outstandingNotifications = PM::getOutstandingNotifications(WCF::getUser()->userID);
				if (WCF::getUser()->showPmPopup && WCF::getUser()->pmOutstandingNotifications && count($outstandingNotifications) > 0) {
					WCF::getTPL()->assign('outstandingNotifications', $outstandingNotifications);
					WCF::getTPL()->append('userMessages', WCF::getTPL()->fetch('headerPMOutstandingNotifications'));
				}
			}
			
			// group management
			if (MODULE_MODERATED_USER_GROUP == 1) {
				// get group leader status
				$isGroupLeader = WCF::getSession()->getVar('isGroupLeader');
				if ($isGroupLeader === null) {
					$sql = "SELECT	COUNT(*) AS count
						FROM	wcf".WCF_N."_group_leader leader, wcf".WCF_N."_group usergroup
						WHERE	(leader.leaderUserID = ".WCF::getUser()->userID."
							OR leader.leaderGroupID IN (".implode(',', WCF::getUser()->getGroupIDs())."))
							AND leader.groupID = usergroup.groupID";
					$row = WCF::getDB()->getFirstRow($sql);
					$isGroupLeader = ($row['count'] ? true : false);
				
					WCF::getSession()->register('isGroupLeader', $isGroupLeader);
				}
				if ($isGroupLeader) {
					// get outstanding applications
					$outstandingGroupApplications = WCF::getSession()->getVar('outstandingGroupApplications');
					if ($outstandingGroupApplications === null) {
						$outstandingGroupApplications = 0;
						$sql = "SELECT	COUNT(*) AS count
							FROM 	wcf".WCF_N."_group_application
							WHERE 	groupID IN (
									SELECT	groupID
									FROM	wcf".WCF_N."_group_leader leader
									WHERE	leader.leaderUserID = ".WCF::getUser()->userID."
										OR leader.leaderGroupID IN (".implode(',', WCF::getUser()->getGroupIDs()).")
								)
								AND applicationStatus IN (0,1)";
						$row = WCF::getDB()->getFirstRow($sql);
						$outstandingGroupApplications = $row['count'];
						
						WCF::getSession()->register('outstandingGroupApplications', $outstandingGroupApplications);
					}
					
					// user panel
					WCF::getTPL()->append('additionalUserMenuItems', '<li id="userMenuGroupManagement"'.($outstandingGroupApplications ? ' class="new"' : '').'><a href="index.php?page=UserGroupLeader'.SID_ARG_2ND.'"><img src="'.StyleManager::getStyle()->getIconPath('groupLeaderS.png').'" alt="" /> <span>'.WCF::getLanguage()->get('c4w.header.userMenu.userGroupLeader').($outstandingGroupApplications ? ' ('.StringUtil::formatInteger($outstandingGroupApplications).')' : '').'</span></a></li>');
				}
			}
		}
		
		// append woltlab copyright
		// it is required for a legal use of the commercial woltlab packages unless you bought a woltlab branding free license
		// visit woltlab.com for more information
		WCF::getTPL()->append('additionalCopyrightContents', '<br />'.WCF::getLanguage()->getDynamicVariable('c4w.global.extensionKit.copyright'));
	}
}
?>