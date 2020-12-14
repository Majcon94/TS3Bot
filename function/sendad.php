<?php

	class SendAd extends Command {

		private static $SendAd_time = 0;
		public function execute(): void
		{
			if(self::$SendAd_time <= time()){
				$array_rand = $this->config['functions_SendAd']['txt_group'][array_rand($this->config['functions_SendAd']['txt_group'])];
				foreach($array_rand as $key => $value) {
					$txt = $key;
					$group = $value;
				}
				if($group[0] == -1){
					self::$tsAdmin->sendMessage(3, 1, $txt);
				}else{
					foreach($this->bot->getClientList() as $cl) {
						if(array_intersect(explode(',', $cl['client_servergroups']), $group) || $group[0] == 0){
							self::$tsAdmin->sendMessage(1, $cl['clid'], $txt);
						}
					}
				}
				self::$SendAd_time = time()+$this->config['functions_SendAd']['time']*60;
			}
		}
	}

?>