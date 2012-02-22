<?php
/**
 * @svn			$Id: C4WpagePage.class.php 1207 2010-04-09 23:32:46Z TobiasH87 $
 * @package		de.community4wcf.c4w
 */
// include config
$packageDirs = array();
require_once(dirname(__FILE__).'/config.inc.php');

// include wcf
require_once(RELATIVE_WCF_DIR.'global.php');
if (!count($packageDirs)) $packageDirs[] = C4W_DIR;
$packageDirs[] = WCF_DIR;

// starting c4w core
require_once(C4W_DIR.'lib/system/C4WCore.class.php');
new C4WCore();
?>