<?php
	if(empty($msg[1]) || empty($msg[2])){
		$this->sendMessage($invokerid, Bot::$l->error_give_dbid_staff);
	}else if(!is_numeric($msg[2]) || $msg[2] < 0 || $msg[2] > 10){
		$this->sendMessage($invokerid, Bot::$l->error_not_the_number_staff);
	}else{
		if(is_numeric($msg[1])){
			$cldbid = $msg[1];
		}else{
			$clientGetDbIdFromUid = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetDbIdFromUid($msg[1]));
			if(!empty($clientGetDbIdFromUid)){
				$cldbid = $clientGetDbIdFromUid['cldbid'];
			}
		}
		$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `cldbid`, `cui`, `client_nickname` FROM `users` WHERE `cldbid` = {$cldbid}");
		while($row = $query->fetch()){
			if($row['count'] != 0){
				Bot::$db->query("UPDATE `users` SET `staff` = {$msg[2]} WHERE `cldbid` = {$cldbid}");
				$nick = $this->getUrlName($row['cldbid'], $row['cui'], $row['client_nickname']);
				$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_change_staff, $nick, $msg[2]));
			}else{
				$this->sendMessage($invokerid, Bot::$l->error_lack_of_user_staff);
			}
		}
	}
?>