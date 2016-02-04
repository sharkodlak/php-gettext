<?php
define('ROOT_DIR', realpath(__DIR__ . '/..'));
spl_autoload_register(function ($className) {
	$namespace = 'Sharkodlak\\Gettext\\';
	$namespaceLength = strlen($namespace);
	if (strncmp($className, $namespace, $namespaceLength) == 0) {
		$className = substr($className, $namespaceLength);
		require ROOT_DIR . '/src/' . $className . '.php';
		return true;
	};
	return false;
});
