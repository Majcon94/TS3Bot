<?php
	if(empty($msg[1])){
		$clientGetDbIdFromUid = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetDbIdFromUid($invokeruid));
		$cldbid = $clientGetDbIdFromUid['cldbid'];
		if(!empty($this->config['functions_TopActivityTime']['cldbid'])){
			$cldbid_config = implode(",", $this->config['functions_TopActivityTime']['cldbid']);
		}
		$ts = 0;
		$query = Bot::$db->query("SELECT `cldbid`, `time_activity`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid_config}) ORDER BY `time_activity` DESC");
		while($row = $query->fetch()){
			if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopActivityTime']['gid'])){
				$ts++;
				if($row['cldbid'] == $cldbid){
					$time_activity = $this->przelicz_czas($row['time_activity'], 1);
					$time_activity = $this->wyswietl_czas($time_activity, 1, 1, 1, 0, 0);
					break;
				}
			}
		}
		if(!empty($this->config['functions_TopConnections']['cldbid'])){
			$cldbid_config = implode(",", $this->config['functions_TopConnections']['cldbid']);
		}
		$cs = 0;
		$query = Bot::$db->query("SELECT `cldbid`, `connections`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid_config}) ORDER BY `connections` DESC");
		while($row = $query->fetch()){
			if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopConnections']['gid'])){
				$cs++;
				if($row['cldbid'] == $cldbid){
					$connections = $row['connections'];
					break;
				}
			}
		}
		if(!empty($this->config['functions_TopLongestConnection']['cldbid'])){
			$cldbid_config = implode(",", $this->config['functions_TopLongestConnection']['cldbid']);
		}
		$ls = 0;
		$query = Bot::$db->query("SELECT `cldbid`, `longest_connection`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid_config}) ORDER BY `longest_connection` DESC");
		while($row = $query->fetch()){
			if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopLongestConnection']['gid'])){
				$ls++;
				if($row['cldbid'] == $cldbid){
					$longest_connection = $this->przelicz_czas($row['longest_connection']/1000);
					$longest_connection = $this->wyswietl_czas($longest_connection, 1, 1, 1, 0, 0);
					break;
				}
			}
		}
		if(!empty($this->config['functions_Lvl']['cldbid'])){
			$cldbid_config = implode(",", $this->config['functions_Lvl']['cldbid']);
		}
		$es = 0;
		$query = Bot::$db->query("SELECT `cldbid`, `exp`, `gid`, `lvl` FROM `users` WHERE `cldbid` NOT IN({$cldbid_config}) ORDER BY `exp` DESC");
		while($row = $query->fetch()){
			if(!array_intersect(explode(',', $row['gid']), $this->config['functions_Lvl']['gid'])){
				$es++;
				if($row['cldbid'] == $cldbid){
					$lvl = $row['lvl'];
					$exp = $row['exp'];
					break;
				}
			}
		}
		$nextLvl = $lvl+1;
		$expnext = $this->config['functions_Lvl']['lvl'][$nextLvl]['exp'];
		$expnow = $this->config['functions_Lvl']['lvl'][$lvl]['exp'];
		$expr = round($exp-$expnow, 2);
		$return = $expnext-$expnow;
		$expProcent = round($expr * 100 / $return);
		$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_info_from_stats, $connections, $cs, $time_activity, $ts, $longest_connection, $ls, $lvl, $expr, $return, $expProcent, $es));
		
	}else{
		$msg = $this->getDbid($msg);
		if(empty($msg)){
			$this->sendMessage($invokerid, 'Nie znaleziono podanego użytkownika');
		}else{
			$cldbid = $msg[1];
			$query = Bot::$db->query("SELECT COUNT(id) AS `count`, `cldbid`, `cui`, `client_nickname` FROM `users` WHERE `cldbid` = {$cldbid} GROUP BY `id`");
			while($row = $query->fetch()){
				$count = $row['count'];
				$nick = $this->getUrlName($row['cldbid'], $row['cui'], $row['client_nickname']);
			}
			if($count != 0){
				if(!empty($this->config['functions_TopActivityTime']['cldbid'])){
					$cldbid_config = implode(",", $this->config['functions_TopActivityTime']['cldbid']);
				}
				$ts = 0;
				$query = Bot::$db->query("SELECT `cldbid`, `time_activity`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid_config}) ORDER BY `time_activity` DESC");
				while($row = $query->fetch()){
					if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopActivityTime']['gid'])){
						$ts++;
						if($row['cldbid'] == $cldbid){
							$time_activity = $this->przelicz_czas($row['time_activity'], 1);
							$time_activity = $this->wyswietl_czas($time_activity, 1, 1, 1, 0, 0);
							break;
						}
					}
				}
				if(!empty($this->config['functions_TopConnections']['cldbid'])){
					$cldbid_config = implode(",", $this->config['functions_TopConnections']['cldbid']);
				}
				$cs = 0;
				$query = Bot::$db->query("SELECT `cldbid`, `connections`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid_config}) ORDER BY `connections` DESC");
				while($row = $query->fetch()){
					if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopConnections']['gid'])){
						$cs++;
						if($row['cldbid'] == $cldbid){
							$connections = $row['connections'];
							break;
						}
					}
				}
				if(!empty($this->config['functions_TopLongestConnection']['cldbid'])){
					$cldbid_config = implode(",", $this->config['functions_TopLongestConnection']['cldbid']);
				}
				$ls = 0;
				$query = Bot::$db->query("SELECT `cldbid`, `longest_connection`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid_config}) ORDER BY `longest_connection` DESC");
				while($row = $query->fetch()){
					if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopLongestConnection']['gid'])){
						$ls++;
						if($row['cldbid'] == $cldbid){
							$longest_connection = $this->przelicz_czas($row['longest_connection']/1000);
							$longest_connection = $this->wyswietl_czas($longest_connection, 1, 1, 1, 0, 0);
							break;
						}
					}
				}
				if(!empty($this->config['functions_Lvl']['cldbid'])){
					$cldbid_config = implode(",", $this->config['functions_Lvl']['cldbid']);
				}
				$es = 0;
				$query = Bot::$db->query("SELECT `cldbid`, `exp`, `gid`, `lvl` FROM `users` WHERE `cldbid` NOT IN({$cldbid_config}) ORDER BY `exp` DESC");
				while($row = $query->fetch()){
					if(!array_intersect(explode(',', $row['gid']), $this->config['functions_Lvl']['gid'])){
						$es++;
						if($row['cldbid'] == $cldbid){
							$lvl = $row['lvl'];
							$exp = $row['exp'];
							break;
						}
					}
				}
				$nextLvl = $lvl+1;
				$expnext = $this->config['functions_Lvl']['lvl'][$nextLvl]['exp'];
				$expnow = $this->config['functions_Lvl']['lvl'][$lvl]['exp'];
				$expr = round($exp-$expnow, 2);
				$return = $expnext-$expnow;
				$expProcent = round($expr * 100 / $return);
				$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_info_user_stats, $nick, $connections, $cs, $time_activity, $ts, $longest_connection, $ls, $lvl, $expr, $return, $expProcent, $es));
			}
		}
	}
?>