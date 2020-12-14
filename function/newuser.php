<?php

	class NewUser extends Command {

		public static $olde_user_list = NULL;

		public function execute(): void
		{
			$time = time() - $this->config['functions_NewUser']['time'];
			$i = 0;
			$userplus = 0;
			$query = self::$db->query("SELECT `client_nickname`, `cui`, `cldbid` FROM `users` WHERE `regdate` >= {$time} ORDER BY `regdate` DESC");
			while($row = $query->fetch()){
				$i++;
				if($i >= 61){
					$userplus++;
				}else{
					$user_list[] = $this->bot->getUrlName($row['cldbid'], $row['cui'], $row['client_nickname']);
				}
			}
			if($userplus != 0){
				$user_list = implode(', ', $user_list ?? []).', oraz '.$userplus.' innych';
			}else{
				$user_list = implode(', ', $user_list ?? []);
			}
			if($user_list != self::$olde_user_list){
				$date['channel_description'] = self::$l->sprintf(self::$l->NewUser_title, $user_list);
				if($this->config['functions_NewUser']['counter'] == 1){
					$date['channel_name'] = self::$l->sprintf(self::$l->NewUser_name, $i);
				}
				$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_NewUser']['cid'], $date);
				if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
					$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_NewUser']['cid'].' nie istnieje Funkcja: newUser()');
				}
				self::$olde_user_list = $user_list;
			}
		}
	}

?>