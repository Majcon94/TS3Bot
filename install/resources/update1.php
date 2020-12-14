<?php
	set_time_limit(0);

	 // Version: 4.1.0

	if(!file_exists("./includes/config.php") == true) {
		die("Plik config.php nie istnieje!");
	}else{
		$config = require './includes/config.php';
		$fgc = file_get_contents('./includes/config.php');

	}
	try{
		$db = new PDO('mysql:host='.$config['mysql']['host'].';dbname='.$config['mysql']['database'].';port='.$config['mysql']['port'], $config['mysql']['username'], $config['mysql']['password']);
	}catch(PDOException $e){
		echo 'Połączenie nie mogło zostać utworzone: '.$e->getMessage();
	}
	$fgc = preg_replace('/\'ver\'(.*)=> \'([0-9.]+)\'/', '\'ver\'	=> \'4.1.5\'', $fgc);

	if(preg_match("/(\/\/Lista dostępnych domen.*],.)(.*)\/\/DelInfoChannel/s", $fgc, $match)){
		$fgc = preg_replace("/(\/\/Lista dostępnych domen.*],.)(.*)\/\/DelInfoChannel/s", "$1\n	//DdosInfo() Funkcja wysyła wiadomość gdy prawdopodobnie jest przeprowadzany atak ddos.
		'functions_DdosInfo' => [
			'on'			=> false,	//true - włączona false - wyłączona
			'inst'			=> 3, //ID Instancji 
			'gid'			=> [1, 2],	//ID Grup którym ma wysyłać wiadomość.
			'description'	=> true,	//Czy ma w opisie użytkowników z podanych wyżej ustawiać aktualny ping oraz utratę pakietów true - tak false - nie.
			'ping'			=> 60,	//Wielkość średniego pingu od którego ma wysyłać wiadomość.
			'packet'		=> 60,	//Wielkość średnich utraaconych pakietów od których ma wysyłać wiadomość
		],\n\n	//DelInfoChannel", $fgc);
		file_put_contents('./includes/config.php', $fgc);
		echo "Do config.php została dodana funkcja DdosInfo()";
	}else{
		echo "Coś poszło nie tak:C Nie można zaktualizować config.php2";
	}
	sleep(1);
	echo "Aktualizacja bazy danych";
	sleep(1);
	echo "Dodaje index dla tabeli `users`";
	try{
		$db->query("CREATE UNIQUE INDEX index_cui ON users (cui)");
	}catch(PDOException $e){
		echo 'Podczas dodawania indexu coś poszło nie tak '.$e->getMessage();
	}
	sleep(1);
	echo "Dodaje index dla tabeli `ip`";
	try{
		$db->query("CREATE UNIQUE INDEX index_ip ON ip (ip)");
	}catch(PDOException $e){
		echo 'Podczas dodawania indexu coś poszło nie tak '.$e->getMessage();
	}
	echo "Aktualizacja zakończona :)";
	
?>