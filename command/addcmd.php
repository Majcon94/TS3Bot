<?php
	if(!empty($msg[1])){
		if(!empty($msg[2])){
			$cmd = $msg[1];
			$query = Bot::$db->prepare("SELECT COUNT(id) AS `count` FROM `command_txt` WHERE `cmd` = :command OR `alias` =  :command AND `alias` != '' LIMIT 1");
			$query->bindValue(':command', $cmd, PDO::PARAM_STR);
			$query->execute();
			while($row = $query->fetch()){
				if($row['count'] == 0){
					unset($msg[0], $msg[1]);
					$text = trim(implode(' ', $msg));
					Bot::$db->query("INSERT INTO `command_txt` (`id`, `cmd`, `alias`, `text`, `staff`, `group`, `description`, `syntax`) VALUES (NULL, ':cmd', '', ':text', 0, '', '', ':syntax')");
					$prepare->bindValue(':cmd', $cmd, PDO::PARAM_STR);
					$prepare->bindValue(':text', $text, PDO::PARAM_STR);
					$prepare->bindValue(':syntax', '!'.$cmd, PDO::PARAM_STR);
					$prepare->execute();
					$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_added_cmd_addcmd, $cmd));	
				}
			}
		}else{
			$this->sendMessage($invokerid, Bot::$l->error_give_contents_cmd_addcmd);						
		}
	}else{
		$this->sendMessage($invokerid, Bot::$l->error_give_name_cmd_addcmd);						
	}
?>