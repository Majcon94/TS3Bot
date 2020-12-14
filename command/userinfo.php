<?php
	if(empty($msg[1])){
		$this->sendMessage($invokerid, Bot::$l->error_give_clidbid_userinfo);
	}else{
		$msg = $this->getDbid($msg);
		if(empty($msg)){
			$this->sendMessage($invokerid, $l->error_lack_of_cldbid_userinfo);
		}else{
			$cldbid = $msg[1];
			$clientDbInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientDbInfo($cldbid));
			$serverGroupsByClientID = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->serverGroupsByClientID($cldbid));
			foreach($serverGroupsByClientID as $sgbcid){
				$groupui[] = '('.$sgbcid['sgid'].')'.$sgbcid['name'];
			}
			$groupui = trim(implode(', ', $groupui));
			$query = Bot::$db->query("SELECT * FROM `users` WHERE `cldbid` = $cldbid");
			while($row = $query->fetch()){
				$staff = $row['staff'];
				$longest_connection = $this->przelicz_czas($row['longest_connection']/1000);
				$longest_connection = $this->wyswietl_czas($longest_connection, 1, 1, 1, 0, 0);
				$time_activity = $this->przelicz_czas($row['time_activity'], 1);
				$time_activity = $this->wyswietl_czas($time_activity, 1, 1, 1, 0, 0);
			}
			foreach($this->clientlist as $cl){
				if($cldbid == $cl['client_database_id']){
					$onlineui = true;
					$clid = $cl['clid'];
					break;
				}else{
					$onlineui = false;
				}
			}
			if($onlineui == true){
				$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($clid));
				$channelinfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->channelInfo($clientInfo['cid']));
				$channel = $this->getUrlChannel($clientInfo['cid'], $channelinfo['channel_name']);
				$onlineui = Bot::$l->sprintf(Bot::$l->online_users_info_userinfo, $channel, $clientInfo['client_version'], $clientInfo['client_platform'], $clientInfo['client_country'], $clientInfo['client_myteamspeak_id']);
			}else{
				$onlineui = Bot::$l->offline_users_info_userinfo;
			}
			$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `cid` FROM `channel` WHERE `cldbid` = {$cldbid} GROUP BY `id`");
			while($row = $query->fetch()){
				if($row['count'] == 0){
					$channel = 'Brak';
				}else{
					$channelInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->channelInfo($row['cid']));
					$channel = $this->getUrlChannel($row['cid'], $channelInfo['channel_name']);
				}
			}
			$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($invokerid));
			if(array_intersect(explode(',', $clientInfo['client_servergroups']), $this->configcmd['functions_userinfo']['gid'])){
				$lastip = Bot::$l->sprintf(Bot::$l->lastip_users_userinfo, $clientDbInfo['client_lastip']);
			
			}else{
				$lastip = NULL;
			}
			$nick = $this->getUrlName($cldbid, $clientDbInfo['client_unique_identifier'], $clientDbInfo['client_nickname']);
			$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_info_user_userinfo, $nick, $clientDbInfo['client_unique_identifier'], $clientDbInfo['client_database_id'], $groupui, $onlineui, date('d.m.Y H:i:s', $clientDbInfo['client_created']), date('d.m.Y H:i:s', $clientDbInfo['client_lastconnected']), $lastip, $channel, $clientDbInfo['client_totalconnections'], $time_activity, $longest_connection));
		}
	}
?>