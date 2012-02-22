<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');
require_once(WCF_DIR.'lib/data/user/User.class.php');

/**
 * Caches filebase stats.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class CacheBuilderStat implements CacheBuilder {
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		// amount of members
		$sql = "SELECT	COUNT(*) AS amount
			FROM	wcf".WCF_N."_user";
		$result = WCF::getDB()->getFirstRow($sql);
		$data['members'] = $result['amount'];
		
		// newest member
		$sql = "SELECT 		*
			FROM 		wcf".WCF_N."_user
			ORDER BY 	userID DESC";
		$result = WCF::getDB()->getFirstRow($sql);
		$data['newestMember'] = new User(null, $result);
		
		return $data;
	}
}
?>