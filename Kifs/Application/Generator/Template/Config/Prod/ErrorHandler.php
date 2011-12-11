<?php echo <<<'EOD'
<?php
/**
 * @var $path \Kifs\Application\Path
 */

// Error page template
$conf['templateInternalError'] = $path->getTemplateDir().'/Error500.php';

// Config for display
$conf['showErrors'] = false;
$conf['templateErrorFront'] = $path->getTemplateDir().'/ErrorHandler/ErrorFront.php';

// Config for mail report
$conf['mailErrors'] = false;
$conf['templateErrorMail'] = $path->getTemplateDir().'/ErrorHandler/ErrorMail.php';
$conf['mailErrorsTo'] = array(
	'support@my-domain.com',
	'devteam@my-domain.com'
);

return $conf;
EOD;
