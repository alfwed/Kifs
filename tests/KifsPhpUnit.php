<?php

set_include_path(realpath(__DIR__.'/..').PATH_SEPARATOR.
		get_include_path());

spl_autoload_register(function($className) {
    require str_replace('\\', '/', $className).'.php';
});

define('TEST_DIR', __DIR__);