<?php 

	class Bot extends Functions {

		public static $db;
		public $clientlist;
		public $serverinfo;
		public $config;
		public $configcmd;
		public $inst;
		public static $function = [];
		public static $tsAdmin;
		public static $l;

		public function __construct($inst)
		{
			$this->setConfig();
			$this->setConfigCmd();
			$this->connectToDatabase();
			$this->setLang();
			$this->setInst($inst);
			if($this->connectToTs3() == true){
				$this->loadFunction();
				do{
					$this->readChatMessage();
					$this->setClientList();
					$this->setServerinfo();
					$this->register();
					if($this->inst == 2){
						$this->update_activity();
					}
					$this->executeCommand();
					$whoami = self::$tsAdmin->getElement('data', self::$tsAdmin->whoAmI());
					sleep(1);
				} while(!empty($whoami));
			}
		}

		public function setClientList(): void
		{
			$this->clientlist = self::$tsAdmin->getElement('data', self::$tsAdmin->clientList("-groups -uid -times -ip -voice -away"));
		}

		public function setServerInfo(): void
		{
			$this->serverinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->serverInfo());
		}

		public function setConfig(): void
		{
			if(!file_exists("includes/config.php") == true) {
				die("Plik config.php nie istnieje!");
			}else{
				$this->config = require 'includes/config.php';
			}
		}

		public function setConfigCmd(): void
		{
			if(!file_exists("includes/config_cmd.php") == true) {
				die("Plik config_cmd.php nie istnieje!");
			}else{
				$this->configcmd = require 'includes/config_cmd.php';
			}
		}

		public function setLang(): void
		{
			try {
				$l = new Language();
				$l->load($this->config['bot']['language'], 'bot');
				$l->load($this->config['bot']['language'], 'command');
				$l->load($this->config['bot']['language'], 'functions');
				self::$l = $l;
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		public function setInst(int $inst): void
		{
			$this->inst = $inst;
		}

		public function getClientList()
		{
			return $this->clientlist;
		}

		public function getLang()
		{
			return self::$l;
		}

		public function getTsAdmin()
		{
			return self::$tsAdmin;
		}

		public function getServerInfo()
		{
			return $this->serverinfo;
		}

		public function getDb()
		{
			return self::$db;
		}

		public function connectToDatabase(): void
		{
			try {
				self::$db = new PDO('mysql:host='.$this->config['mysql']['host'].';dbname='.$this->config['mysql']['database'].';charset=utf8mb4;port='.$this->config['mysql']['port'], $this->config['mysql']['username'], $this->config['mysql']['password']);
				self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$db->query("SET NAMES utf8mb4");
			} catch (PDOException $e) {
				$this->log(1, $e->getMessage());
			}
		}

		public function connectToTs3(): bool
		{
			$tsAdmin = new ts3admin($this->config['server']['ip'], $this->config['server']['queryport']);
			$connect = $tsAdmin->connect();
			if($tsAdmin->getElement('success', $connect)) {
				$tsAdmin->login($this->config['server']['login'], $this->config['server']['password']);
				$tsAdmin->selectServer($this->config['server']['port']);
				$tsAdmin->setName($this->config['server']['nick'.$this->inst]);
				self::$tsAdmin = $tsAdmin;
				return true;
			}else{
				foreach($tsAdmin->getElement('errors', $connect) as $error)
				{
					$this->log(1, $error);
				}
				return false;
			}
		}

		private function loadFunction(): void
		{
			foreach($this->config as $key => $value)
			{
				if(isset($value['on'], $value['inst'])){
					if($value['on'] == true && $value['inst'] == $this->inst){
						$class_name = str_replace('functions_', '', $key);
						require_once 'function/'.mb_strtolower($class_name).'.php';
						self::$function[] = new $class_name($this);
					}
				}
			}
		}

		public function executeCommand(): void
		{
			foreach(self::$function as $fun){
				$this->readChatMessage();
				$fun->execute();
			}
		}

	}
?>