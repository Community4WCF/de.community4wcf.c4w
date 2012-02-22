<?php
// wcf imports
require_once(WCF_DIR.'lib/page/AbstractPage.class.php');
require_once(WCF_DIR.'lib/data/message/bbcode/MessageParser.class.php');

/**
 * Shows the index page of c4w.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class IndexPage extends AbstractPage {
	// system
	public $templateName = 'index';
	public $tags = array();
	
	/**
	 * @see Page::readData()
	 */
	public function readData() {
		parent::readData();
		
		// read tags
		if (MODULE_TAGGING && INDEX_ENABLE_TAGS) {
			$this->readTags();
		}
		
		// check redirect enable
		if (C4W_REDIRECT_ENABLE == 1) {
			HeaderUtil::redirect(C4W_REDIRECT, false);
			exit;
		}
	}
	
	/**
	 * @see Page::assignVariables();
	 */
	public function assignVariables() {
		parent::assignVariables();

		// stats
		if (INDEX_ENABLE_STATS) {
			$this->renderStats();
		}
		
		// content
		WCF::getTPL()->assign(array(
			'indexmessage' => MessageParser::getInstance()->parse(C4W_TEXT, C4W_ENABLE_SMILEY, C4W_ENABLE_HTML, C4W_ENABLE_BBCODES),
			'allowSpidersToIndexThisPage' => true,
			'tags' => $this->tags
		));
	}
	
	/**
	 * Renders the stats.
	 */
	protected function renderStats() {
		$stats = WCF::getCache()->get('stat');
		WCF::getTPL()->assign('stats', $stats);
	}
	
	/**
	 * Reads the tags.
	 */
	protected function readTags() {
		// include files
		require_once(WCF_DIR.'lib/data/tag/TagCloud.class.php');
		
		// get tags
		$tagCloud = new TagCloud(WCF::getSession()->getVisibleLanguageIDArray());
		$this->tags = $tagCloud->getTags();
	}
	
	/**
	 * @see Page::show()
	 
	public function show() {
		// set active menu item -> look in C4WCore.class.php
		//require_once(WCF_DIR.'lib/page/util/menu/PageMenu.class.php');
		//PageMenu::setActiveMenuItem('c4w.header.menu.index');
		
		// check permission
		//WCF::getUser()->checkPermission('user.c4w.canViewC4W');

		parent::show();
	}
	*/
}
?>