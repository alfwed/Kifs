<?php
/**
 * @var $appDir string Path to the app directory
 */

// Error page template
$conf['templateInternalError'] = $appDir.'';

// Config for display
$conf['showErrors'] = true;
$conf['templateErrorFront'] = $appDir.'';

// Config for mail report
$conf['mailErrors'] = false;
$conf['templateErrorMail'] = $appDir.'';
$conf['mailErrorsTo'] = array(
	'support@my-domain.com',
	'devteam@my-domain.com'
);

return $conf;
