<?php

	class Register extends Command {

		public static $channelNumberTime = 0;

		public function execute(): void
		{
			foreach($this->bot->getClientList() as $cl) {
				if($cl['client_type'] == 0) {
					$rangiexplode = explode(',', $cl['client_servergroups']);
					if(!in_array($this->config['functions_Register']['gidm'], $rangiexplode) && !in_array($this->config['functions_Register']['gidk'], $rangiexplode)){
						if($cl['cid'] == $this->config['functions_Register']['cidm']){
							$serverGroupAddClient = self::$tsAdmin->serverGroupAddClient($this->config['functions_Register']['gidm'], $cl['client_database_id']);
							if(!empty($serverGroupAddClient['errors'][0])){
								$this->bot->log(1, 'Grupa o ID:'.$this->config['functions_Register']['gidm'].' nie istnieje Funkcja: register()');
							}
							$this->bot->log(2, 'Zarejestrowano nick name: '.$cl['client_nickname']);
						}
						if($cl['cid'] == $this->config['functions_Register']['cidk']){
							$serverGroupAddClient = self::$tsAdmin->serverGroupAddClient($this->config['functions_Register']['gidk'], $cl['client_database_id']);
							if(!empty($serverGroupAddClient['errors'][0])){
								$this->bot->log(1, 'Grupa o ID:'.$this->config['functions_Register']['gidk'].' nie istnieje Funkcja: register()');
							}
							$this->bot->log(2, 'Zarejestrowano nick name: '.$cl['client_nickname']);
						}
					}
				}
			}
		}
	}

?>