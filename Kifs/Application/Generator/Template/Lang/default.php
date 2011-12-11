<?php echo <<<'EOD'
<?php

/**
 * Contains an array of array of the form :
 *
 * 	array(
 * 		'translation_key' => array(
 * 			'singular translation',
 * 			'plural trasnlation
 * 		),
 * 	)
 *
 * The plural translation is optional.
 *
 * @var array $trad
 */

$trad = array(
	'PONEY' => array(
		'Poney',
		'Ponies'
	)
);

return $trad;
EOD;
