<?php

	class Functions{

		private static $update_activity_time = NULL;
		private static $registerList = [];

		/**
		 * bot()
		 * 
		 * @param string $invokerid
		 * @param string $wiadomosci
		 * @author	Majcon
		 * @return	void
		 **/
		public function bot($invokerid, $wiadomosci): void
		{

			$params = [ 'text' => $wiadomosci ];
			$params = http_build_query($params);
			try {
				$jdc = json_decode($this->file_get_contents_curl('http://51.254.119.80/api/api2.php?'.$params));
				foreach($jdc->text as $text){
					if(mb_strlen($text, 'utf8') > 1024){
						$odpowiedzword = wordwrap($text, 1024, "[podziel]", true);
						$odp_exp = explode('[podziel]', $odpowiedzword);
						foreach($odp_exp as $odp){
							Bot::$tsAdmin->sendMessage(1, $invokerid, $odp);
						}
					}else{
						Bot::$tsAdmin->sendMessage(1, $invokerid, $text);
					}
					sleep(rand(1,2));
				}
			} catch (PDOException $e) {
				Bot::$tsAdmin->sendMessage(1, $invokerid, "Napisz !help aby uzyskać listę komend:)");
			}
		}

		/**
		 * cenzor()
		 * Funkcja sprawdza czy string zawiera przekleństwo.
		 * @param string $txt
		 * @param int $add
		 * @author	Majcon
		 * @return	bool
		 **/
		public function cenzor($txt, $add): bool
		{
			$cenzor = [ 'bit(h|ch)', '(ch|h)(w|.w)(d|.d)(p|.p)', '(|o)cip', '(|o)(ch|h)uj(|a)', '(|do|na|po|do|prze|przy|roz|u|w|wy|za|z|matkojeb)jeb(|a|c|i|n|y)', '(|do|na|naw|od|pod|po|prze|przy|roz|spie|roz|poroz|s|u|w|za|wy)pierd(a|o)', 'fu(ck|k)', '/[^.]+\.[^.]+$/', "/^(\"|').+?\\1$/", '(|po|s|w|za)(ku|q)rw(i|y)', 'k(у|u)rw', 'k(у|u)tas', '(|po|wy)rucha', 'motherfucker', 'piczk', '(|w)pi(z|z)d' ];
			if($add == 1){
				$cenzor = array_merge($this->config['functions_SprNick']['slowa'], $cenzor);
			}
			foreach($cenzor as $c) {
				if(preg_match('~'.$c.'~s', strtolower($txt))){
					return true;
				}
			}
			return false;
		}

		/**
		 * channelDelete()
		 * Funkcja usuwa kanał.
		 * @author	Majcon
		 * @return	void
		 **/
		public function channelDelete($i=0, $cid): void
		{
			Bot::$db->query("DELETE FROM `channel` WHERE `cid` = {$cid}");
			$data = [ 'channel_name' => $i.'. WOLNY', 'channel_topic' => 'WOLNY', 'channel_description' => '', 'channel_flag_maxfamilyclients_unlimited' => 0, 'channel_flag_maxclients_unlimited' => 0, 'channel_maxclients' => '0', 'channel_maxfamilyclients' => '0', 'channel_password' => '' ];
			Bot::$tsAdmin->channelEdit($cid, $data);
			$channellist = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->channelList('-topic'));
			foreach($channellist as $cl3){
				if($cl3['pid'] == $cid){
					Bot::$tsAdmin->channelDelete($cl3['cid']);
				}
			}
			$channelClientList = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->channelClientList($cid));
			if(!empty($channelClientList)){
				foreach($channelClientList as $ccl){
					Bot::$tsAdmin->clientKick($ccl['clid'], 'channel', Bot::$l->kick_channelDelete);
				}
			}
			$channelgroupclientlist = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->channelGroupClientList($cid));
			if(!empty($channelgroupclientlist)){
				foreach($channelgroupclientlist as $cgcl){
					Bot::$tsAdmin->setClientChannelGroup(8, $cid, $cgcl['cldbid']);
				}
			}
		}

		public function readChatMessage(): void
		{
			$escapedChars = [ "\t", "\v", "\r", "\n", "\f", "\s", "\p", "\/"];
			$unEscapedChars = ['', '', '', '', '', ' ', '|', '/'];
			$executeCommand = Bot::$tsAdmin->executeCommand('servernotifyregister event=textprivate');
			$msgData = explode("\n", $executeCommand['data']);
			foreach($msgData as $param){
				if(!empty($param)){
					if(strpos($param, 'error id=0 msg=ok') === false) {
						$explode = explode(' ', $param);
						unset($explode[0]);
						foreach($explode as $expl){
							$ex = explode('=', $expl);
							$data[$ex[0]] = str_replace($escapedChars, $unEscapedChars, implode("=", array_slice($ex, 1, count($ex) -1)));
						}
						$this->command($data);
					}
				}
			}
		}

		/**
		 * command()
		 * 
		 * @author	Majcon
		 * @return	string
		 **/
		public function command($readChatMessage)
		{
			$invokerid = $readChatMessage['invokerid'];
			$invokeruid = $readChatMessage['invokeruid'];
			$invokername = $readChatMessage['invokername'];
			$targetmode = $readChatMessage['targetmode'];
			$wiadomosci = $readChatMessage['msg'];
			if(!empty($wiadomosci)){
				if(substr($wiadomosci, 0, 1) == '!' || substr($wiadomosci, 0, 1) == '.') {
					$msg = explode(' ', $wiadomosci);
					$command = str_replace([ '.', '!' ], '', strtolower($msg[0]));
					try{
						$query2 = Bot::$db->prepare("SELECT COUNT(id) AS `count`, `staff`, `group`, `cmd` FROM `command` WHERE `cmd` = :command OR `alias` =  :command AND `alias` != '' GROUP BY `id` LIMIT 1");
						$query2->bindValue(':command', $command, PDO::PARAM_STR);
						$query2->execute();
						while($row2 = $query2->fetch()){
							if($row2['count'] == 0 || !file_exists("command/{$row2['cmd']}.php") == true){
								$query3 = Bot::$db->prepare("SELECT COUNT(id) AS `count`, `staff`, `group`, `cmd`, `text` FROM `command_txt` WHERE `cmd` = :command OR `alias` =  :command AND `alias` != '' LIMIT 1");
								$query3->bindValue(':command', $command, PDO::PARAM_STR);
								$query3->execute();
								while($row3 = $query3->fetch()){
									if($row3['count'] == 0){
										Bot::$tsAdmin->sendMessage(1, $invokerid, 'Komenda '.$command.' nie istnieje');
									}else{
										$staff = $row3['staff'];
										$group = explode(',', $row3['group']) ?? [];
										if($this->hasPerm($invokerid, $invokeruid, $staff, $group) == true){
											Bot::$tsAdmin->sendMessage(1, $invokerid, $row3['text']);
										}else{
											Bot::$tsAdmin->sendMessage(1, $invokerid, 'Nie masz dostepu do tej komendy');
										}
									}
								}
							}else{
								$staff = $row2['staff'];
								$group = explode(',', $row2['group']) ?? [];
								$cmd = $row2['cmd'];
								if($this->hasPerm($invokerid, $invokeruid, $staff, $group) == true){
									include("command/{$row2['cmd']}.php");
								}else{
									Bot::$tsAdmin->sendMessage(1, $invokerid, 'Nie masz dostepu do tej komendy');
								}
							}
						}
					} catch (PDOException $e) {
						$this->log(1, $e->getMessage());
					}
				}else{
					$this->bot($invokerid, $wiadomosci);
				}
			}
		}

		/**
		 * file_get_contents_curl()
		 * 
		 * @author	Majcon
		 * @return	string
		 **/
		public function file_get_contents_curl($url): string
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_AUTOREFERER, true);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);       
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}

		public function getDbid($msg): array
		{
			if(is_numeric($msg[1])){
				return $msg;
			}
			if(substr($msg[1],-1) == '='){
				$clientGetDbIdFromUid = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetDbIdFromUid($msg[1]));
				if(!empty($clientGetDbIdFromUid)){
					$msg[1] = $clientGetDbIdFromUid['cldbid'];
					return $msg;
				}
			}
			$implode = implode(' ', $msg);
			if(preg_match_all('/(\"|\')(.*)(\"|\')/m', $implode, $matches, PREG_SET_ORDER, 0)){
				foreach(Bot::getClientList() as $cl){
					if(mb_strtolower($cl['client_nickname'], "UTF-8") == mb_strtolower($matches[0][2], "UTF-8")){
						$implode = str_replace($matches[0][0], $cl['client_database_id'], $implode);
						return explode(' ', $implode);
					}
				}
			}
			foreach(Bot::getClientList() as $cl){
				if(mb_strtolower($cl['client_nickname'], "UTF-8") == mb_strtolower($msg[1], "UTF-8")){
					$msg[1] = $cl['client_database_id'];
					return $msg;
				}
			}
			return [];
		}

		/**
		 * getUrlChannel()
		 * Funkcja tworzy link do kanału.
		 * @author	Majcon
		 * @return	string
		 **/
		public function getUrlChannel($cid, $cn): string
		{
			return '[B][URL=channelID://'.$cid.']'.$cn.'[/URL][/B]';
		}

		/**
		 * getUrlName()
		 * Funkcja tworzy link do użytkownika.
		 * @author	Majcon
		 * @return	string
		 **/
		public function getUrlName($cdid, $cuid, $cnn): string
		{
			return '[B][URL=client://'.$cdid.'/'.$cuid.']'.$cnn.'[/URL][/B]';
		}

		/**
		 * hasPerm()
		 * Funkcja sprawdza uprawnienia.
		 * @param string $invokerid
		 * @param string $invokeruid
		 * @param string $staff
		 * @param array $group
		 * @author	Majcon
		 * @return	void
		 **/
		public function hasPerm($invokerid, $invokeruid, $staff, $group): bool
		{
			$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($invokerid));
			$cisg = explode(',', $clientInfo['client_servergroups']);
			$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `staff` FROM `users` WHERE `cui` = '{$invokeruid}' GROUP BY `id`");
			try {
				while($row = $query->fetch()){
					if($row['count'] == 0){
						$admin_staff = 0;
					}else{
						$admin_staff = $row['staff'];
					}
				}			
			} catch (PDOException $e) {
				$admin_staff = 0;
				$this->log(1, $e->getMessage());
			}
			if($staff <= $admin_staff || $invokeruid == $this->configcmd['admin']['uid'] || !empty(array_intersect($group, $cisg))){
				return true;
			}else{
				return false;
			}
		}

		/**
		 * log()
		 * Funkcja zamisuje logi
		 * @param string $txt
		 * @author	Majcon
		 * @return	void
		 **/
		public function log($error, $txt): void
		{
			if($this->config['functions_log']['on'] == true){
				if($error == 1 && $this->config['functions_log']['power'] > 1){
					$txt = '['.date('H:i:s').'] '.$txt."\n";
					$fp = @fopen('log/'.date('d.m.Y').'_error.log', "a"); 
					flock($fp, 2); 
					fwrite($fp, $txt); 
					flock($fp, 3); 
					fclose($fp);
				}
				if($error == 2 && $this->config['functions_log']['power'] > 0){
					$txt = '['.date('H:i:s').'] '.$txt."\n";
					$fp = @fopen('log/'.date('d.m.Y').'_log.log', "a"); 
					flock($fp, 2); 
					fwrite($fp, $txt); 
					flock($fp, 3); 
					fclose($fp);
				}
			}
		}

		/**
		 * padding_numbers()
		 * @param int $number
		 * @param string $t1
		 * @param string $t2
		 * @param string $t3
		 * @author	Majcon
		 * @return	void
		 **/
		public function padding_numbers($number, $t1, $t2, $t3): string
		{
			$number %= 100;
			if($number == 0 || ($number >=5 && $number <=21)){
				return $t3;
			}
			if($number == 1){
				return $t1;
			}
			if($number > 1 && $number < 5){
				return $t2;
			}
			$number %= 10;
			if($number >1 && $number < 5){
				return $t2;
			}
			return $t3;
		}

		/**
		 * przelicz_czas()
		 * Funkjca przelicza czas.
		 * @param int $time
		 * @author	Majcon
		 * @return	array
		 **/
		public function przelicz_czas($time): array
		{
			$dni_r = $time / 86400;
			$data['d'] = floor($dni_r);
			$rzd = $time - $data['d'] * 86400;
			$godzin_r = $rzd / 3600;
			$data['H'] = floor($godzin_r);
			$rzg = $rzd - $data['H'] * 3600;
			$minut_r = $rzg / 60;
			$data['i'] = floor($minut_r);
			$data['s']  = $rzg - $data['i'] * 60;
			return $data;
		}

		/**
		 * register()
		 * Funkcja rejestruje użytkownika w bazie.
		 * @author	Majcon
		 * @return	void
		 **/
		public function register(): void
		{
			$listOfUser = [];
			foreach(Bot::getClientList() as $cl) {
				if($cl['client_type'] == 0) {
					$listOfUser[] = $cl['clid'];
				}
			}
			$registerClientList = [];
			$new = array_diff($listOfUser, self::$registerList);
			if(!empty($new)){
				foreach($new as $n) {
					if(!in_array($n, $registerClientList)){
						$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($n));
						if($clientInfo){
							try {
								$count = 0;
								$query = Bot::$db->query("SELECT COUNT(id) AS `count` FROM `users` WHERE `cui` = '{$clientInfo['client_unique_identifier']}' GROUP BY `id` LIMIT 1");
								while($row = $query->fetch()){
									$count = $row['count'];
								}
								if(empty($count)){
									$prepare = Bot::$db->prepare("INSERT INTO `users` (`cldbid`, `client_nickname`, `cui`, `last_activity`, `regdate`, `gid`) VALUES (:cldbid, :client_nickname, :cui, :last_activity, :regdate, :gid)");
									$prepare->bindValue(':cldbid', $clientInfo['client_database_id'], PDO::PARAM_INT);
									$prepare->bindValue(':client_nickname', $clientInfo['client_nickname'], PDO::PARAM_STR);
									$prepare->bindValue(':cui', $clientInfo['client_unique_identifier'], PDO::PARAM_STR);
									$prepare->bindValue(':last_activity', time(), PDO::PARAM_INT);
									$prepare->bindValue(':regdate', $clientInfo['client_created'], PDO::PARAM_INT);
									$prepare->bindValue(':gid', $clientInfo['client_servergroups'], PDO::PARAM_STR);
									$prepare->execute();
								}
							} catch (PDOException $e) {
								$this->log(1, $e->getMessage());
							}
						}
						$registerClientList[] = $cl['clid'];
					}
				}
				self::$registerList = $listOfUser;
			}							
		}

		/**
		 * update_activity()
		 * Funkcja aktualizuje aktywność użytkowników.
		 * @author	Majcon
		 * @return	void
		 **/
		public function update_activity(): void
		{
			if(self::$update_activity_time <= time()){
				$update_activity_clientlist = [];
				foreach($this->clientlist as $cl){
					if(!in_array($cl['clid'], $update_activity_clientlist)){
						$clientInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientInfo($cl['clid']));
						if($clientInfo){
							try {
								$count = 0;
								$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `longest_connection` FROM `users` WHERE `cui` = '{$cl['client_unique_identifier']}' GROUP BY `id` LIMIT 1");
								while($row = $query->fetch()){
									$longest_connection = $row['longest_connection'];
									$count = $row['count'];
								}
								if(!empty($count)){
									if($longest_connection < $clientInfo['connection_connected_time']){
										$longest_connection = $clientInfo['connection_connected_time'];
									}
									$prepare = Bot::$db->prepare("UPDATE `users` SET `cldbid` = :cldbid, `connections` = :connections, `longest_connection` = :longest_connection, `time_activity` = time_activity+:time_activity, `last_activity` = :last_activity, `client_nickname` = :client_nickname, `gid` = :gid, `regdate` = :regdate  WHERE `cui` = :cui");
									$prepare->bindValue(':connections', $clientInfo['client_totalconnections'], PDO::PARAM_INT);
									$prepare->bindValue(':longest_connection', $longest_connection, PDO::PARAM_INT);
									if($cl['client_idle_time'] < 300000){
										$prepare->bindValue(':time_activity', 60, PDO::PARAM_INT);
									}else{
										$prepare->bindValue(':time_activity', 0, PDO::PARAM_INT);
									}
									$prepare->bindValue(':last_activity', time(), PDO::PARAM_INT);
									$prepare->bindValue(':client_nickname', $cl['client_nickname'], PDO::PARAM_STR);
									$prepare->bindValue(':gid', $clientInfo['client_servergroups'], PDO::PARAM_STR);
									$prepare->bindValue(':regdate', $clientInfo['client_created'], PDO::PARAM_INT);
									$prepare->bindValue(':cldbid', $cl['client_database_id'], PDO::PARAM_INT);
									$prepare->bindValue(':cui', $cl['client_unique_identifier'], PDO::PARAM_STR);
									$prepare->execute();
								}
								$update_activity_clientlist[] = $cl['clid'];
							} catch (PDOException $e) {
								$this->log(1, $e->getMessage());
							}
						}
					}
				}
				self::$update_activity_time = time()+60;
			}
		}

		/**
		 * sendMessage()
		 * Funkcja wysyła wiadomość prywatną.
		 * @param int $clid
		 * @param string $text
		 * @author	Majcon
		 * @return	string
		 **/
		public function sendMessage(int $clid, string $text): void
		{
			if(strlen($text) > 8190){
				$text = wordwrap($text, 8190, "||", true);
			}
			$explode = explode('||', $text);
			foreach($explode as $exp){
				Bot::$tsAdmin->sendMessage(1, $clid, $exp);
			}		
		}

		/**
		 * wyswietl_czas()
		 * Funkcja wyświetla czas.
		 * @param array $data
		 * @param int $d
		 * @param int $h
		 * @param int $i
		 * @param int $t
		 * @author	Majcon
		 * @return	string
		 **/
		public function wyswietl_czas($data, $d=0, $h=0, $i=0, $s=0, $t=0): string
		{
			$txt_time = null;
			if($d == 1){
				if($data['d'] == 0){
					$txt_time .= '';
				}else{
					Bot::$l->time_d1_wyswietl_czas = $this->padding_numbers($data['d'], Bot::$l->time_d1_wyswietl_czas, Bot::$l->time_d2_wyswietl_czas, Bot::$l->time_d2_wyswietl_czas);
					$txt_time .= $data['d'].' '.Bot::$l->time_d1_wyswietl_czas.' ';
				}
			}else{
				$data['d'] = 0;
			}
			if($h == 1){
				if($data['d'] == 0 && $data['H'] == 0){
					$txt_time .= '';
				}else{
					Bot::$l->time_h1_wyswietl_czas = $this->padding_numbers($data['H'], Bot::$l->time_h1_wyswietl_czas, Bot::$l->time_h2_wyswietl_czas, Bot::$l->time_h3_wyswietl_czas);
					$txt_time .= $data['H'].' '.Bot::$l->time_h1_wyswietl_czas.' ';
				}
			}
			else{
				$data['H'] = 0;
			}
			if($i == 1){
				if($data['d'] == 0 && $data['H'] == 0 && $data['i'] == 0){
					$txt_time .= '';
				}else{
					Bot::$l->time_i1_wyswietl_czas = $this->padding_numbers($data['i'], Bot::$l->time_i1_wyswietl_czas, Bot::$l->time_i2_wyswietl_czas, Bot::$l->time_i3_wyswietl_czas);
					$txt_time .= $data['i'].' '.Bot::$l->time_i1_wyswietl_czas.' ';
				}
			}else{
				$data['i'] = 0;
			}
			if($s == 1){
				if($data['d'] == 0 && $data['s'] == 0 && $data['i'] == 0 && $data['H'] == 0){
					$txt_time .= '';
				}else{
					Bot::$l->time_s1_wyswietl_czas = $this->padding_numbers($data['s'], Bot::$l->time_s1_wyswietl_czas, Bot::$l->time_s2_wyswietl_czas, Bot::$l->time_s3_wyswietl_czas);
					$txt_time .= $data['s'].' '.Bot::$l->time_s1_wyswietl_czas;
				}
			}
			if(empty($txt_time)){
				if($t == 0){
					$txt_time = '0 '.Bot::$l->time_s3_wyswietl_czas;
				}else{
					$txt_time = 'TERAZ';
				}
			}
			return $txt_time;
		}
	}
?>