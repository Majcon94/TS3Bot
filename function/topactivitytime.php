<?php

	class TopActivityTime extends Command {

		public static $top_activity_time = 0;

		public function execute(): void
		{
			if(self::$top_activity_time <= time()){
				$s = 0;
				$top = NULL;
				if(!empty($this->config['functions_TopActivityTime']['cldbid'])){
					$cldbid = implode(",", $this->config['functions_TopActivityTime']['cldbid']);
				}
				try {
					$query = self::$db->query("SELECT `client_nickname`, `cui`, `cldbid`, `time_activity`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid}) ORDER BY `time_activity` DESC");
					while($row = $query->fetch()){
						if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopActivityTime']['gid'])){
							$s++;
							$data = $this->bot->przelicz_czas($row['time_activity'], 1);
							$data = $this->bot->wyswietl_czas($data, 1, 1, 1, 0, 0);
							$nick = $this->bot->getUrlName($row['cldbid'], $row['cui'], $row['client_nickname']);
							$top .= self::$l->sprintf(self::$l->row_TopActivityTime, $s, $nick, $data);
						}
						if($s >= $this->config['functions_TopActivityTime']['limit']){
							break;
						}
					}
					$channelEdit= self::$tsAdmin->channelEdit($this->config['functions_TopActivityTime']['cid'], ['channel_description' => self::$l->sprintf(self::$l->list_TopActivityTime, $top)]);
					if(!empty($channelEdit['errors'][0])){
						$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_TopActivityTime']['cid'].' nie istnieje Funkcja: TopActivityTime()');
					}
					self::$top_activity_time = time()+60;
				} catch (PDOException $e) {
					$this->bot->log(1, $e->getMessage());
				}
			}
		}
	}

?>