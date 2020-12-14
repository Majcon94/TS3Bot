<?php

	class DelRank extends Command {

		public function execute(): void
		{
			foreach($this->config['functions_DelRank']['cid_gid'] as $klucz => $value) {
				$channelClientList = self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($klucz, '-groups'));
				if(!empty($channelClientList)){
					foreach($channelClientList as $ccl){
						$explode = explode(',', $ccl['client_servergroups']);
						if(in_array($value, $explode)){
							$serverGroupDeleteClient = self::$tsAdmin->serverGroupDeleteClient($value, $ccl['client_database_id']);
							if(!empty($serverGroupDeleteClient['errors'][0])){
								$this->bot->log(1, 'Grupa o ID:'.$value.' nie istnieje Funkcja: DelRank()');
							}
						}
					}
				}
			}
		}
	}

?>