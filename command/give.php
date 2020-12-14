<?php
	if(empty($msg[1])){
		$this->sendMessage($invokerid, Bot::$l->error_give_clidbid_give);
	}else{
		if(empty($msg[2])){
			$this->sendMessage($invokerid, Bot::$l->error_give_points_give);
		}else{
			$msg = $this->getDbid($msg);
			if(empty($msg)){
				$this->sendMessage($invokerid, Bot::$l->error_lack_of_cldbid_give);
			}else{
				$cldbid_person = $msg[1];
				if(!preg_match('#^[0-9]+$#', $msg[2])){
					$this->sendMessage($invokerid, Bot::$l->error_give_points_give);
				}else{
					$prepare = Bot::$db->prepare("SELECT COUNT(`id`) AS `count`, `pkt` FROM `users` WHERE `cldbid` = :cldbid");
					$prepare->bindValue(':cldbid', $cldbid_person, PDO::PARAM_INT);
					$prepare->execute();
					while($row = $prepare->fetch()){
						if($row['count'] == 0){
							$this->sendMessage($invokerid, Bot::$l->error_lack_of_cldbid_give);
						}else{
							$clientGetDbIdFromUid = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetDbIdFromUid($invokeruid));
							$cldbid = $clientGetDbIdFromUid['cldbid'];
							$prepare = Bot::$db->prepare("SELECT `pkt` FROM `users` WHERE `cldbid` = :cldbid");
							$prepare->bindValue(':cldbid', $cldbid, PDO::PARAM_INT);
							$prepare->execute();
							while($row = $prepare->fetch()){
								if($row['pkt'] < $msg[2]){
									$this->sendMessage($invokerid, Bot::$l->error_no_points_give);
								}else{
									$prepare = Bot::$db->prepare("UPDATE `users` SET `pkt` = pkt+:pkt WHERE `cldbid` = :cldbid");
									$prepare->bindValue(':pkt', $msg[2], PDO::PARAM_INT);
									$prepare->bindValue(':cldbid', $cldbid_person, PDO::PARAM_INT);
									$prepare->execute();
									$prepare = Bot::$db->prepare("UPDATE `users` SET `pkt` = pkt-:pkt WHERE `cldbid` = :cldbid");
									$prepare->bindValue(':pkt', $msg[2], PDO::PARAM_INT);
									$prepare->bindValue(':cldbid', $cldbid, PDO::PARAM_INT);
									$prepare->execute();
									$clientDbInfo_person = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientDbInfo($cldbid_person));
									$nick = $this->getUrlName($cldbid_person, $clientDbInfo_person['client_unique_identifier'], $clientDbInfo_person['client_nickname']);
									$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_you_gave_points_give, $msg[2], $nick));
									$clientGetIds = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetIds($clientDbInfo_person['client_unique_identifier']));
									$clientDbInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientDbInfo($cldbid));
									$nick = $this->getUrlName($cldbid, $clientDbInfo['client_unique_identifier'], $clientDbInfo['client_nickname']);
									$this->sendMessage($clientGetIds[0]['clid'], Bot::$l->sprintf(Bot::$l->success_gave_points_give, $nick, $msg[2]));

								}
							}
						}
					}
				}
			}
		}			
	}
?>