<?php

	class WelcomeMessege extends Command {

		private static $welcome_messege_list = [];
		private static $whetherToSend = 0;
		private $clientInfo = NULL;

		public function execute(): void
		{
			$listOfUser = [];
			foreach($this->bot->getClientList() as $cl) {
				if($cl['client_type'] == 0) {
					$listOfUser[] = $cl['clid'];
				}
			}
			$nowi = array_diff($listOfUser, self::$welcome_messege_list);
			if(!empty($nowi)){
				if(self::$whetherToSend == 1){
					foreach($nowi as $n) {
						$wyslano = 0;
						$this->clientInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientInfo($n));
						if($this->clientInfo['client_servergroups']){
							$grupy =  explode(',', $this->clientInfo['client_servergroups']);
							foreach($this->config['functions_WelcomeMessege']['gid_mess'] as $key => $value){
								if(in_array($key, $grupy)){
									$this->bot->sendMessage($n, $this->replaceMes($value));
									$wyslano = 1;
								}
							}
							if($wyslano == 0){
								$this->bot->sendMessage($n, $this->replaceMes($this->config['functions_WelcomeMessege']['remainder']));
							}
						}
					}
				}else{
					self::$whetherToSend = 1;
				}
				self::$welcome_messege_list = $listOfUser;
			}
		}
		
		private function replaceMes($messege): string
		{
			$serverinfo = $this->bot->getServerInfo();
			$data = $this->bot->przelicz_czas($serverinfo['virtualserver_uptime']);
			$txt_time = $this->bot->wyswietl_czas($data, 1, 1, 1, 0, 0);
			if(!empty($this->config['functions_TopLongestConnection']['cldbid'])){
				$cldbid_config = implode(",", $this->config['functions_TopLongestConnection']['cldbid']);
			}
			if(!empty($this->config['functions_TopLongestConnection']['gid'])){
				$gid_config = implode("(,|$)|", $this->config['functions_TopLongestConnection']['gid']).'(,|$)';
			}
			$query = Bot::$db->query("SELECT `longest_connection`, (SELECT COUNT(*) FROM `users` WHERE `longest_connection` >= (SELECT `longest_connection` FROM `users` WHERE `cui` = '{$this->clientInfo['client_unique_identifier']}') AND `cldbid` NOT IN({$cldbid_config}) AND `gid` NOT REGEXP '^({$gid_config})') as `count` FROM `users` WHERE `cui` = '{$this->clientInfo['client_unique_identifier']}'");
			while($row = $query->fetch()){
				$toplc = $row['count'];
				$longest_connection = $this->bot->przelicz_czas($row['longest_connection']/1000);
				$longest_connection = $this->bot->wyswietl_czas($longest_connection, 1, 1, 1, 0, 0);
			}
			
			if(!empty($this->config['functions_TopActivityTime']['cldbid'])){
				$cldbid_config = implode(",", $this->config['functions_TopActivityTime']['cldbid']);
			}
			if(!empty($this->config['functions_TopActivityTime']['gid'])){
				$gid_config = implode("(,|$)|", $this->config['functions_TopActivityTime']['gid']).'(,|$)';
			}
			$query = Bot::$db->query("SELECT `time_activity`, (SELECT COUNT(*) FROM `users` WHERE `time_activity` >= (SELECT `time_activity` FROM `users` WHERE `cui` = '{$this->clientInfo['client_unique_identifier']}') AND `cldbid` NOT IN({$cldbid_config}) AND `gid` NOT REGEXP '^({$gid_config})') as `count` FROM `users` WHERE `cui` = '{$this->clientInfo['client_unique_identifier']}'");
			while($row = $query->fetch()){
				$topa = $row['count'];
				$time_activity = $this->bot->przelicz_czas($row['time_activity'], 1);
				$time_activity = $this->bot->wyswietl_czas($time_activity, 1, 1, 1, 0, 0);
			}

			if(!empty($this->config['functions_TopConnections']['cldbid'])){
				$cldbid_config = implode(",", $this->config['functions_TopConnections']['cldbid']);
			}
			if(!empty($this->config['functions_TopConnections']['gid'])){
				$gid_config = implode("(,|$)|", $this->config['functions_TopConnections']['gid']).'(,|$)';
			}
			$query = Bot::$db->query("SELECT `connections`, (SELECT COUNT(*) FROM `users` WHERE `connections` >= (SELECT `connections` FROM `users` WHERE `cui` = '{$this->clientInfo['client_unique_identifier']}') AND `cldbid` NOT IN({$cldbid_config}) AND `gid` NOT REGEXP '^({$gid_config})') as `count` FROM `users` WHERE `cui` = '{$this->clientInfo['client_unique_identifier']}'");
			while($row = $query->fetch()){
				$topc = $row['count'];
				$connections = $row['connections'];
			}

			if(!empty($this->config['functions_Lvl']['cldbid'])){
				$cldbid_config = implode(",", $this->config['functions_Lvl']['cldbid']);
			}
			if(!empty($this->config['functions_Lvl']['gid'])){
				$gid_config = implode("(,|$)|", $this->config['functions_Lvl']['gid']).'(,|$)';
			}
			$query = Bot::$db->query("SELECT `lvl`, `exp`, (SELECT COUNT(*) FROM `users` WHERE `exp` >= (SELECT `exp` FROM `users` WHERE `cui` = '{$this->clientInfo['client_unique_identifier']}') AND `cldbid` NOT IN({$cldbid_config}) AND `gid` NOT REGEXP '^({$gid_config})') as `count` FROM `users` WHERE `cui` = '{$this->clientInfo['client_unique_identifier']}'");
			while($row = $query->fetch()){
				$topl = $row['count'];
				$exp = $row['exp'];
				$lvl = $row['lvl'];
			}

			$search = [
				'%CLIENT_IP%',
				'%CLIENT_UNIQUE_ID%',
				'%CLIENT_DATABASE_ID%',
				'%CLIENT_ID%',
				'%CLIENT_CREATED%',
				'%CLIENT_COUNTRY%',
				'%CLIENT_VERSION%',
				'%CLIENT_PLATFORM%',
				'%CLIENT_NICKNAME%',
				'%CLIENT_TOTALCONNECTIONS%',
				'%CLIENT_LASTCONNECTED%',
				'%CLIENTONLINE%',
				'%MAXCLIENT%',
				'%SERVER_UPTIME%',
				'%HOUR%',
				'%DATE%',
				'%TOP_CONNECTIONS%',
				'%CONNECTIONS%',
				'%TOP_ACTIVITY%',
				'%ACTIVITY_TIME%',
				'%TOP_LONGEST_CONNECTION%',
				'%LONGEST_CONNECTION%',
				'%TOP_LVL%',
				'%LVL%',
				'%EXP%'

			];
			$replace = [
				$this->clientInfo['connection_client_ip'],
				$this->clientInfo['client_unique_identifier'],
				$this->clientInfo['client_database_id'],
				$this->clientInfo['clid'] ?? 0,
				date("H:i d.m.Y", $this->clientInfo['client_created']),
				$this->clientInfo['client_country'],
				$this->clientInfo['client_version'],
				$this->clientInfo['client_platform'],
				$this->clientInfo['client_nickname'],
				$this->clientInfo['client_totalconnections'],
				date("H:i d.m.Y",$this->clientInfo['client_lastconnected']),
				$serverinfo['virtualserver_clientsonline'] - $serverinfo['virtualserver_queryclientsonline'],
				$serverinfo['virtualserver_maxclients'],
				$txt_time,
				date('H:i'),
				date('d.m.Y'),
				$topc ?? 'b/d',
				$connections ?? 'b/d',
				$topa ?? 'b/d',
				$time_activity ?? 'b/d',
				$toplc ?? 'b/d',
				$longest_connection ?? 'b/d',
				$topl ?? 'b/d',
				$lvl ?? 'b/d',
				$exp ?? 'b/d'
			];
			return str_replace($search, $replace, $messege);
		}
	}

?>