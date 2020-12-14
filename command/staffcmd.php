<?php
	if(!isset($msg[1])){
		$this->sendMessage($invokerid, Bot::$l->error_give_command_staffcmd);
	}else if(!isset($msg[2])){
		$this->sendMessage($invokerid, Bot::$l->error_give_staff_staffcmd);
	}else{
		$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `cmd` FROM `command` WHERE `cmd` = '{$msg[1]}' OR `alias` = '{$msg[1]}'");
		while($row = $query->fetch()){
			if($row['count'] == 0){
				$this->sendMessage($invokerid, Bot::$l->error_lack_of_command_staffcmd);
			}else{
				Bot::$db->query("UPDATE `command` SET `staff` = {$msg[2]} WHERE `cmd` = '{$row['cmd']}'");
				$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_change_staffcmd, $row['cmd'], $msg[2]));
			}
		}
	}
?>