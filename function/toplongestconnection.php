<?php

	class TopLongestConnection extends Command {

		private static $edit_TopLongestConnection = 0;
		private static $description_TopLongestConnection = NULL;

		public function execute(): void
		{
			if(self::$edit_TopLongestConnection <= time()){
				$s = 0;
				$top = NULL;
				if(!empty($this->config['functions_TopLongestConnection']['cldbid'])){
					$cldbid = implode(",", $this->config['functions_TopLongestConnection']['cldbid']);
				}
				try {
					$query = self::$db->query("SELECT `client_nickname`, `cui`, `cldbid`, `longest_connection`, `gid` FROM `users` WHERE `cldbid` NOT IN({$cldbid}) ORDER BY `longest_connection` DESC");
					while($row = $query->fetch()){
						if(!array_intersect(explode(',', $row['gid']), $this->config['functions_TopLongestConnection']['gid'])){
							$s++;
							$data = $this->bot->przelicz_czas($row['longest_connection']/1000);
							$data = $this->bot->wyswietl_czas($data, 1, 1, 1, 0, 0);
							$nick = $this->bot->getUrlName($row['cldbid'], $row['cui'], $row['client_nickname']);
							$top .= self::$l->sprintf(self::$l->row_TopLongestConnection, $s, $nick, $data);
						}
						if($s >= $this->config['functions_TopLongestConnection']['limit']){
							break;
						}
					}
					if($top != self::$description_TopLongestConnection){
						$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_TopLongestConnection']['cid'], [ 'channel_description' => self::$l->sprintf(self::$l->list_TopLongestConnection, $top)]);
						if(!empty($channelEdit['errors'][0])){
							$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_TopLongestConnection']['cid'].' nie istnieje Funkcja: TopLongestConnection()');
						}
						self::$description_TopLongestConnection = $top;
					}
					self::$edit_TopLongestConnection = time()+300;
				} catch (PDOException $e) {
					$this->bot->log(1, $e->getMessage());
				}
			}
		}
	}

?>