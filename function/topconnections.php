<?php

	class TopConnections extends Command {

		private static $description_TopConnections = NULL;

		public function execute(): void
		{
			$s = 0;
			$top = NULL;
			if(!empty($this->config['functions_TopConnections']['cldbid'])){
				$cldbid = implode(",", $this->config['functions_TopConnections']['cldbid']);
			}
			try {
				$query = self::$db->query("SELECT `client_nickname`, `cui`, `cldbid`, `connections`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid}) ORDER BY `connections` DESC");
				while($row = $query->fetch()){
					if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopConnections']['gid'])){
						$s++;
						$nick = $this->bot->getUrlName($row['cldbid'], $row['cui'], $row['client_nickname']);
						$top .= self::$l->sprintf(self::$l->row_TopConnections, $s, $nick, $row['connections']);
					}
					if($s >= $this->config['functions_TopConnections']['limit']){
						break;
					}
				}
				if($top != self::$description_TopConnections){
					$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_TopConnections']['cid'], array('channel_description' => self::$l->sprintf(self::$l->list_TopConnections, $top)));
					if(!empty($channelEdit['errors'][0])){
						$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_TopConnections']['cid'].' nie istnieje Funkcja: TopConnections()'.$channelEdit['errors'][0]);
					}
					self::$description_TopConnections = $top;
				}
			} catch (PDOException $e) {
				$this->bot->log(1, $e->getMessage());
			}
		}
	}

?>