<?php

	class Command {

		public $bot;
		public static $db;
		public $config;
		public $configcmd;
		public $inst;
		public $clientlist;
		public static $tsAdmin;
		public static $l;

		public function __construct($bot)
		{
			$this->bot = $bot;
			$this->config = $bot->config;
			$this->configcmd = $bot->configcmd;
			$this->inst = $bot->inst;
			$this->clientlist = $bot->getClientList();
			self::$tsAdmin = $bot->getTsAdmin();
			self::$l = $bot->getLang();
			self::$db = $bot->getDb();
		}

	}

?>