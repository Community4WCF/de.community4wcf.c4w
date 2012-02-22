<?php
// wcf imports
require_once(WCF_DIR.'lib/system/cache/CacheBuilder.class.php');

/**
 * Caches the acp stats.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class CacheBuilderACPStat implements CacheBuilder {
	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array();
		
		// get installation age
		$installationAge = (TIME_NOW - INSTALL_DATE) / 86400;
		if ($installationAge < 1) $installationAge = 1;
		
		// members
		$sql = "SELECT	COUNT(*) AS members
			FROM	wcf".WCF_N."_user";
		$row = WCF::getDB()->getFirstRow($sql);
		$data['members'] = $row['members'];
		
		// database entries and size
		$data['databaseSize'] = 0;
		$data['databaseEntries'] = 0;
		$sql = "SHOW TABLE STATUS";
		$result = WCF::getDB()->sendQuery($sql);
		while($row = WCF::getDB()->fetchArray($result)) {
			$data['databaseSize'] += $row['Data_length'] + $row['Index_length'];
			$data['databaseEntries'] += $row['Rows'];
		}
		
		return $data;
	}
}
?>