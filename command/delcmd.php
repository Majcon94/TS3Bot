<?php
	if(!empty($msg[1])){
		$cmd = $msg[1];
		$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `cmd` FROM `command_txt` WHERE `cmd` = '{$cmd}' OR `alias` = '{$cmd}' AND `alias` != '' LIMIT 1");
		while($row = $query->fetch()){
			if($row['count'] != 0){
				Bot::$db->query("DELETE FROM `command_txt` WHERE `cmd` = '{$row['cmd']}'");
				$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_deleted_cmd_delcmd, $cmd));	
			}
		}
	}else{
		$this->sendMessage($invokerid, Bot::$l->error_give_name_cmd_delcmd);						
	}
?>