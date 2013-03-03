<?php echo <<<'EOD'
<?php
/**
 * Contains root url of the website for each country
 *
 * Usage :
 * 		array(
 * 			'country1' => 'root_url1'
 * 			'country2' => 'root_url2'
 * 		)
 *
 * @var $conf array
 */


$conf = array(
	'default' => 'http://localhost/'
);

return $conf;
EOD;
