<?php

	class LimitIP extends Command {

		public static $online_LimitIP = [];

		public function execute(): void
		{
			$aktualnie_online = [];
			foreach($this->bot->getClientList() as $cl){
				if($cl['client_type'] == 0 && !in_array($cl['client_unique_identifier'], $this->config['functions_LimitIP']['client_unique_identifier']) && !array_intersect(explode(',', $cl['client_servergroups']), explode(',', $this->config['functions_LimitIP']['gid']))) {
					$aktualnie_online[$cl['clid']] = $cl['connection_client_ip'];
				}
			}
			$array_diff = array_diff_key($aktualnie_online, self::$online_LimitIP);
			if(!empty($array_diff)){
				foreach($array_diff as $key => $value){
					if(!empty($value)){
						$i = 0;
						foreach($this->bot->getClientList() as $cl2){
							if($cl2['connection_client_ip'] == $value){
								$i++;
							}
						}
						if($i > $this->config['functions_LimitIP']['limit']){
							$clientInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientInfo($key));
							self::$tsAdmin->clientKick($key, 'server', self::$l->success_kick_LimitIP);
							$this->bot->log(2, 'Wyrzucono (client_nickname: '.$clientInfo['client_nickname'].' client_database_id: '.$clientInfo['client_database_id'].') za przekroczenie limitu IP.');
							unset($aktualnie_online[$key]);
						}
					}
				}
				self::$online_LimitIP = $aktualnie_online;
			}
		}
	}

?>