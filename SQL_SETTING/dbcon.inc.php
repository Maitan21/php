<?php
//DB connect
$db = new ScSql(
	$_db_config['driver'],
	$_db_config['host'],
	$_db_config['port'],
	$_db_config['user'],
	$_db_config['password'],
	$_db_config['name']
);
unset($_db_config);
$db->connect();
?>