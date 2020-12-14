<?php

	class MoveAfk extends Command {

		private static $user_moveAfk = [];
		public function execute(): void
		{
			foreach($this->bot->getClientList() as $cl){
				if($cl['client_type'] == 0){
					if(($this->config['functions_MoveAfk']['input_muted'] == 1 && $cl['client_input_muted'] == 1) || ($this->config['functions_MoveAfk']['output_muted'] == 1 && $cl['client_output_muted'] == 1) || ($this->config['functions_MoveAfk']['away'] == 1 && $cl['client_away'] == 1) || ($this->config['functions_MoveAfk']['idle'] == 1 && $cl['client_idle_time'] >=  $this->config['functions_MoveAfk']['idle_time']*1000)){
						if($cl['cid'] != $this->config['functions_MoveAfk']['cid'] && !array_intersect(explode(',', $cl['client_servergroups']), $this->config['functions_MoveAfk']['gid']) && !in_array($cl['cid'], $this->config['functions_MoveAfk']['cidaa'])){
							self::$user_moveAfk[$cl['client_database_id']] = $cl['cid'];
							$clientMove = self::$tsAdmin->clientMove($cl['clid'], $this->config['functions_MoveAfk']['cid']);
							if(!empty($clientMove['errors'][0])){
								$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_MoveAfk']['cid'].' nie istnieje Funkcja: moveAfk()');
							}
						}
					}else{
						if($cl['cid'] == $this->config['functions_MoveAfk']['cid'] && !array_intersect(explode(',', $cl['client_servergroups']), $this->config['functions_MoveAfk']['gid'])){
							$clientMove = self::$tsAdmin->clientMove($cl['clid'], self::$user_moveAfk[$cl['client_database_id']] ?? $this->config['functions_MoveAfk']['default_channel']);
							if(!empty($clientMove['errors'][0])){
								$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_MoveAfk']['default_channel'].' nie istnieje Funkcja: moveAfk()');
							}
						}
					}
				}
			}
		}
	}

?>