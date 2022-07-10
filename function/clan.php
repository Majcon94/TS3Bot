<?php

	class Clan extends Command {

		private static $clanOlder = [];
		private static $clanOlderName = [];
		private static $clanTimeEdition = [];

		public function execute(): void
		{
			$channelClientList = self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($this->config['functions_Clan']['cid'], "-ip -uid -groups"));
			if(!empty($channelClientList)){
				foreach($channelClientList as $ccl){
					$tag = $ccl['client_nickname'];
					try{
						$query = self::$db->prepare("SELECT COUNT(id) AS `count` FROM `clan` WHERE `cuid` = :cuid GROUP BY `id`");
						$query->bindValue(':cuid', $ccl['client_unique_identifier'], PDO::PARAM_STR);
						$query->execute();
						while($row = $query->fetch()){
							if($row['count']){
								$has = true;
							}
						}
					} catch (PDOException $e) {
						echo "<pre>";
						print_r($e);
					}
					if(!empty($has)){
						self::$tsAdmin->clientKick($ccl['clid'], 'channel');
						break;
					}
					try{
						$query = self::$db->query("SELECT `lcid` FROM `clan` ORDER BY `id` DESC LIMIT 1");
						while($row = $query->fetch()){
							if(!empty($row['lcid'])){
								$lcid = $row['lcid'];
							}
						}
					} catch (PDOException $e) {
						echo "<pre>";
						print_r($e);
					}
					if(empty($lcid)){
						$lcid = $this->config['functions_Clan']['co'];

					}
					$cgidl =self::$tsAdmin->channelGroupCopy($this->config['functions_Clan']['cgidl'], 0, self::$l->sprintf($this->config['functions_Clan']['cgnl'], $tag));
					$cgidd =self::$tsAdmin->channelGroupCopy($this->config['functions_Clan']['cgidd'], 0, self::$l->sprintf($this->config['functions_Clan']['cgnd'], $tag));

					$i = 1;
					foreach($this->config['functions_Clan']['channel'] as $channel){
						$data = [
							'channel_name'	=>	self::$l->sprintf($channel['name'], $tag, $i, 1, 1),
							'channel_order'	=>	$lcid,
							'channel_maxclients'	=>	0,
							'channel_flag_permanent'	=> 1,
							'channel_flag_maxfamilyclients_unlimited'	=> 0,
							'channel_flag_maxclients_unlimited'	=> 0,
							'channel_maxfamilyclients'	=> 0,
						];
						$channelCreate = self::$tsAdmin->channelCreate($data);
						$lcid = $channelCreate['data']['cid'];
						$allcid[] = $lcid;
						self::$tsAdmin->channelAddPerm($lcid, ['i_channel_needed_join_power' => $channel['join_power']]);
						if($channel['type'] == 'grouponline'){
							$grouponline = $channelCreate['data']['cid'];
							$dcn = self::$l->sprintf($channel['name'], $tag, $i);
						}
						if(!empty($channel['sub'])){
							$cid = $lcid;
							self::$tsAdmin->setClientChannelGroup($cgidl['data']['cgid'], $cid, $ccl['client_database_id']);
							foreach($channel['sub'] as $sub){
								$data = [
									'channel_name'	=>	self::$l->sprintf($sub['name'], $tag),
									'cpid'	=>	$lcid,
									'channel_maxclients'	=>	0,
									'channel_flag_permanent'	=> 1,
									'channel_flag_maxfamilyclients_unlimited'	=> 1,
									'channel_flag_maxclients_unlimited'	=> 1,
									'channel_maxclients'	=> '-1',
									'channel_maxfamilyclients'	=> '-1',
								];
								
								$channelCreate = self::$tsAdmin->channelCreate($data);
								$allcid[] = $channelCreate['data']['cid'];
								self::$tsAdmin->channelAddPerm($channelCreate['data']['cid'], ['i_channel_needed_join_power' => $sub['join_power']]);

								if($sub['type'] == 'lider'){
									$lider = $channelCreate['data']['cid'];
									self::$tsAdmin->clientMove($ccl['clid'], $lider);
								}
								if($sub['type'] == 'ranga'){
									$ranga = $channelCreate['data']['cid'];
								}
								if($sub['type'] == 'grouponline'){
									$grouponline = $channelCreate['data']['cid'];
									$dcn =self::$l->sprintf($sub['name'], $tag, $i);
								}
							}
						}
						$i++;
					}
					try{
						$prepare = self::$db->prepare("INSERT INTO `clan` (`tag`, `cuid`, `cid`, `cgid`, `lcgid`, `lcid`, `rcid`, `gcid`, `dcn`, `acid`) VALUES (:tag, :cuid, :cid, :cgid, :lcgid, :lcid, :rcid, :gcid, :dcn, :acid)");
						$prepare->bindValue(':tag', $tag, PDO::PARAM_STR);
						$prepare->bindValue(':cuid', $ccl['client_unique_identifier'], PDO::PARAM_STR);
						$prepare->bindValue(':cid', $cid, PDO::PARAM_INT);
						$prepare->bindValue(':cgid', $cgidd['data']['cgid'], PDO::PARAM_INT);
						$prepare->bindValue(':lcgid', $cgidl['data']['cgid'], PDO::PARAM_INT);
						$prepare->bindValue(':lcid', $lcid, PDO::PARAM_INT);
						$prepare->bindValue(':rcid', $ranga ?? 0, PDO::PARAM_INT);
						$prepare->bindValue(':gcid', $grouponline ?? 0, PDO::PARAM_INT);
						$prepare->bindValue(':dcn', $dcn ?? 0, PDO::PARAM_STR);
						$prepare->bindValue(':acid', json_encode($allcid) ?? 0, PDO::PARAM_STR);
						$prepare->execute();
					} catch (PDOException $e) {
						echo "<pre>";
						print_r($e->getMessage());
					}
				}
			}
			$this->addGroup();
			$this->groupOnline();
		}

		private function addGroup(): void
		{
			try{
				$query = self::$db->query("SELECT `cgid`, `rcid`, `cid`, `gcid` FROM `clan`");
				while($row = $query->fetch()){
					if(!empty($row['rcid'])){
						$channelClientList =   self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($row['rcid'], '-groups'));
						if(!empty($channelClientList)){
							foreach($channelClientList as $ccl){	
								$channelGroupClientList = self::$tsAdmin->getElement('data', self::$tsAdmin->channelGroupClientList($row['cid'], $ccl['client_database_id']));
								if($channelGroupClientList[0]['cgid'] == $row['cgid']){
									self::$tsAdmin->setClientChannelGroup($this->config['functions_Clan']['cgid'], $row['cid'], $ccl['client_database_id']);
									self::$tsAdmin->clientKick($ccl['clid'], 'channel');
								}else{
									self::$tsAdmin->setClientChannelGroup($row['cgid'], $row['cid'], $ccl['client_database_id']);
									self::$tsAdmin->clientKick($ccl['clid'], 'channel');
								}
							}
						}
					}
				}
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		private function groupOnline(): void
		{
			$query = self::$db->query("SELECT `cgid`, `lcgid`, `gcid`, `cid`, `dcn` FROM `clan`");
			while($row = $query->fetch()){
				if($row['gcid']){
					$i_online = 0;
					$i_all = 0;
					$groupOnline = NULL;
					self::$clanOlder[$row['gcid']] = self::$clanOlder[$row['gcid']] ?? NULL;
					self::$clanOlderName[$row['gcid']] = self::$clanOlderName[$row['gcid']] ?? NULL;
					self::$clanTimeEdition[$row['gcid']] = self::$clanTimeEdition[$row['gcid']] ?? 0;
					$channel_description = NULL;
					$gidall = [ $row['lcgid'] => $this->config['functions_Clan']['title_lider'], $row['cgid'] => $this->config['functions_Clan']['title_dostepny'] ];
					foreach($gidall as $gid => $title){
						$channelGroupClientList = self::$tsAdmin->channelGroupClientList($row['cid'], NULL, $gid);
						$serverGroupClientListarray_filter = array_filter($channelGroupClientList['data'][0] ?? []);
						if(!empty($serverGroupClientListarray_filter)){
							$channel_description .= $title;
							foreach($channelGroupClientList['data'] as $cgcl){
								if(!empty($cgcl['cldbid'])){
									$i_all++;
									foreach($this->bot->getClientList() as $cl){
										if($cgcl['cldbid'] == $cl['client_database_id']){
											$online = true;
											$i_online++;
											$channelinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->channelInfo($cl['cid']));
											if($this->config['functions_Clan']['channel_info'] == true){
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
										if($this->config['functions_Clan']['time_info'] == true){
											$last_activity = 0;
											$query2 = self::$db->query("SELECT COUNT(id) AS `count`, `last_activity` FROM `users` WHERE `cldbid` = {$cgcl['cldbid']} GROUP BY `last_activity` LIMIT 1");
											while($row2 = $query2->fetch()){
												if(!empty($row2['count'])){
													$last_activity = $row2['last_activity'];
												}
											}
											$data2 = $this->bot->przelicz_czas(time()-$last_activity);
											$txt_time = $this->bot->wyswietl_czas($data2, 1, 1, 1, 0, 0);
											$txt_time = self::$l->sprintf(self::$l->GroupOnline_time, $txt_time);
										}else{
											$txt_time = NULL;
										}
										$clientdbinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($cgcl['cldbid']));
										$nick = $this->bot->getUrlName($clientdbinfo['client_database_id'], $clientdbinfo['client_unique_identifier'], $clientdbinfo['client_nickname']);
										$channel_description .= self::$l->sprintf(self::$l->GroupOnline_offline, $nick, $txt_time);
										$groupOnline .= $nick;
									}
								}
							}
						}
					}
					$edit = 0;
					if($this->config['functions_Clan']['time_info'] != true){
						$edit = 0;
					}else{
						if(self::$clanTimeEdition[$row['gcid']] < time()){
							$edit = 1;
						}
					}
					if(self::$clanOlder[$row['gcid']] != $groupOnline || $edit == 1){
						$data['channel_description'] = $channel_description;
						$groupOnline_name = self::$l->sprintf($row['dcn'], NULL, NULL, $i_online, $i_all);
						if($this->config['functions_Clan']['name_online'] == true && self::$clanOlderName[$row['gcid']] != $groupOnline_name){
							if(empty(self::$clanOlderName[$row['gcid']])){
								self::$clanOlderName[$row['gcid']] = $groupOnline_name;
							}else{
								self::$clanOlderName[$row['gcid']] = $groupOnline_name;
								$data['channel_name'] = $groupOnline_name;
							}
						}
						$channelEdit = self::$tsAdmin->channelEdit($row['gcid'], $data);
						if(!empty($channelEdit['errors'][0])){
							$this->bot->log(1, 'Kanał o ID:'.$row['gcid'].' nie istnieje Funkcja: clan()');
						}
						self::$clanOlder[$row['gcid']] = $groupOnline;
						self::$clanTimeEdition[$row['gcid']] = time()+60;
					}
				}
			}
		}
	}

?>