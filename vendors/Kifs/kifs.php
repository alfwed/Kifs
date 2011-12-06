<?php

$options = array(
	'kifstart' => 'Generate application directory. args : <app_name> <app_dir>'
);

function showUsage($options)
{
	echo "Usage :\n";
	echo "kifs <option> [...]\n";
	echo "\n";
	echo "Available options :\n";

	foreach ($options as $name => $desc) {
		echo $name.' : '.$desc."\n";
	}

	exit(1);
}

array_shift($argv);

if (!isset($argv[0], $options[$argv[0]])) {
	showUsage($options);
}

switch ($argv[0]) {
	case 'kifstart':
		if (!isset($argv[1], $argv[2]))
			showUsage($options);

		require 'Application/Generator/Generator.php';
		$gen = new \Kifs\Application\Generator\Generator();
		$gen->generate($argv[1], $argv[2]);
		break;
}
