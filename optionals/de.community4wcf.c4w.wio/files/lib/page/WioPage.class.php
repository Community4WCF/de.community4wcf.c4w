<?php
//wcf imports
require_once(WCF_DIR.'lib/page/SortablePage.class.php');
//c4w imports
require_once(C4W_DIR.'lib/data/user/WioList.class.php');

/**
 * Wio Page class
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.wio
 * @author		Martin Schwendowius
 * @copyright	2010 wbb3addons.de
 * @license		Creative Commons Attribution-NoDerivs 3.0 Unported License <http://creativecommons.org/licenses/by-nd/3.0/>
 */
class WioPage extends AbstractPage {
        public $templateName = 'wio';
        public $neededPermissions = 'user.wio.canSeeWio';
        public $wioList;

        /**
         * @see Page::__construct
         */
        public function __construct() {
        	if (!MODULE_WIO) {
			throw new IllegalLinkException();
		}
                $this->wioList = new WioList();
                parent::__construct();
        }

        /**
         * @see Page::readData
         */
        public function readData() {
                parent::readData();
                
                $this->wioList->sqlOrderBy = 'session.username';
                $this->wioList->getWiO();
        }

        /**
         * @see Page::assignVariables
         */
        public function assignVariables() {
                parent::assignVariables();

                WCF::getTPL()->assign(array(
                        'users' => $this->wioList->users,
                        'guestCount' => $this->wioList->guestCount,
                        'canViewIpAddress' => WCF::getUser()->getPermission('admin.general.showIpAddress')
                ));
        }
}
?>