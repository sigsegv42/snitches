<?php
/**
 * (c) Josh Farr <j.wgasa@gmail.com>
 */

$settings = 
array(
	'db' => array(
		'name' 		=> 'snitches',
		'host' 		=> 'localhost',
		'user' 		=> 'root',
		'password' 	=> null
	),
	'log' => array(
		'general' 	=> '/tmp/snitches.log',
		'cli' 		=> '/tmp/snitches-cli.log'
	),

	'timezone' => 'UTC'
);

return $settings;