<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');
// c4w imports
require_once(C4W_DIR.'lib/data/user/WioList.class.php');

/**
 * Renders the users online list on the index page.
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.wio
 * @orginal by	@author  Sani9000
 */

class WioIndexPageListener implements EventListener {
	// system
	public $wioList;

	// get Online Users
	protected function getOnlineUsers() {
		$this->wioList = new WioList();
		$this->wioList->sqlOrderBy = 'session.username';
		$this->wioList->getWiO();
	}
	
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName){
		if (WIO_ACTIVE && WCF::getUser()->getPermission('user.wio.canSeeWio')) {
			$this->getOnlineUsers();
			WCF::getTPL()->assign(array('users' => $this->wioList->users));
			WCF::getTPL()->append('additionalBoxes', WCF::getTPL()->fetch('wio_index'));
		}
	}
}
?>