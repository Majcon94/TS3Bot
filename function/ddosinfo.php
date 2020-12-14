<?php

	class DdosInfo extends Command {
		
		private static $ddosTime = 0;

		public function execute(): void
		{
			$updatetime = false;
			$serverinfo = $this->bot->getServerInfo();
			$ping = $serverinfo['virtualserver_total_ping'];
			$packet = $serverinfo['virtualserver_total_packetloss_total']*100;
			if($ping > $this->config['functions_DdosInfo']['ping'] || $packet > $this->config['functions_DdosInfo']['packet']){
				foreach($this->bot->getClientList() as $cl) {
					if(array_intersect(explode(',', $cl['client_servergroups']), $this->config['functions_DdosInfo']['gid'])){
						if(self::$ddosTime <= time()){
							self::$tsAdmin->sendMessage(1, $cl['clid'], self::$l->sprintf(self::$l->DdosInfo_mess, $ping, $packet));
							$updatetime = true;
						}
						if($this->config['functions_DdosInfo']['description'] == true){
							self::$tsAdmin->clientEdit($cl['clid'], [ 'client_description' => self::$l->sprintf(self::$l->DdosInfo_desc, $ping, $packet) ]);
						}
					}
				}
				if($updatetime == true){
					self::$ddosTime = time()+300;
				}
			}
		}
	}

?>