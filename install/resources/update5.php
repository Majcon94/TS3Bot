<?php
	set_time_limit(0);

	// Version: 4.1.9
	if(!file_exists("./includes/config.php") == true) {
		die("Plik config.php nie istnieje!");
	}else{
		$fgc = file_get_contents('./includes/config.php');
	}
	$fgc = preg_replace('/\'ver\'(.*)=> \'([0-9.]+)\'/', '\'ver\'	=> \'4.1.9\'', $fgc);
	if(preg_match("/\/\/ChanneMessege\(\) Funkcja wysyła wiadomość po wejściu na kanał o podanym ID(.*)\/\/ChannelNumber\(\)/s", $fgc)){
		$fgc = preg_replace("/\/\/ChanneMessege\(\) Funkcja wysyła wiadomość po wejściu na kanał o podanym ID(.*)\/\/ChannelNumber\(\)/s", 
		"//ChanneMessege() Funkcja wysyła wiadomość po wejściu na kanał o podanym ID
	'functions_ChanneMessege' => [
		'on'	=> false,	//true - włączona false - wyłączona
		'inst'	=> 3, //ID Instancji 
		'cid'	=> [
			1 => [	//ID kanału.
				'type' => 1,	//Typ 1 - wiadomość na pw 2 - poke
				'text' =>'testks'	//Treść wiadomości którą ma otrzymać
			],
			2 => [	//ID kanału.
				'type' => 1,	//Typ 1 - wiadomość na pw 2 - poke
				'text' =>'testks'	//Treść wiadomości którą ma otrzymać
			],
			3 => [	//ID kanału.
				'type' => 1,	//Typ 1 - wiadomość na pw 2 - poke
				'text' =>'testks'	//Treść wiadomości którą ma otrzymać
			]
		]
	],

	//ChannelNumber()", $fgc);
		echo "Dodano dodatkowe opcje do channeMessege wymaga ponownej konfiguracji\n";
	}else{
		echo "Coś poszło nie tak:C Nie można zaktualizować config.php\n";
	}
	if(preg_match("/'bot' => \[(.*)\/\/log\(\)/s", $fgc)){
	$fgc = preg_replace("/'bot' => \[(.*)\/\/log\(\)/s", 
		"'bot' => [
			'ver'	=> '419',	//Wersja bota.
			'language'	=>	'polish'	//Jezyk bota.
		],

	//log()", $fgc);
		echo "Dodano opcje wyboru języka\n";
	}else{
		echo "Coś poszło nie tak:C Nie można zaktualizować config.php\n";
	}


	
	file_put_contents('./includes/config.php', $fgc);

?>