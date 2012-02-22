<?php
// wcf imports
require_once(WCF_DIR.'lib/system/WCFACP.class.php');

/**
 * This class extends the main WCFACP class by c4w specific functions.
 * 
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
class C4WACP extends WCFACP {
	/**
	 * @see WCF::getOptionsFilename()
	 */
	protected function getOptionsFilename() {
		return C4W_DIR.'options.inc.php';
	}
	
	/**
	 * Initialises the template engine.
	 */
	protected function initTPL() {
		global $packageDirs;
		
		self::$tplObj = new ACPTemplate(self::getLanguage()->getLanguageID(), ArrayUtil::appendSuffix($packageDirs, 'acp/templates/'));
		$this->assignDefaultTemplateVariables();
	}
	
	/**
	 * Does the user authentication.
	 */
	protected function initAuth() {
		parent::initAuth();
		
		// user ban
		if (self::getUser()->banned) {
			throw new PermissionDeniedException();
		}
	}
	
	/**
	 * @see WCF::assignDefaultTemplateVariables()
	 */
	protected function assignDefaultTemplateVariables() {
		parent::assignDefaultTemplateVariables();
		
		self::getTPL()->assign(array(
			// add jump to filebase link 			
			'additionalHeaderButtons' => '<li><a href="'.RELATIVE_C4W_DIR.'index.php?page=Index"><img src="'.RELATIVE_C4W_DIR.'icon/indexS.png" alt="" /> <span>'.WCF::getLanguage()->get('c4w.acp.jumpToC4W').'</span></a></li>',
			// individual page title
			'pageTitle' => WCF::getLanguage()->get(StringUtil::encodeHTML(PAGE_TITLE)).' - '.StringUtil::encodeHTML(PACKAGE_NAME.' '.PACKAGE_VERSION)
		));
	}
	
	/**
	 * @see WCF::loadDefaultCacheResources()
	 */
	protected function loadDefaultCacheResources() {
		parent::loadDefaultCacheResources();
		$this->loadDefaultC4WCacheResources();
	}
	
	/**
	 * Loads default cache resources of community c4w acp.
	 * Can be called statically from other applications or plugins.
	 */
	public static function loadDefaultC4WCacheResources() {
	}
}
?>