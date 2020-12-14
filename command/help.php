<?php
	$text = NULL;
	$query = Bot::$db->query("SELECT `staff`, `group`, `cmd`, `alias`, `description`, `syntax` FROM `command` ORDER BY `staff`, `cmd` ASC");
	while($row = $query->fetch()){
		$staff = $row['staff'];
		$group = explode(',', $row['group']) ?? [];
		if($this->hasPerm($invokerid, $invokeruid, $staff, $group) == true){
			if(!empty($row['alias'])){
				$ali = "{ /{$row['alias']} } ";
			}else{
				$ali = NULL;
			}
			if($row['description']){
				$op = $row['description'];
			}else{
				$op = Bot::$l->error_no_description_help;
			}
			if($row['syntax']){
				$skl = "({$row['syntax']})";
			}else{
				$skl = Bot::$l->error_no_syntax_help;
			}
			$text .= '!'.$row['cmd'].' '.$ali.' '.$skl.' - '.$op.'\n';
		}
	}
	$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->list_of_commands_help, $text));

?>