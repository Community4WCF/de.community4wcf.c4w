<?php
// wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');
// c4w imports
require_once(C4W_DIR.'lib/data/user/WioList.class.php');

/**
 * Shows the WIO page.
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.wio
 * @orginal by	@author  Sani9000
 */

class WioPage extends SortablePage {
	// system
	public $templateName = 'wio';
	public $wioList;
	
	// construct WIO list
	public function __construct() {
		$this->wioList = new WioList();
		parent::__construct();
	}

	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
			// order username by session
			$this->wioList->sqlOrderBy = 'session.username';
			$this->wioList->getWiO();
	}

	/**
	 * @see Page::assignVariables();
	 */
	public function assignVariables() {
		parent::assignVariables();
		
		WCF::getTPL()->assign(array(
			'users' => $this->wioList->users,
			'canViewIpAddress' => WCF::getUser()->getPermission('admin.general.wio.showIpAddress')
		));
	}
	
	/**
	 * @see Page::show()
	 */
	public function show() {
		WCF::getUser()->checkPermission('user.wio.canSeeWio');
		
		parent::show();
	}
}
?>