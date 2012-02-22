<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');
require_once(WCF_DIR.'lib/data/message/bbcode/MessageParser.class.php');

/**
 * Add StatsOwnInfo
 * 
 * @svn			$Id: C4WStatsOwnInfoListener.class.php 1668 2011-01-09 18:37:34Z TobiasH87 $
 * @package		de.community4wcf.c4w.statsowninfo
 */
class C4WStatsOwnInfoListener implements EventListener
{
	/**
	 * @see		EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName)
	{
		//requirements for StatsInfo
		if (INDEX_STATSOWNINFO_ENABLE && WCF::getUser()->getPermission('user.c4w.canViewStatsOwnInfo')) {
		// parse
		WCF::getTPL()->assign(array('message' => MessageParser::getInstance()->parse(INDEX_STATSOWNINFO_CONTENT, INDEX_STATSOWNINFO_ENABLE_SMILEY, INDEX_STATSOWNINFO_ENABLE_HTML, INDEX_STATSOWNINFO_ENABLE_BBCODES)));
		// show
		WCF::getTPL()->append('additionalBoxes', WCF::getTPL()->fetch('statsOwnInfo'));
		}
	}        
}
?>