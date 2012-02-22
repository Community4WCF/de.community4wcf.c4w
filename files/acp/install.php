<?php
/**
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
$packageID = $this->installation->getPackageID();

// set installation date
$sql = "UPDATE	wcf".WCF_N."_option
	SET	optionValue = ".TIME_NOW."
	WHERE	optionName = 'install_date'
		AND packageID = ".$packageID;
WCF::getDB()->sendQuery($sql);

// set page url and cookie path
if (!empty($_SERVER['SERVER_NAME'])) {
	// domain
	$pageURL = 'http://' . $_SERVER['SERVER_NAME'];
	
	// port
	if (!empty($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != 80) {
		$pageURL .= ':' . $_SERVER['SERVER_PORT'];
	}
	
	// file
	$path = FileUtil::removeTrailingSlash(FileUtil::getRealPath(FileUtil::addTrailingSlash(dirname(dirname(WCF::getSession()->requestURI))).$this->installation->getPackage()->getDir()));
	$pageURL .= $path;
	
	$sql = "UPDATE	wcf".WCF_N."_option
		SET	optionValue = '".escapeString($pageURL)."'
		WHERE	optionName = 'page_url'
			AND packageID = ".$packageID;
	WCF::getDB()->sendQuery($sql);
	
	$sql = "UPDATE	wcf".WCF_N."_option
		SET	optionValue = '".escapeString($path)."'
		WHERE	optionName = 'cookie_path'
			AND packageID = ".$packageID;
	WCF::getDB()->sendQuery($sql);
}

// admin options
$sql = "UPDATE 	wcf".WCF_N."_group_option_value
	SET	optionValue = 1
	WHERE	groupID = 4
		AND optionID IN (
			SELECT	optionID
			FROM	wcf".WCF_N."_group_option
			WHERE	packageID IN (
					SELECT	dependency
					FROM	wcf".WCF_N."_package_dependency
					WHERE	packageID = ".$packageID."
				)
		)
		AND optionValue = '0'";
WCF::getDB()->sendQuery($sql);

// disable flood control
$sql = "UPDATE 	wcf".WCF_N."_group_option_value
	SET	optionValue = 0
	WHERE	groupID IN (4, 5, 6)
		AND optionID IN (
			SELECT	optionID
			FROM	wcf".WCF_N."_group_option
			WHERE	optionName = 'user.message.floodControlTime'
		)
		AND optionValue = '30'";
WCF::getDB()->sendQuery($sql);

// add c4w update server
/*
$server = 'http://community4wcf.eu/filebase/packages/';
$sql = "SELECT	COUNT(*) AS amount
	FROM	wcf".WCF_N."_package_update_server
	WHERE	server = '".escapeString($server)."'";
$row = WCF::getDB()->getFirstRow($sql);
if ($row['amount'] == 0) {
	require_once(WCF_DIR.'lib/acp/package/update/UpdateServerEditor.class.php');
	$packageUpdateServerID = UpdateServerEditor::create($server);
}
*/

// refresh (basic) style file
require_once(WCF_DIR.'lib/data/style/StyleEditor.class.php');
$sql = "SELECT * FROM wcf".WCF_N."_style WHERE isDefault = 1";
$style = new StyleEditor(null, WCF::getDB()->getFirstRow($sql));
$style->writeStyleFile();
?>