<?php
use \Kifs\Controller\Router\Route;

$conf[] = new Route('alf', 'Alex', array());
$conf[] = new Route('/test', 'Alex', array());
$conf[] = new Route('foo/:page/bar', 'Dummy', array(':page' => 'int'));

return $conf;