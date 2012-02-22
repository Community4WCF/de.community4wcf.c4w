<?php
//c4w imports
require_once(C4W_DIR.'lib/data/user/Wio.class.php');

/**
 * Wio list class
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.wio
 * @author		Martin Schwendowius
 * @copyright	2010 wbb3addons.de
 * @license		Creative Commons Attribution-NoDerivs 3.0 Unported License <http://creativecommons.org/licenses/by-nd/3.0/>
 */
class WioList extends WhoIsOnline {
        public $users = array();

        /**
         * handle row
         * 
         * @param mixed $row
         * @param mixed $user
         * @return void
         */
        protected function handleRow($row, User $user) {
        
                if ($row['userID']) {
                        if ($this->isVisible($row, $user)) {
                                $row['username'] = $this->getUsername($row, $user);
                                $this->users[] = $row;
                        }
                }
                
                if ($row['userID'] == 0 && WIO_SHOW_GUESTS) {
                	$this->guestCount++;                	
                }
        }
}
?>