<?php
// wcf imports
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Set the page title as Copyright.
 * 
 * @svn			$Id: StructuredTemplateBrandingOwnListener.class.php 1848 2012-02-05 00:12:09Z TobiasH87 $
 * @package		de.community4wcf.c4w.brandingown
 */
class StructuredTemplateBrandingOwnListener implements EventListener {
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		// Set the page title as Copyright
		WCF::getTPL()->append('additionalCopyrightContents', WCF::getLanguage()->getDynamicVariable('c4w.global.brandingown.copyright'));
	}
}
?>