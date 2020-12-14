<?php
	declare(strict_types=1);
	set_time_limit(0);
	ini_set('error_log', 'log/php_error.log');
	/**
	 * @author		Majcon
	 * @email		Majcon94@gmail.com
	 * @copyright	© 2016-2020 Majcon
	 * @version		3.5
	 **/
	spl_autoload_register(function ($class_name) {
		require_once 'class/'.mb_strtolower($class_name).'.class.php';
	});
	$inst = getopt("i:");
	if(!empty($inst)){
		try {
			$bot = new Bot($inst['i']);
		} catch (Exception $e) {
			echo $e->getMessage(), "\n";
		}
	}
?>