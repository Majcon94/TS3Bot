<?php
	if(!empty($msg[1])){
		if(is_numeric($msg[1])){
			$cldbid = $msg[1];
		}else{
			$clientGetDbIdFromUid = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetDbIdFromUid($msg[1]));
			if(!empty($clientGetDbIdFromUid)){
				$cldbid = $clientGetDbIdFromUid['cldbid'];
			}
		}
		if(!empty($msg[2])){
			$cid = $msg[2];
			$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `cid` FROM `channel` WHERE `cldbid` = {$cldbid}");
			while($row = $query->fetch()){
				if($row['count'] == 0){
					$query3 = Bot::$db->query("SELECT COUNT(id) AS `count` FROM `channel` WHERE `cid` = {$cid}");
					while($row3 = $query3->fetch()){
						if($row3['count'] != 0){
							$clientDbInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientDbInfo($cldbid));
							$clientGetIds = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetIds($clientDbInfo['client_unique_identifier']));
							$channelinfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->channelInfo($cid));
							if(trim($channelinfo['channel_topic']) == 'WOLNY'){
								$this->sendMessage($invokerid, Bot::$l->error_channel_provided_unoccupied_channelowner);
							}else{
								Bot::$tsAdmin->clientMove($clientGetIds[0]['clid'], $cid);
								Bot::$tsAdmin->setClientChannelGroup($this->config['functions_channelOwner']['gid'], $cid, $cldbid);
								Bot::$db->query("UPDATE `channel` SET `cldbid` = {$cldbid}, `connection_client_ip` = '{$clientDbInfo['client_lastip']}' WHERE `cid` = '{$cid}'");
								$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_owner_changed_channelowner, $cid, $cldbid));
							}
						 }else{
							$this->sendMessage($invokerid, Bot::$l->error_channel_provided_unoccupied_sql_channelowner);
						}
					}
				}else{
					$this->sendMessage($invokerid, Bot::$l->error_is_owner_channelowner);
				}
			}
		}else{
			$this->sendMessage($invokerid, Bot::$l->error_give_channel_id_channelowner);
		}
	}else{
		$this->sendMessage($invokerid, Bot::$l->error_give_client_id_channelowner);						
	}
?>