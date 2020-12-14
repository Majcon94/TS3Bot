<?php

	class ChannelCreate extends Command {

		public function execute(): void
		{
			$channelClientList = self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($this->config['functions_ChannelCreate']['cid'], "-ip -uid -groups"));
			if(!empty($channelClientList)){
				foreach($channelClientList as $ccl){
					if(!empty(array_intersect(explode(',', $ccl['client_servergroups']), $this->config['functions_ChannelCreate']['cgid'])) || empty($this->config['functions_ChannelCreate']['cgid'])){
						$count = 0;
						$query = self::$db->query("SELECT COUNT(id) AS `count`, `cid` FROM `channel` WHERE `cldbid` = {$ccl['client_database_id']} GROUP BY `id`");
						while($row = $query->fetch()){
							if($row['count'] != 0 && $row['cid'] != 0){
								$channelInfo = self::$tsAdmin->channelInfo($row['cid']);
								if(empty($channelInfo['errors'])){
									if($channelInfo['data']['channel_topic'] == 'WOLNY'){
										$count = 0;
										self::$db->query("DELETE FROM `channel` WHERE `cldbid` = {$ccl['client_database_id']}");
									}else{
										$cid = $row['cid'];
										$count = 1;
									}
								}else{
									$count = 0;
									self::$db->query("DELETE FROM `channel` WHERE `cldbid` = {$ccl['client_database_id']}");
								}
							}else{
								$count= 0;
							}
						}
						if($count == 0){
							try{
								$query = self::$db->prepare("SELECT COUNT(id) AS `count` FROM `channel` WHERE `connection_client_ip` = :cci");
								$query->bindValue(':cci', $ccl['connection_client_ip'], PDO::PARAM_STR);
								$query->execute();
								while($row = $query->fetch()){
									if($row['count'] < $this->config['functions_ChannelCreate']['limit_ip'] || $this->config['functions_ChannelCreate']['limit_ip'] == 0){
										$limit_ip = 0;
									}else{
										$limit_ip = 1;
									}
								}	
							} catch (PDOException $e) {
								$this->bot->log(1, $e->getMessage());
							}
							if($limit_ip == 0){
								$zalozony = 0;
								$id = 1;
								$search = [ '%CLIENT_NICKNAME%', '%HOUR%', '%DATE%'	];
								$replace = [ $this->bot->getUrlName($ccl['client_database_id'], $ccl['client_unique_identifier'], $ccl['client_nickname']), date('H:i'), date('d.m.Y') ];
								$channellist = self::$tsAdmin->getElement('data', self::$tsAdmin->channelList('-topic'));
								foreach($channellist as $chl){
									if($chl['pid'] == $this->config['functions_ChannelCreate']['pid']){
										$id++;
										$editid = $id-1;
										if(trim($chl['channel_topic']) == 'WOLNY'){
											$data1 = [
												'channel_name' => substr($editid.$this->config['functions_ChannelCreate']['separator'].$ccl['client_nickname'], 0, 40),
												'channel_topic' => date('d.m.Y'),
												'channel_description' => str_replace($search, $replace, $this->config['functions_ChannelCreate']['channel_description']),
											];
											$data1 = array_merge($data1, $this->config['functions_ChannelCreate']['setting']);
											self::$tsAdmin->channelEdit($chl['cid'], $data1);
											if($this->config['functions_ChannelCreate']['ile'] != 0){
												for($isub = 1; $isub <= $this->config['functions_ChannelCreate']['ile']; $isub++){
													$data = [ 
														'cpid' => $chl['cid'], 'channel_name' => $isub,
													];
													$data = array_merge($data, $this->config['functions_ChannelCreate']['setting_subchannel']);
													self::$tsAdmin->channelCreate($data);
												}
											}
											self::$tsAdmin->clientMove($ccl['clid'], $chl['cid']);
											self::$tsAdmin->setClientChannelGroup($this->config['functions_ChannelCreate']['gid'], $chl['cid'], $ccl['client_database_id']);
											do {
												$pin = substr(md5(uniqid(rand())), 0, 6);
												$query = self::$db->query("SELECT COUNT(id) AS `count` FROM `channel` WHERE `pin` = '{$pin}' GROUP BY `id`");
												while($row = $query->fetch()){
													if($row['count'] == 0){
														$count = 0;
													}else{
														$count = 1;
													}
												}
											} while($count == 1);
											self::$db->query("INSERT INTO `channel` VALUES (NULL, {$ccl['client_database_id']}, {$chl['cid']}, '{$ccl['connection_client_ip']}', '{$pin}')");
											if($this->config['functions_ChannelCreate']['pin'] == true){
												self::$tsAdmin->clientPoke($ccl['clid'], self::$l->sprintf(self::$l->success_give_pin_ChannelCreate, $pin));
											}
											$this->bot->log(2, 'Założono kanał dla (nick name: '.$ccl['client_nickname'].')');
											$zalozony = 1;
											break;
										}
									}
								}
								if($zalozony == 0){
									$data1 = [
										'cpid' 						=> $this->config['functions_ChannelCreate']['pid'],
										'channel_name'				=> substr($id.$this->config['functions_ChannelCreate']['separator'].$ccl['client_nickname'], 0, 40),
										'channel_description' 		=> str_replace($search, $replace, $this->config['functions_ChannelCreate']['channel_description']),
										'channel_topic' 			=> date('d.m.Y'),
									];
									$data1 = array_merge($data1, $this->config['functions_ChannelCreate']['setting']);
									$channelCreate = self::$tsAdmin->channelCreate($data1);
									if($this->config['functions_ChannelCreate']['ile'] != 0){
										for($isub = 1; $isub <= $this->config['functions_ChannelCreate']['ile']; $isub++){
											$data = [
												'cpid' => $channelCreate['data']['cid'],
												'channel_name' => $isub, 
											];
											$data = array_merge($data, $this->config['functions_ChannelCreate']['setting_subchannel']);
											self::$tsAdmin->channelCreate($data);
										}
									}
									self::$tsAdmin->clientMove($ccl['clid'], $channelCreate['data']['cid']);
									self::$tsAdmin->setClientChannelGroup($this->config['functions_ChannelCreate']['gid'], $channelCreate['data']['cid'], $ccl['client_database_id']);
									do {
										$pin = substr(md5(uniqid(rand())), 0, 6);
										$query = self::$db->query("SELECT COUNT(id) AS `count` FROM `channel` WHERE `pin` = '{$pin}' GROUP BY `id`");
										while($row = $query->fetch()){
											if($row['count'] == 0){
												$count = 0;
											}else{
												$count = 1;
											}
										}
									} while($count == 1);
									self::$db->query("INSERT INTO `channel` VALUES (NULL, {$ccl['client_database_id']}, {$channelCreate['data']['cid']}, '{$ccl['connection_client_ip']}', '{$pin}')");
									$this->bot->log(2, 'Założono kanał dla nick name: '.$ccl['client_nickname']);
								}
							}else{
								self::$tsAdmin->clientKick($ccl['clid'], 'channel', self::$l->error_limit_channels_on_ip_ChannelCreate);
								self::$tsAdmin->clientPoke($ccl['clid'], self::$l->error_has_a_channel_poke_ChannelCreate);
							}
						}else{
							self::$tsAdmin->clientMove($ccl['clid'], $cid);
							self::$tsAdmin->clientPoke($ccl['clid'], self::$l->error_has_a_channel_ChannelCreate);
						}
					}else{
						self::$tsAdmin->clientKick($ccl['clid'], 'channel', self::$l->error_no_group_ChannelCreate);
						self::$tsAdmin->clientPoke($ccl['clid'], self::$l->error_no_group_poke_ChannelCreate);

					}
				}
			}
		}
	}

?>