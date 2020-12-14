<?php

	class GroupOnline extends Command {

		public static $older_GroupOnline = [];
		public static $older_GroupOnline_name = [];
		public static $groupOnline_time_edition = [];

		public function execute(): void
		{
			foreach($this->config['functions_GroupOnline']['cid'] as $cid => $value){
				$i_online = 0;
				$i_all = 0;
				$groupOnline = NULL;
				self::$older_GroupOnline[$cid] = self::$older_GroupOnline[$cid] ?? NULL;
				self::$older_GroupOnline_name[$cid] = self::$older_GroupOnline_name[$cid] ?? NULL;
				self::$groupOnline_time_edition[$cid] = self::$groupOnline_time_edition[$cid] ?? 0;
				$channel_description = $value['title'];
				foreach($value['gid'] as $gid => $name){
					$serverGroupClientList = self::$tsAdmin->serverGroupClientList($gid, '-names');
					$serverGroupClientListarray_filter = array_filter($serverGroupClientList['data'][0] ?? []);
					if(!empty($serverGroupClientListarray_filter)){
						$channel_description .= $name;
						foreach($serverGroupClientList['data'] as $sgcl){
							if(!empty($sgcl['cldbid'])){
								$i_all++;
								foreach($this->bot->getClientList() as $cl){
									if($sgcl['cldbid'] == $cl['client_database_id']){
										$online = true;
										$i_online++;
										$channelinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->channelInfo($cl['cid']));
										if($value['channel_info'] == true){
											$channel = self::$l->sprintf(self::$l->GroupOnline_channel, $this->bot->getUrlChannel($cl['cid'], $channelinfo['channel_name']));
										}else{
											$channel = NULL;
										}
										$nick = $this->bot->getUrlName($cl['client_database_id'], $cl['client_unique_identifier'] ?? '', $cl['client_nickname']);
										$channel_description .= self::$l->sprintf(self::$l->GroupOnline_online, $nick, $channel);
										$groupOnline .= $nick.$channel;
										break;
									}else{
										$online = false;
									}
								}
								if($online == false){
									if($value['time_info'] == true){
										$last_activity = 0;
										$query = self::$db->query("SELECT COUNT(id) AS `count`, `last_activity` FROM `users` WHERE `cldbid` = {$sgcl['cldbid']} GROUP BY `last_activity` LIMIT 1");
										while($row = $query->fetch()){
											if(!empty($row['count'])){
												$last_activity = $row['last_activity'];
											}
										}
										$data = $this->bot->przelicz_czas(time()-$last_activity);
										$txt_time = $this->bot->wyswietl_czas($data, 1, 1, 1, 0, 0);
										$txt_time = self::$l->sprintf(self::$l->GroupOnline_time, $txt_time);
									}else{
										$txt_time = NULL;
									}
									$clientdbinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($sgcl['cldbid']));
									$nick = $this->bot->getUrlName($clientdbinfo['client_database_id'], $clientdbinfo['client_unique_identifier'], $clientdbinfo['client_nickname']);
									$channel_description .= self::$l->sprintf(self::$l->GroupOnline_offline, $nick, $txt_time);
									$groupOnline .= $nick;
								}
							}
						}
					}
				}
				$edit = 0;
				if($value['time_info'] != true){
					$edit = 0;
				}else{
					if(self::$groupOnline_time_edition[$cid] < time()){
						$edit = 1;
					}
				}
				if(self::$older_GroupOnline[$cid] != $groupOnline || $edit == 1){
					$data['channel_description'] = $channel_description;
					$groupOnline_name = self::$l->sprintf($value['channel_name'], $i_online, $i_all);
					if($value['name_online'] == true && self::$older_GroupOnline_name[$cid] != $groupOnline_name){
						if(empty(self::$older_GroupOnline_name[$cid])){
							self::$older_GroupOnline_name[$cid] = $groupOnline_name;
						}else{
							self::$older_GroupOnline_name[$cid] = $groupOnline_name;
							$data['channel_name'] = $groupOnline_name;
						}
					}
					$channelEdit = self::$tsAdmin->channelEdit($cid, $data);
					if(!empty($channelEdit['errors'][0])){
						$this->bot->log(1, 'Kanał o ID:'.$cid.' nie istnieje Funkcja: groupOnline()');
					}
					self::$older_GroupOnline[$cid] = $groupOnline;
					self::$groupOnline_time_edition[$cid] = time()+60;
				}
			}
		}
	}

?>