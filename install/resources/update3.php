<?php
	set_time_limit(0);

	 // Version: 4.1.7

	if(!file_exists("./includes/config.php") == true) {
		die("Plik config.php nie istnieje!");
	}else{
		$fgc = file_get_contents('./includes/config.php');

	}

	$fgc = preg_replace('/\'ver\'(.*)=> \'([0-9.]+)\'/', '\'ver\'	=> \'4.1.7\'', $fgc);
	if(preg_match("/\/\/StatusTwitch\(\) Funkcja ustawia w opisie status na kanale twitch.
		'functions_StatusTwitch' => \[
			'on'		=> (false|true),	\/\/true - włączona false - wyłączona
			'inst'		=> 2, \/\/ID Instancji
			'cid_name'	=> \[/s", $fgc, $match)){
		$fgc = preg_replace("/(	\/\/StatusTwitch\(\) Funkcja ustawia w opisie status na kanale twitch.
		'functions_StatusTwitch' => \[
			'on'		=> false,	\/\/true - włączona false - wyłączona
			'inst'		=> 2, \/\/ID Instancji)/s", "$1
			'apikay'	=> '', //Klucz API uzyskasz go na  https://dev.twitch.tv/console/apps
			'secret'	=> '', //Hasło klienta uzyskasz je na  https://dev.twitch.tv/console/apps wchodząc w zarządzanie aplikacją.", $fgc);
		file_put_contents('./includes/config.php', $fgc);
		echo "Do config.php zostały dodane dwie nowe opcje w funkcji statusTwitch()";
	}else{
		echo "Coś poszło nie tak:C Nie można zaktualizować config.php";
	}
	file_put_contents('./includes/config.php', $fgc);

?>