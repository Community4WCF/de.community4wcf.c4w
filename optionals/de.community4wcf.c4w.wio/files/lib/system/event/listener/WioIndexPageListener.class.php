<?php
//wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

//c4w imports
require_once(C4W_DIR.'lib/data/user/WioList.class.php');

/**
 * WioIndexPageListener
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.wio
 * @author		Martin Schwendowius
 * @copyright	2010 wbb3addons.de
 * @license		Creative Commons Attribution-NoDerivs 3.0 Unported License <http://creativecommons.org/licenses/by-nd/3.0/>
 */
class WioIndexPageListener implements EventListener {
	
	public $wioList;
	
	/**
	 * @see EventListener::execute
	 */
	public function execute($eventObj, $className, $eventName){
		//check permissions and if not active or module deactivated
		if (!WCF::getUser()->getPermission('user.wio.canSeeWio') || !WIO_ACTIVE || !MODULE_WIO) return;
		
		//get users online
		$this->getOnlineUsers();
		
		WCF::getTPL()->assign(array('users' => $this->wioList->users, 'guestCount' => $this->wioList->guestCount));
	        WCF::getTPL()->append('additionalBoxes', WCF::getTPL()->fetch('wio_index'));
        }
        
        
        /**
         * Fetches online users
         * 
         * @return void
         */
        protected function getOnlineUsers() {
		$this->wioList = new WioList();
		$this->wioList->sqlOrderBy = 'session.username';
	        $this->wioList->getWiO();
        }
}
?>