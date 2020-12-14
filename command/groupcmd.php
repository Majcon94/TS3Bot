<?php
	if(!isset($msg[1])){
		$this->sendMessage($invokerid, Bot::$l->error_give_command_groupcmd);
	}else if(!isset($msg[2])){
		$this->sendMessage($invokerid, Bot::$l->error_give_group_groupcmd);
	}else{
		$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `cmd` FROM `command` WHERE `cmd` = '{$msg[1]}' OR `alias` = '{$msg[1]}'");
		while($row = $query->fetch()){
			if($row['count'] == 0){
				$this->sendMessage($invokerid, Bot::$l->error_lack_of_command_groupcmd);
			}else{
				unset($msg[0], $msg[1]);
				$implode = trim(implode(',', $msg));
				$explode = array_filter(explode(',', str_replace(' ', '', trim($implode))));
				$group = trim(implode(',', $explode));
				Bot::$db->query("UPDATE `command` SET `group` = '{$group}' WHERE `cmd` = '{$row['cmd']}'");
				$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_change_groupcmd, $row['cmd'], $group));
			}
		}
	}
?>