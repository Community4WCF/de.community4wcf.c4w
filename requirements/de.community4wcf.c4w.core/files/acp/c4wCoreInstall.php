<?php
/*
 * @author	Sebastian Oettl  (for C4W by TobiasH)
 * @copyright	2009-2011 WCF Solutions <http://www.wcfsolutions.com/index.php>
 * @license	GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @svn			$Id: c4wCoreInstall.php 1300 2010-04-25 12:48:14Z TobiasH87 $
 * @package		de.community4wcf.c4w.core
 */		
// wcf installation? update style logo
$sql = "SELECT		COUNT(*) AS standalonePackages
	FROM		wcf".WCF_N."_package
	WHERE		standalone = 1
			AND package <> 'com.woltlab.wcf'";
$row = WCF::getDB()->getFirstRow($sql);
if ($row['standalonePackages'] == 0) {
	$sql = "UPDATE	wcf".WCF_N."_style_variable
		SET	variableValue = 'images/c4w-header-logo.png'
		WHERE	variableValue = 'images/wbb3-header-logo.png'
			AND variableName = 'page.logo.image'";
	WCF::getDB()->sendQuery($sql);
}
?>