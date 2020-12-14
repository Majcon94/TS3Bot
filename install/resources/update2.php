<?php
	set_time_limit(0);

	 // Version: 4.1.6

	if(!file_exists("./includes/config.php") == true) {
		die("Plik config.php nie istnieje!");
	}else{
		$fgc = file_get_contents('./includes/config.php');

	}

	$fgc = preg_replace('/\'ver\'(.*)=> \'([0-9.]+)\'/', '\'ver\'	=> \'4.1.6\'', $fgc);
	file_put_contents('./includes/config.php', $fgc);

?>