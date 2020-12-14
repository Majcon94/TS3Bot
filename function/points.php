<?php

	class Points extends Command {

		public static $points_time = 0;
		
		public function execute(): void
		{
			if(self::$points_time <= time()){
				$points_clientlist = [];
				foreach($this->bot->getClientList() as $cl){
					if(!in_array($cl['clid'], $points_clientlist)){
						if($cl['client_type'] == 0) {
							if($cl['client_idle_time'] < 300000){
								$pkt = 10;
							}else{
								$pkt = 1;
							}
							$prepare = Bot::$db->prepare("UPDATE `users` SET `pkt` = pkt+:pkt WHERE `cldbid` = :cldbid");
							$prepare->bindValue(':pkt', $pkt, PDO::PARAM_INT);
							$prepare->bindValue(':cldbid', $cl['client_database_id'], PDO::PARAM_INT);
							$prepare->execute();
						}
						$points_clientlist[] = $cl['clid'];
					}
				}
				if($this->config['functions_Points']['top_list'] == true){
					if(!empty($this->config['functions_Points']['cldbid'])){
						$cldbid = implode(",", $this->config['functions_Points']['cldbid']);
					}
					$top = NULL;
					$s = 0;
					try {
						$query2 = self::$db->query("SELECT `client_nickname`, `cui`, `cldbid`, `lvl`, `pkt`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid}) ORDER BY `pkt` DESC");
						while($row2 = $query2->fetch()){
							if(!array_intersect(explode(',', $row2['gid']), $this->config['functions_Points']['gid'])){
								$s++;
								$nick = $this->bot->getUrlName($row2['cldbid'], $row2['cui'], $row2['client_nickname']);
								$pn = $this->bot->padding_numbers($row2['pkt'], 'punkt', 'punkty', 'punktów');
								$top .= self::$l->sprintf(self::$l->row_Points, $s, $nick, $row2['pkt'], $pn);
							}
							if($s >= $this->config['functions_Points']['limit']){
								break;
							}
						}
						$channelEdit= self::$tsAdmin->channelEdit($this->config['functions_Points']['cid'], ['channel_description' => self::$l->sprintf(self::$l->list_Points, $top)]);
						if(!empty($channelEdit['errors'][0])){
							$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_Points']['cid'].' nie istnieje Funkcja: Points()');
						}
					} catch (PDOException $e) {
						$this->log(1, $e->getMessage());
					}
				}
				self::$points_time = time()+600;
			}
		}
	}

?>