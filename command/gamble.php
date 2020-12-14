<?php
	if(!empty($msg[1])){
		$clientGetDbIdFromUid = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetDbIdFromUid($invokeruid));
		$cldbid = $clientGetDbIdFromUid['cldbid'];
		$query = Bot::$db->query("SELECT `pkt` FROM `users` WHERE `cldbid` = {$cldbid}");
		while($row = $query->fetch()){
			$rand = mt_rand(1,100);
			if(strtoupper($msg[1]) == 'all'){
				if($row['pkt'] != 0){
					if($rand < 56){
						$pkt = $row['pkt'];
						$this->sendMessage($invokerid, Bot::$l->success_defeat_gamble);
						$prepare = Bot::$db->prepare("UPDATE `users` SET `pkt` = 0 WHERE `cldbid` = :cldbid");
						$prepare->bindValue(':cldbid', $cldbid, PDO::PARAM_INT);
						$prepare->execute();
					}else{
						$pkt = $row['pkt']*2-$row['pkt'];
						$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_win_gamble, $pkt));
						$prepare = Bot::$db->prepare("UPDATE `users` SET `pkt` = pkt+:pkt WHERE `cldbid` = :cldbid");
						$prepare->bindValue(':pkt', $pkt, PDO::PARAM_INT);
						$prepare->bindValue(':cldbid', $cldbid, PDO::PARAM_INT);
						$prepare->execute();
					}
				}else{
					$this->sendMessage($invokerid, Bot::$l->error_no_points_gamble);
				}
			}else{
				if(!preg_match('#^[0-9]+$#', $msg[1])){
					$this->sendMessage($invokerid, Bot::$l->error_give_points_gamble);
				}else{
					if($row['pkt'] < $msg[1]){
						$this->sendMessage($invokerid, Bot::$l->error_no_points_gamble);
					}else{
						if($rand < 56){
							$pkt = $msg[1]*2-$msg[1];
							$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_win_gamble, $pkt));
							$prepare = Bot::$db->prepare("UPDATE `users` SET `pkt` = pkt+:pkt WHERE `cldbid` = :cldbid");
							$prepare->bindValue(':pkt', $pkt, PDO::PARAM_INT);
							$prepare->bindValue(':cldbid', $cldbid, PDO::PARAM_INT);
							$prepare->execute();
						}else{
							$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_defea_gamble, $msg[1]));
							$prepare = Bot::$db->prepare("UPDATE `users` SET `pkt` = pkt-:pkt WHERE `cldbid` = :cldbid");
							$prepare->bindValue(':pkt', $msg[1], PDO::PARAM_INT);
							$prepare->bindValue(':cldbid', $cldbid, PDO::PARAM_INT);
							$prepare->execute();
						}
					}
				}
			}
			
		}
	}else{
		$this->sendMessage($invokerid, Bot::$l->error_give_points_gamble);
	}
?>