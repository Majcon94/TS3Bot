<?php

	return [

		'command' => [
			'on'	=> true	//true - włączona false - wyłączona
		],

		'admin' => [
            'uid'	=> '0ycSJ9zGGGSGSGSfnlmbtLwgA='	//UID Admina
		],

		'functions_kobieta' => [
			'gid'	=>	1,	//ID grupy, którą ma nadać.
			'bgid'	=>	[2,3]	//ID grup, których nie można posiadać, aby otrzymać grupę (np. Mężczyzna).
		],

		'functions_mezczyzna' => [
			'gid'	=>	1,	//ID grupy, którą ma nadać.
			'bgid'	=>	[2,3]	//ID grup, których nie można posiadać, aby otrzymać grupę (np. Kobieta).
		],

		'functions_channelpin' => [
			'gid'	=>	[
				1	//ID Grup które mają dostęp do IP.
			]
		],

		'functions_kobieta' => [
			'gid'	=>	[
				1	//ID Grup które mają dostęp do IP.
			]
		],

		'functions_givegroup' => [
			'global_limit'  => 7,
			'limit'		    => [
				[
					'limit'	=> 1,	//Limit grup.
					'name'  => 'Wiekowe',	//Nazwa działu.
					'gid'   => [
							1, 2, 3, 	//ID Grup.
						]
				],
				[
					'limit'	=> 1,	//Limit grup.
					'name'  => '4Fun',	//Nazwa działu.
					'gid'   => [
							1, 2, 3	//ID Grup.
						]
				],
				[
					'limit'	=> 1,	//Limit grup.
					'name'  => 'Gry',	//Nazwa działu.
					'gid'   => [
							1, 2, 3	//ID Grup.
						]
				]
			]

		],

		'functions_delgroup' => [
			'gid'   => [
				1, 2, 3	//ID Grup.
			]
		],

		'functions_userinfo' => [
			'gid'	=>	[
				1	//ID Grup które mają dostęp do IP.
			]
		]
    ];

?>