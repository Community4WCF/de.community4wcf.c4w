<?php
// wcf imports
require_once(WCF_DIR.'lib/system/box/BoxLayoutManager.class.php');
require_once(WCF_DIR.'lib/system/event/EventListener.class.php');

/**
 * Shows the boxes.
 * 
 * @author	Sebastian Oettl
 * @copyright	2009-2010 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package	com.wcfsolutions.wsif.box
 * @subpackage	system.event.listener
 * @category 	Infinite Filebase
 */
class StructuredTemplateBoxListener implements EventListener {
	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		// register positions
		BoxLayout::registerPositions(array('left', 'right', 'top', 'bottom', 'userMessages'));
		
		// change box layout to default
		BoxLayoutManager::changeBoxLayout();
		
		// assign box layout
		WCF::getTPL()->assign('boxLayout', BoxLayoutManager::getBoxLayout());
		
		// box stylesheet
		$html = '<link rel="stylesheet" type="text/css" media="screen" href="'.RELATIVE_C4W_DIR.'style/box.css" />
			<link rel="stylesheet" type="text/css" media="print" href="'.RELATIVE_C4W_DIR.'style/boxPrint'.(PAGE_DIRECTION == 'rtl' ? '-rtl' : '').'.css" />
			<style type="text/css">
				#boxLayout {
					'.(C4WCore::getStyle()->getVariable('page.width') ? 'width: '.C4WCore::getStyle()->getVariable('page.width') : '').';
					'.(C4WCore::getStyle()->getVariable('page.width.max') ? 'max-width: '.C4WCore::getStyle()->getVariable('page.width.max') : '').';
					'.(C4WCore::getStyle()->getVariable('page.width.min') ? 'min-width: '.C4WCore::getStyle()->getVariable('page.width.min') : '').';
				}
			</style>';
		WCF::getTPL()->append('specialStyles', $html);
		
		// box header
		WCF::getTPL()->append('additionalHeaderContents', WCF::getTPL()->fetch('boxHeader'));
		
		// box footer
		WCF::getTPL()->append('additionalFooterContents', WCF::getTPL()->fetch('boxFooter'));
		
		// user messages
		WCF::getTPL()->assign('boxPosition', 'userMessages');
		WCF::getTPL()->append('userMessages', WCF::getTPL()->fetch('boxList'));
		
		// index top
		if (in_array('indexTop', BoxLayout::$registredPositions)) {
			WCF::getTPL()->assign('boxPosition', 'indexTop');
			WCF::getTPL()->append('additionalTopContents', WCF::getTPL()->fetch('boxList'));
		}
	
		// index bottom
		if (in_array('indexBottom', BoxLayout::$registredPositions)) {
			WCF::getTPL()->assign('boxPosition', 'indexBottom');
			WCF::getTPL()->append('additionalTopContents', WCF::getTPL()->fetch('boxList'));
		}
	}
}
?>