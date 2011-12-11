<?php

set_include_path(realpath(__DIR__.'/../vendors').PATH_SEPARATOR.
		get_include_path());

spl_autoload_register(function($className) {
    require str_replace('\\', '/', $className).'.php';
});