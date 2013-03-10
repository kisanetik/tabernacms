<?php

if (file_exists('config.db.php')) {
	include 'config.db.php';

	$result = true;

	try {
		$dbh = new PDO('mysql:host=' . $config['db_config']['db_hostname'] . ';dbname=' . $config['db_config']['db_databasename'],
			$config['db_config']['db_username'],
			$config['db_config']['db_password']);
	} catch (PDOException $e) {
		$result = false;
	}

	return $result;
}

return false;