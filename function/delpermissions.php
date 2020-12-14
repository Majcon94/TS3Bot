<?php

	class DelPermissions extends Command {

		public function execute(): void
		{
			foreach($this->bot->getClientList() as $cl){
				$permissions_txt = NULL;
				if(!array_intersect(explode(',', $cl['client_servergroups']), $this->config['functions_DelPermissions']['gid']) && !in_array($cl['client_database_id'], $this->config['functions_DelPermissions']['cldbid'])){
					$clientPermList = self::$tsAdmin->getElement('data', self::$tsAdmin->clientPermList($cl['client_database_id'], false));
					if(!empty($clientPermList)){
						foreach($clientPermList as $cpl){
							$permissions[] = $cpl['permid'];
							$permissions_txt .= $cpl['permid'].' ';
						}
						self::$tsAdmin->clientDelPerm($cl['client_database_id'], $permissions);
						$this->bot->log(2, 'Ściągnieto prywatne permisję: '.$cl['client_nickname'].' usunięte permisje: '.$permissions_txt);
					}
				}
				self::$tsAdmin->cleanDebugLog();
			}
		}
	}

?>