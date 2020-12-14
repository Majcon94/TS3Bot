<?php

	class SprNick extends Command {

		public function execute(): void
		{
			foreach($this->bot->getClientList() as $cl) {
				if(!array_intersect(explode(',', $cl['client_servergroups']), $this->config['functions_SprNick']['gid'])){
					if($this->bot->cenzor($cl['client_nickname'], 1) == true){
						self::$tsAdmin->clientPoke($cl['clid'], self::$l->poke_SprNick);
						self::$tsAdmin->clientKick($cl['clid'], "server", self::$l->kick_SprNick);
						$this->bot->log(2, 'Wyrzucono użytkownika ('.$cl['client_nickname'].') za wulgarny nick (client unique identifier: '.$cl['client_unique_identifier'].')');
					}
				}
			}
		}
	}

?>