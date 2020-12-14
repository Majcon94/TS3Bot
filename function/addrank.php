<?php

	class AddRank extends Command {
		
		public function execute(): void
		{
			foreach($this->config['functions_AddRank']['cid_gid'] as $key => $value) {
				$channelClientList = self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($key, '-groups'));
				if(!empty($channelClientList)){
					foreach($channelClientList as $ccl){
						$explode = explode(',', $ccl['client_servergroups']);
						if(!in_array($value, $explode)){
							$serverGroupAddClient = self::$tsAdmin->serverGroupAddClient($value, $ccl['client_database_id']);
							if(!empty($serverGroupAddClient['errors'][0])){
								$this->bot->log(1, 'Grupa o ID:'.$value.' nie istnieje Funkcja: addRank()');
							}
						}
					}
				}
			}
		}
	}

?>