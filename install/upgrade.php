<?php
	if(!file_exists("./includes/config.php") == true) {
		die("Plik config.php nie istnieje!");
	}else{
		$config = require './includes/config.php';
	}
	$dir = "install/resources";
	if ($dh = opendir($dir)){
		while (($file = readdir($dh)) !== false){
			if(preg_match("#update([0-9]+).php$#i", $file, $match)){
				$upgradescripts[$match[1]] = $file;
				$key_order[] = $match[1];
			}
		}
		closedir($dh);
	}
	natsort($key_order);
	$update = false;
	foreach($key_order as $k => $key){
		$file = $upgradescripts[$key];
		$upgradescript = file_get_contents('install/resources/'.$file);
		preg_match("/Version: (.*)/m", $upgradescript, $verinfo);
		if((int)str_replace('.', '', $verinfo[1]) > (int)str_replace('.', '', $config['bot']['ver'])){
			echo "\n\x1b[32;01mWykonuje aktualizacje id: ".$key."\n";
			require_once('resources/'.$file);
			$update = true;
		}
	}
	if($update != true){
		echo "\x1b[32;01mBrak aktualizacji\n";
	}



?>