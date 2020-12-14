<?php

	return [

		'server' => [

			'login'		=> 'serveradmin',	//ServerQuery Login
			'password'	=> '',	//ServerQuery password
			'ip'		=> '127.0.0.1',	//IP serwera
			'port'		=> 9987,	//Server port
			'queryport'	=> 10011,	//Query port
			'nick1'		=> 'DziadekBOT #1',	//Nick bota na ts
			'nick2'		=> 'DziadekBOT #2',	//Nick bota na ts
			'nick3'		=> 'DziadekBOT #3'	//Nick bota na ts

		],

		'mysql' => [
			'host'		=> 'localhost',	//Host bazy danych
			'username'	=> 'root',	//Użytkownik bazy danych
			'database'	=> 'ts3bot',	//Nazwa bazy danych
			'password'	=> '',	//Hasło bazy danych
			'port'	=> 3306	//Port bazy
		],

		'bot' => [
			'ver'	=> '418',	//Wersja bota.
			'language'	=>	'polish'	//Jezyk bota.
		],

	//log() Funkcja zapisuje logi z bota do pliku.
		'functions_log' => [
			'on'	=> true,	//true - włączona false - wyłączona
			'power'	=> 2	//Moc zapisu logu.
		],

	//AddRank() Funkcja dodaje range po wejściu na kanało o podanym ID.
		'functions_AddRank' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 1, //ID Instancji 
			'cid_gid'	=> [
				1 => 2
			]	//ID kanału, na który trzeba wejść wraz z ID rangi, którą ma nadać po wejściu. Tutaj 1 oraz 3 to ID kanału 2 oraz 4 ID rangi.
		],

	//AdminLog() Funkcja zapisuje logi podanych grup.
		'functions_AdminLog' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 1, //ID Instancji 
			'gid'		=> [1, 2, 3]	//ID Grup których ma zapisyweć logi.
		],

	//AktualnaData() Funkcja ustawia aktualną datę jako nazwa kanału o podanym ID.
		'functions_AktualnaData' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 2, //ID Instancji 
			'cid'		=> 1,	//ID kanału, na którym ma ustawiać datę.
			'format'	=> 'd.m.Y H:i'	//Format daty d - dzień m - miesiąc Y - rok H - godzina i - minuta s - sekunda
		],

	//AktualnieOnline() Funkcja ustawia aktualną liczbę osób online jako nazwa kanału o podanym ID.
		'functions_AktualnieOnline' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 2, //ID Instancji 
			'cid'	=> 1	//ID kanału, na którym ma ustawiać aktualną liczbę online.
		],

	//AntyVpn() Funkcja wyrzuca użytkowników, którzy posiadają proxy.
		'functions_AntyVpn' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 1, //ID Instancji 
			'client_unique_identifier'	=> [
					'G1MUSIS0ZgFAFAFafsfCkIfow=', 'TMJaj/eXYAFAFAFAFAfaprVxopUg8='
			],	//Unique identifier użytkownika, którego ma nie wyrzucać za VPN.
			'gid'		=> '1,2,3',	//ID Group, które ma nie wyrzucać za VPN.
			'key'		=> 'MzMyMTptb25ad0p5U05jRHBKZG4ySXlOOE5iYXQxdGpIQnB3Rw=='	//Klucz do API można go uzyskać na stronie https://iphub.info/pricing
		],

	//BanHistory() Funkcja zapisuje bany.
		'functions_BanHistory' => [
			'on'		=> false,	//true - włączona false - wyłączonav.
			'inst'		=> 1, //ID Instancji 
		],

	//BanList() Funkcja ustawia listę banów w opisie kanału o podanym ID.
		'functions_BanList' => [
			'on'		=> false,	//true - włączona false - wyłączonav.
			'inst'		=> 1, //ID Instancji 
			'cid'		=> 1,	//ID kanału, na którym ma ustawiać opis z lista banów.
			'limit'		=> 2	//Limit banów.
		],

	//ChannelCreate() Funkcja zakłada kanały w podanym sektorze.
		'functions_ChannelCreate' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'	=> 1, //ID Instancji 
			'cid'		=> 1,	//ID kanału, na którego trzeba wejść, aby dostać kanał prywatny.
			'pid'		=> 2,	//Strefa, w której ma zakładać kanały prywatne.
			'ile'		=> 2,	//Liczba podkanałów.
			'gid'		=> 5,	//ID Grupy właściciela kanału.
			'cgid'		=> [1,2],	//ID Grupy wymaganej do założenia kanału.
			'limit_ip'	=> 3,	//Limit kanałów na jedno IP 0 - Brak limitu.
			'pin'		=> true,	//Czy ma wysyłać pin do odzyskiwania kanału.
			'channel_description'	=> '[hr]\n\nWłaściciel: %CLIENT_NICKNAME%\n\nData utworzenia: %DATE%\n\n[hr]', //Opis kanału %CLIENT_NICKNAME% - Nick właściciela kanału %DATE% - Data założenia %HOUR% - Godzina założenia
			'setting'	=> [
				'channel_flag_permanent' 					=> 1,
				'channel_flag_maxfamilyclients_unlimited' 	=> 1,
				'channel_flag_maxclients_unlimited' 		=> 1,
				'channel_maxclients'						=> '-1',
				'channel_maxfamilyclients' 					=> '-1',
				'channel_password' 							=> '',
				'channel_codec'								=> 4,
				'channel_codec_quality'						=> 6,
				'channel_flag_semi_permanent'				=> 0,					'channel_needed_talk_power'					=> 0,
			],	//Dodatkowe ustawienia kanału głównego.
			'setting_subchannel'	=> [
				'channel_flag_permanent' 					=> 1,
				'channel_flag_maxfamilyclients_unlimited' 	=> 1,
				'channel_flag_maxclients_unlimited' 		=> 1,
				'channel_maxclients' 						=> '-1',
				'channel_maxfamilyclients'					=> '-1',
				'channel_topic' 							=> '',
				'channel_codec'								=> 4,
				'channel_codec_quality'						=> 6,
				'channel_flag_semi_permanent'				=> 0,
				'channel_needed_talk_power'					=> 0,
			],	//Dodatkowe ustawienia podkanałów.
			'separator'		=> '. '	//Separator oddzielający nazwę kanału od numeru.
		],

		//ChanneMessege() Funkcja wysyła wiadomość po wejściu na kanał o podanym ID
		'functions_ChanneMessege' => [
			'on'	=> true,	//true - włączona false - wyłączona
			'inst'	=> 3, //ID Instancji 
			'cid'	=> [
				1 => [	//ID kanału.
					'type' => 1,	//Typ 1 - wiadomość na pw 2 - poke
					'text' =>'Wiadomość testowa wysłana na PW'	//Treść wiadomości którą ma otrzymać
				],
				2 => [	//ID kanału.
					'type' => 2,	//Typ 1 - wiadomość na pw 2 - poke
					'text' =>'Wiadomość testowa wysłana w poke'	//Treść wiadomości którą ma otrzymać
				]
			]
		],

		//ChanneMessege() Funkcja wysyła wiadomość po wejściu na kanał o podanym ID
		'functions_ChanneMessege' => [
			'on'	=> true,	//true - włączona false - wyłączona
			'inst'	=> 3, //ID Instancji 
			'cid'	=> [
				6117 => [	//ID kanału.
					'type' => 1,	//Typ 1 - wiadomość na pw 2 - poke
					'text' =>'Witaj na kanale boskiego Majcona!'	//Treść wiadomości którą ma otrzymać
				],
				5852 => [	//ID kanału.
					'type' => 2,	//Typ 1 - wiadomość na pw 2 - poke
					'text' =>'Może kiedyś pogadacie ;)'	//Treść wiadomości którą ma otrzymać
				]
			]
		],

	//ChannelNumber() Funkcja sprawdza i w razie, czego poprawia numer kanału.
		'functions_ChannelNumber' => [
			'on'			=> false,	//true - włączona false - wyłączona
			'inst'			=> 1, //ID Instancji 
			'pid'			=> 2,	//Strefa, w której ma sprawdzać numery.
			'separator'		=> '. '	//Separator oddzielający nazwę kanału od numeru.
		],

	//CleanChannel() Funkcja czyści kanały, które nie są aktywne dłużej niż x dni w podanym sektorze.
		'functions_CleanChannel' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 1, //ID Instancji 
			'pid'	=> 2,	//Strefa, w której ma sprawdzać kanały, które są nieaktywne.
			'time'	=> 7	//Czas w dniach, po którym ma usuwać kanał.
		],

	//ClearImg() Funkcja ususwa niebezpieczne lini z IMG.
		'functions_ClearImg' => [
			'on'		=> false,	//true - włączona false - wyłączona.
			'inst'		=> 1, //ID Instancji 
			'cp'		=> true,	//Sprawdzać kanały tymczasowe true - tak false - nie
			'pid'		=> [1, 2],	//Strefa, w której ma sprawdzać linki.
			'url'		=> [
				'google.com',
				'facebook.com'
			]	//Lista dostępnych domen.
		],

	//DdosInfo() Funkcja wysyła wiadomość gdy prawdopodobnie jest przeprowadzany atak ddos.
		'functions_DdosInfo' => [
			'on'			=> false,	//true - włączona false - wyłączona
			'inst'			=> 3, //ID Instancji 
			'gid'			=> [1, 2],	//ID Grup którym ma wysyłać wiadomość.
			'description'	=> true,	//Czy ma w opisie użytkowników z podanych wyżej ustawiać aktualny ping oraz utratę pakietów true - tak false - nie.
			'ping'			=> 60,	//Wielkość średniego pingu od którego ma wysyłać wiadomość.
			'packet'		=> 60,	//Wielkość średnich utraaconych pakietów od których ma wysyłać wiadomość
		],

	//DelInfoChannel() Funkcja ustawia w opisie kanału listę kanałów które zostana usunięte w najbliższym czasie.
		'functions_DelInfoChannel' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 1, //ID Instancji 
			'pid'		=> 2,	//Strefa, w której ma sprawdzać kanały do usunięcia.
			'cid'		=> 3,	//ID kanału w którym ma ustawiać listę kanałów.
			'time'		=> 6,	//Czas, po którym ma ustawić kanał w opisie czyli jeżeli kanały są usuwane po 7 dniach można ustawić 6 wtedy jeżeli kanał jest nieaktywny dłużej niż 6 dni trafia do opisu.
			'counter'	=> 1	//Czy ma zmieniać nazwę kanału i ustawiać liczbę nieaktywnych kanałów 1 - tak 0 - nie.
		],

	//DelPermissions() Funkcja sprawdza i w razie, czego poprawia numer kanału.
		'functions_DelPermissions' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 1, //ID Instancji 
			'gid'		=> [
				0	//Strefa, w której ma sprawdzać numery.
			],
			'cldbid'	=> [
				6	//Separator oddzielający nazwę kanału od numeru.
			]
		],

	//DelRank() Funkcja usuwa range po wejściu na kanał.
		'functions_DelRank' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 1, //ID Instancji 
			'cid_gid'	=> [
				1 => 2	//ID kanału, na który trzeba wejść wraz z ID rangi, którą ma zabrać po wejściu.
			]
		],

	//groupOnline() Funkcja wyświetla listę osób z podanej grupy w opisie na kanale o podanym ID.
		'functions_GroupOnline' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 2, //ID Instancji 
			'cid'       => [
				1 => [	//ID Kanału.
					'gid' => [
						2	=> '[CENTER][SIZE=16][COLOR=#A12364][B]CEO[/B][/COLOR][/SIZE][/CENTER]\n',
						3	=> '[CENTER][SIZE=16][COLOR=#A12364][B]SA[/B][/COLOR][/SIZE][/CENTER]\n',
						4	=> '[CENTER][SIZE=16][COLOR=#A12364][B]NA[/B][/COLOR][/SIZE][/CENTER]\n'
					],	//ID kanału, na którym ma być zmieniany opis oraz nazwa grupy.
					'title' => '[CENTER][B][COLOR=#ff0000][SIZE=17]Administracja TS3[/SIZE][/COLOR][/B][/CENTER]\n\n',
					'channel_name' => '[cspacer]▪ Administracja ({1} Online) ▪',	//Nazwa kanału {1} - oznacza liczbę online {2} - oznacza łączną liczbę osób.
					'name_online' => true,	//Czy ma zmieniać nazwę kanału.
					'time_info' => true,	//Czy ma wyświetlać czas offline
					'channel_info' => true	//Czy ma wyświetlać nazwę kanału.
				]
			]
		],

	//Lvl() Funkcja .
	'functions_Lvl' => [
		'on'	=> false,	//true - włączona false - wyłączona
		'inst'	=> 2, //ID Instancji 
		'lvl'	=> [
			1 => ['exp' => 0, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 1 lvl'],
			2 => ['exp' => 100, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 2 lvl'],
			3 => ['exp' => 200, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 3 lvl'],
			4 => ['exp' => 300, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 4 lvl'],
			5 => ['exp' => 500, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 5 lvl'],
			6 => ['exp' => 800, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 6 lvl'],
			7 => ['exp' => 1300, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 7 lvl'],
			8 => ['exp' => 2100, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 8 lvl'],
			9 => ['exp' => 3400, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 9 lvl'],
			10 => ['exp' => 5500, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 10 lvl'],
			11 => ['exp' => 8900, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 11 lvl'],
			12 => ['exp' => 14400, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 12 lvl'],
			13 => ['exp' => 23300, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 13 lvl'],
			14 => ['exp' => 37700, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 14 lvl'],
			15 => ['exp' => 61000, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 15 lvl'],
			16 => ['exp' => 98700, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 16 lvl'],
			17 => ['exp' => 159700, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 17 lvl'],
			18 => ['exp' => 258400, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 18 lvl'],
			19 => ['exp' => 418100, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 19 lvl'],
			20 => ['exp' => 676500, 'gid' => 1, 'text' => 'Gratulacje właśnie awansowałeś na 20 lvl']
		],//	Lvl wymagany exp oraz ID grupy, która ma nadać.
		'group' => true,	//Czy ma nadawać grupę true - tak false -nie.
		'required_group' => [1, 2],	//Wymagana ranga żeby dostać rangę lvl.
		'top_list' => true,	//Czy ma ustawiać TOP w opisie kanału.
		'cid' => 1,	//ID kanału gdzie ma wyświetlać top.
		'gid'		=> [
			1, 2
		],	//ID grupy, której ma nie wyświetlać w topce.
		'cldbid'	=> [
			1, 2, 3
		],	//Client database id użytkowników, których ma nie wyświetlać w topce np. MusicBOT czy też ten bot.
		'limit'		=> 20	//Limit osób, które ma wyświetlać w top.
	],

	//limitIP() Funkcja wyrzuca użytkowników, jeżeli osiągną limit połączeń z tego samego IP.
		'functions_LimitIP' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 1, //ID Instancji 
			'client_unique_identifier'	=> [
				'G1MUSIS0ZAFAFAFA+CkIfow=', 'TMJaj/eXYJsFAFAFAFAFxopUg8=', 'q3xncNeBAFAFAFAFRyB9LjcdAo='
			],	//Unique identifier użytkownika, którego ma nie wyrzucać za limit.
			'gid'	=> '1,2,3',	//ID Group, które ma nie wyrzucać za limit.
			'limit'	=> 3	//Limit kont z tym samym IP.
		],

	//MoveAfk() Funkcja przenosi nieaktywne osoby na kanał o podanym ID.
		'functions_MoveAfk' => [
			'on'				=> false,	//true - włączona false - wyłączona
			'inst'				=> 2, //ID Instancji 
			'cid'				=> 1,	//ID kanału, na który ma przenosić.
			'default_channel'	=> 2,	//ID kanału w razie wywalenia błędu (polecam podać poczekalnie).
			'gid'				=> [
				3, 4	
			],	//ID grup odporne na afk.
			'cidaa'				=> [
				5, 6	
			],	//ID kanałów, na których można być AFK.
			'input_muted'		=> 1,	//Czy ma przenosić za wyłączony mikrofon.
			'output_muted'		=> 1,	//Czy ma przenosić za wyłączony głośnik.
			'away'				=> 1,	//Czy ma przenosić za włączenie statusu AFK.
			'idle'				=> 1,	//Czy ma przenosić za czas bezczynności.
			'idle_time'			=> 900,	//Czas bezczynności w sekundach.
		],

	//NewUser() Funkcja dodaje nowych użytkowników do opisu.
		'functions_NewUser' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 1, //ID Instancji 
			'cid'		=> 2,	//ID kanału, na którym ma ustawiać liste nowych użytkowników.
			'time'		=> 86400,	//Czas w sekundach od którego ma.
			'counter'	=> 1	//Czy ma zmieniać nazwę kanału i ustawiać liczbę nowych użytkowników 1 - tak 0 - nie.
		],

	//Points() Funkcja zlicza punkty za przebywanie na serwerze.
		'functions_Points' => [
			'on'	=> true,	//true - włączona false - wyłączona
			'inst'	=> 2, //ID Instancji 
			'top_list' => true,	//Czy ma ustawiać TOP w opisie kanału.
			'cid' => 1,	//ID kanału gdzie ma wyświetlać top.
			'gid'		=> [
				1, 2
			],	//ID grupy, której ma nie wyświetlać w topce.
			'cldbid'	=> [
				1, 2, 3
			],	//Client database id użytkowników, których ma nie wyświetlać w topce np. MusicBOT czy też ten bot.
			'limit'		=> 20	//Limit osób, które ma wyświetlać w top.
		],

	//Poke() Funkcja puka podane grupy jeżeli ktoś wbije na podany kanał.
		'functions_Poke' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 1, //ID Instancji 
			'cid'	=> [
				1 => [
					'gid'				=> [ 1, 2, 3 ],	//ID Grup, które ma pukać.
					'info_admin'		=> 1,	//Czy oprócz wiadomości na PW ma jeszcze pukać admina 1 – Tak 0 – Nie.
					'info_user'			=> 1,	//Czy ma informować graczy za pomocą poke czy msg.
					'cidafk'			=> [ 4, 5 ],	//ID kanałów AFK, które wykluczają admina z poke
					'anty_gid'			=> [ 6 ],	//ID grup, które wykluczają admina z poke.
					'input_muted'		=> 1,	//Czy ma pukać, gdy admin ma wyłączony mikrofon.
					'output_muted'		=> 1,	//Czy ma pukać, gdy admin ma wyłączony głośnik.
					'away'				=> 1,	//Czy pukać, gdy admin ma wyłączony statusu AFK.
				],
				2 => [
					'gid'				=> [ 1, 2, 3 ],
					'info_admin'		=> 1,
					'info_user'			=> 1,
					'cidafk'			=> [ 4, 5 ],
					'anty_gid'			=> [ 6 ],
					'input_muted'		=> 1,	//Czy pukać, gdy admin ma wyłączony mikrofon.
					'output_muted'		=> 1,	//Czy pukać, gdy admin ma wyłączony głośnik.
					'away'				=> 1,	//Czy pukać, gdy admin ma wyłączony statusu AFK.
				],
				3 => [
					'gid'				=> [ 1, 2, 3 ],
					'info_admin'		=> 1,
					'info_user'			=> 1,
					'cidafk'			=> [ 4, 5 ],
					'anty_gid'			=> [ 6 ],
					'input_muted'		=> 1,	//Czy mpukać, gdy admin ma wyłączony mikrofon.
					'output_muted'		=> 1,	//Czy pukać, gdy admin ma wyłączony głośnik.
					'away'				=> 1,	//Czy pukać, gdy admin ma wyłączony statusu AFK.
				]
			],
			'admin_time'		=> 120,
			'user_time'			=> 120
		],

	//Register() Funkcja automatycznie rejestruje użytkownika gdy on wbije na podane id kanału.
		'functions_Register' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 1, //ID Instancji 
			'gidm'	=> 2,	//ID grupy zarejestrowanego.
			'cidm'	=> 3,	//ID kanału zarejestrowanego.
			'gidk'	=> 4,	//ID grupy zarejestrowanej.
			'cidk'	=> 5	//ID kanału zarejestrowanej.
		],

	//RekordOnline() Funkcja ustawia rekord osób online jako nazwa kanału o podanym ID.
		'functions_RekordOnline' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 2, //ID Instancji 
			'cid'		=> 1,	//ID kanału, na którym ma ustawiać rekord osób online.
			'format'	=> 'd.m.Y H:i:s'	//Format daty.
		],

	//SendAd() Funkcja wysyła losową wiadomość na serwerze co określony czas.
		'functions_SendAd' => [
			'on'			=> false,	//true - włączona false - wyłączona.
			'inst'			=> 1, //ID Instancji 
			'time'			=> 10,	//Czas w minutach po jakim ma wysyłać losową wiadomość.
			'txt_group'		=> [
				['Testowa wiadomość od bota na serwerze' =>	[ -0 ]],
				['Testowa wiadomość od bota na pw' =>	[ 0 ]],
				['Testowa wiadomość do grup' =>	[ 1, 2, 3 ]]
			]	//Treść oraz gdzie i do jakich grup ma wysyłać wiadomość -1 - Wiadomość jest wysyłana na czacie serwera 0 - Wiadomość jest wysyłana do wszytkich na PW 
		],

	//ServerName() Funkcja ustawia nazwę serwera wraz z liczbą osób online.
		'functions_ServerName' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 2, //ID Instancji 
			'name'	=> 'Okoń ({1}/32)'	//Nazwa serwera, {1} zostanie zmienione na liczbę osób online.
		],

	//SprChannel() Funkcja sprawdza nazwy kanału pod względem wulgaryzmów.
		'functions_SprChannel' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 1, //ID Instancji 
			'cp'		=> true,	//Czy ma sparawdzac kanały tymczasowe true - tak false - nie
			'pid'		=> [ 1 ],	//Strefy, w której ma sprawdzać kanały, które zawierają wulgaryzmy w nazwie.
			'setting'	=> 0,	//0 - Zmiana nazwy 1 - Usunięcie kanału.
			'new_name'	=> 'Cenzura',	//Nazwa kanału jaką ma ustawić po edycji.
		],

	//SprNick() Funkcja sprawdza nicki użytkowników pod względem wulgaryzmów.
		'functions_SprNick' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 1, //ID Instancji 
			'slowa'	=> [
				'majcon', 'admin', 'root', 'ceo'
			],	//Dodatkowe słowa do cenzora słów.
			'gid'	=> [
				1, 2, 3
			]	//ID grup, które ma nie wyrzucać.
		],

	//StatusTwitch() Funkcja ustawia w opisie status na kanale twitch.
		'functions_StatusTwitch' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 2, //ID Instancji 
			'apikay'	=> '', //Klucz API uzyskasz go na  https://dev.twitch.tv/console/apps
			'secret'	=> '', //Hasło klienta uzyskasz je na  https://dev.twitch.tv/console/apps wchodząc w zarządzanie aplikacją.
			'cid_name'	=> [
				1 => [	//ID kanału w którym ma ustawiać opis oraz nazwę.
					'users' => 'kayser',	//Nick osoby na twitchu.
					'channel_name' => '[cspacer8] Stream kayserv {1}',	//Nazwa kanału jaką ma ustawiać {1} jest zamienianę na online lub offline.
					'info'	=>	true, //Czy ma wysyłać informacje o tym, że użytkownik rozpoczął transmisję live true - tak false - nie 
					'info_text' => 'Hejka {1} właśnie odpalił live {2} Zapraszamy!' //Tekst, który ma wysyłać gdy użytkownik odpali live {1} - nick {2} - link do kanału
				]
			]

		],
		
	//StatusYt() Funkcja ustawia w opisie status na kanale twitch.
		'functions_StatusYt' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 2, //ID Instancji 
			'key'		=> 'AIzaSyDdCIT6ptA0fdvCb6CwE5-jbUUqHeKKJrY',	//Klucz api
			'cid_id'	=> [
				1 => 'UCb9PGfYb_Cv1ysuENPIAvRQ'
			]	//ID kanału oraz ID kanału
		],

	//TopActivityTime() Funkcja ustawia w opisie kanału o podanym ID TOP 10 aktywnych użytkowników.
		'functions_TopActivityTime' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 2, //ID Instancji 
			'cid'		=> 1,	//ID kanału, w którym ma ustawiać TOP 10 online.
			'gid'		=> [
				2, 3
			],	//ID grupy, której ma nie wyświetlać w topce.
			'cldbid'	=> [
				1, 4, 5
			],	//Client database id użytkowników, których ma nie wyświetlać w topce np. MusicBOT czy też ten bot.
			'limit'		=> 20	//Limit osób, które ma wyświetlać w top.
		],

	//TopConnections() Funkcja ustawia w opisie kanału o podanym ID TOP 10 połączeń z serwerem.
		'functions_TopConnections' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 2, //ID Instancji 
			'cid'		=> 1,	//ID kanału, w którym ma ustawiać TOP 10 online.
			'gid'		=> [
				2, 3
			],	//ID grupy, której ma nie wyświetlać w topce.
			'cldbid'	=> [
				1, 4, 5
			],	//Client database id użytkowników, których ma nie wyświetlać w topce np. MusicBOT czy też ten bot.
			'limit'		=> 20	//Limit osób, które ma wyświetlać w top.
		],

	//TopLongestConnection() Funkcja ustawia w opisie kanału o podanym ID TOP 10 połączeń z serwerem.
		'functions_TopLongestConnection' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'	=> 	2, //ID Instancji 
			'cid'		=> 1,	//ID kanału, w którym ma ustawiać TOP 10 online.
			'gid'		=> [
				2, 3
			],	//ID grupy, której ma nie wyświetlać w topce.
			'cldbid'	=> [
				1, 4, 5, 6, 7
			],	//Client database id użytkowników, których ma nie wyświetlać w topce np. MusicBOT czy też ten bot.
			'limit'		=> 20	//Limit osób, które ma wyświetlać w top.
		],
	
	//Visit() Funkcja ustawia rekord osób online jako nazwa kanału o podanym ID.
		'functions_Visit' => [
			'on'		=> false,	//true - włączona false - wyłączona
			'inst'		=> 2, //ID Instancji 
			'cid'		=> 1,	//ID kanału, na którym ma ustawiać liczbe osób odwiedzających.
		],

		//WelcomeMessege() Funkcja wysyła wiadomość powitalną.
		/*Dostępne zmienne
			%CLIENT_IP% - Adres IP
			%CLIENT_UNIQUE_ID% - Identyfikator użytkownika 
			%CLIENT_DATABASE_ID% - Database ID klienta
			%CLIENT_ID% - ID klienta
			%CLIENT_CREATED% - Data pierwszego wejścia na serwer klienta
			%CLIENT_COUNTRY% - Państwo klienta
			%CLIENT_VERSION% - Wersja TS klienta
			%CLIENT_PLATFORM% - System klienta
			%CLIENT_NICKNAME% - Nazwa klienta
			%CLIENT_TOTALCONNECTIONS% - Liczba wszystkich połączeń klienta
			%CLIENT_LASTCONNECTED% - Ostatnie połączenie klienta
			%CLIENTONLINE% - Liczba osób online na serwerze
			%MAXCLIENT% - Maksymalna liczba osób online na serwerze
			%SERVER_UPTIME% - Czas pracy serwera
			%HOUR% - Godzina
			%DATE% - Data
			%TOP_CONNECTIONS% - Miejsce w TOP połączeń klienta
			%CONNECTIONS% - Liczba wszystkich połączeń klienta
			%TOP_ACTIVITY% - Miejsce w TOP aktywności klienta
			%ACTIVITY_TIME% - Czas aktywności klienta
			%TOP_LONGEST_CONNECTION% - Miejsce w TOP najdłuższego połączenia klienta
			%LONGEST_CONNECTION% - Czas najdłuszego połączenia klienta
			%TOP_LVL% - Miejsce w TOP LVL klienta
			%LVL% - LVL klienta
			%EXP%' -EXP klienta
			Możesz użyć || żeby oddzielić wiadomości naprzykład Test||test
		*/
		'functions_WelcomeMessege' => [
			'on'	=> false,	//true - włączona false - wyłączona
			'inst'	=> 1, //ID Instancji 
			'gid_mess'	=> [
				1 => '[b]Witaj admin [color=blue]%CLIENT_NICKNAME%[/color] [color=red][/color] na serwerze [color=blue]TS3[/color].
				Wpadłeś do nas [color=blue]%CLIENT_TOTALCONNECTIONS%[/color] raz z [color=blue]%CLIENT_COUNTRY%[/color].
				Twoje IP: [color=blue]%CLIENT_IP%[/color].
				Aktualnie OnLine: [color=green]%CLIENTONLINE%[/COLOR]/[color=blue]%MAXCLIENT%[/COLOR]
				Jeżeli potrzebujesz pomocy napisz do mnie wiadomość. :) 
				Lista moich funkcji otrzymasz po napisaniu „Co potrafisz”.',
				2 => '[b][color=blue]%CLIENT_NICKNAME%[/color], witaj [color=red][/color] na serwerze [color=blue]TS3[/color].
				Jesteś nowym użytkownikiem, więc skorzystaj z kanału
				[URL=channelID://118]Zarejestrowana - Dziewczyna[/URL], aby się zarejestrować jako dziewczyna lub
				[URL=channelID://117]Zarejestrowany - Chłopak[/URL], aby się zarejestrować jako chłopak
				Twoje IP: [color=blue]%CLIENT_IP%[/color].
				Aktualnie OnLine: [color=green]%CLIENTONLINE%[/COLOR]/[color=blue]%MAXCLIENT%[/COLOR]
				Jeżeli potrzebujesz pomocy napisz do mnie wiadomość. :) 
				Lista moich funkcji otrzymasz po napisaniu „Co potrafisz”.'	//ID grupy oraz wiadomość którą ma dostać.
			],
			'remainder'	=> '[b]Witaj [color=blue]%CLIENT_NICKNAME%[/color] [color=red][/color] na serwerze [color=blue]TS3[/color].
			Wpadłeś do nas [color=blue]%CLIENT_TOTALCONNECTIONS%[/color] raz z [color=blue]%CLIENT_COUNTRY%[/color].
			Twoje IP: [color=blue]%CLIENT_IP%[/color].
			Aktualnie OnLine: [color=green]%CLIENTONLINE%[/COLOR]/[color=blue]%MAXCLIENT%[/COLOR]
			Jeżeli potrzebujesz pomocy napisz do mnie wiadomość. :) 
			Lista moich funkcji otrzymasz po napisaniu „Co potrafisz”.'	//Wiadomość dla pozostałych.
		]
	];
?>
