<?php
// c4w imports
require_once(C4W_DIR.'lib/data/user/Wio.class.php');

/**
 * 
 * 
 * @svn			$Id: IndexPageUsersOnlineListener.class.php 1301 2010-04-25 13:33:41Z TobiasH87 $
 * @package		de.community4wcf.c4w.wio
 * @orginal by	@author  Sani9000
 */

class WioList extends WhoIsOnline {
	// system
	public $users = array();

	// read user
	protected function handleRow($row, User $user) {
		if ($row['userID']) {
			if ($this->isVisible($row, $user)) {
				$row['username'] = $this->getUsername($row, $user);

				$this->users[] = $row;
			}
		}
	}
}
?>