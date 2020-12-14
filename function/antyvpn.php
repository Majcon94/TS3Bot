<?php

	class AntyVpn extends Command {

		public static $online_antyvpn = [];

		public function execute(): void
		{
			$aktualnie_online = [];
			foreach($this->bot->getClientList() as $cl){
				if($cl['client_type'] == 0 && !in_array($cl['client_unique_identifier'], $this->config['functions_AntyVpn']['client_unique_identifier']) && !array_intersect(explode(',', $cl['client_servergroups']), explode(',', $this->config['functions_AntyVpn']['gid']))) {
					$aktualnie_online[$cl['clid']] = $cl['connection_client_ip'];
				}
			}
			$array_diff = array_diff($aktualnie_online, self::$online_antyvpn);
			if(!empty($array_diff)){
				foreach($array_diff as $key => $value){
					if(!empty($value)){
						$check = 0;
						$proxy = 0;
						$query = self::$db->query("SELECT COUNT(id) as `count`, `proxy`, `time` FROM `ip` WHERE `ip` = '{$value}' GROUP BY `id`");
						try {
							while($row = $query->fetch()){
								$count = $row['count'];
								if($count != 0){
									$proxy = $row['proxy'];
									if($row['proxy'] == 3 || $row['time']+2592000 < time()){
										$check = 1;
									}
								}else{
									$check = 1;
								}
							}
						} catch (PDOException $e) {
							$check = 1;
							$this->log(1, $e->getMessage());
						}
						if($check == 1){
							$ch = curl_init();
							curl_setopt_array($ch, [
								CURLOPT_URL => "http://v2.api.iphub.info/ip/{$value}",
								CURLOPT_RETURNTRANSFER => true,
								CURLOPT_HTTPHEADER => ["X-Key: {$this->config['functions_AntyVpn']['key']}"]
							]);
							$data = json_decode(curl_exec($ch));
							if(isset($data->block)){;
								$proxy = $data->block;
							}else{
								$proxy = 3;
							}
							if($count == 0){
								self::$db->query("INSERT INTO `ip` VALUES (NULL, '{$value}', {$proxy}, ".time().")");
							}else{
								self::$db->query("UPDATE `ip` SET `proxy` = {$proxy}, time = ".time()." WHERE `ip` = '{$value}'");
							}
						}
						if($proxy == 1){
							$clientInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientInfo($key));
							self::$tsAdmin->clientKick($key, 'server', self::$l->success_kick_AntyVpn);
							$this->bot->log(2, 'Wyrzucono (client_nickname: '.$clientInfo['client_nickname'].') za używanie VPN.');
							unset($aktualnie_online[$key]);
						}
					}
				}
				self::$online_antyvpn = $aktualnie_online;
			}
		}
	}

?>