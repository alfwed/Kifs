<?php
/**
 * @var $appDir string Path to the app directory
 */

// Error page template
$conf['templateInternalError'] = $tplDir.'/Error500.php';

// Config for display
$conf['showErrors'] = true;
$conf['templateErrorFront'] = $tplDir.'/ErrorHandler/ErrorFront.php';

// Config for mail report
$conf['mailErrors'] = false;
$conf['templateErrorMail'] = $tplDir.'/ErrorHandler/ErrorMail.php';
$conf['mailErrorsTo'] = array(
	'support@my-domain.com',
	'devteam@my-domain.com'
);

return $conf;
