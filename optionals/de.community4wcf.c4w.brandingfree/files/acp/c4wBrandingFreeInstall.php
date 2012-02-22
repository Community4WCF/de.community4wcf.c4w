<?php
// wcf imports
require_once(WCF_DIR.'lib/data/mail/Mail.class.php');
/**
 * @svn			$Id: c4wBrandingFreeInstall.php 1300 2010-04-25 12:48:14Z TobiasH87 $
 * @package		de.community4wcf.c4w.brandingfree
 */
$mail = new Mail('notify@community4wcf.de', 'Das "C4W - Branding Free" - Standalone Application wurde installiert.', 'Hallo,

das Plugin "C4W - Branding Free" wurde soeben von '.WCF::getUser()->username.' auf der Website: '.PAGE_TITLE.' ('.PAGE_URL.') installiert.

Seitenbeschreibung: '.PAGE_DESCRIPTION.'
E-Mail Adresse: '.MAIL_ADMIN_ADDRESS.'

Viele Grüße', MAIL_ADMIN_ADDRESS);
		
$mail->send();
?>