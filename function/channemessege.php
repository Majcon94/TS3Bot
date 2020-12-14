<?php

	class ChanneMessege extends Command {

		static private $timeUserMsg = [];
		static private $whetherToSend = [];

		public function execute(): void
		{
			foreach($this->config['functions_ChanneMessege']['cid'] as $key => $value) {
				$cid = NULL;
				$channelClientList = self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($key, '-groups'));
				if(!empty($channelClientList)){
					foreach($channelClientList as $ccl){
						if(!isset(self::$timeUserMsg[$key][$ccl['clid']])){
							if(!empty(self::$whetherToSend[$key])){
								if($value['type'] == 1){
									self::$tsAdmin->sendMessage(1, $ccl['clid'], $value['text']);
								}else if ($value['type'] == 2){
									self::$tsAdmin->clientPoke($ccl['clid'], $value['text']);
								}else{
									$this->bot->log(2, 'Podany typ wiadomości jest błędny');
								}
							}
							self::$timeUserMsg[$key][$ccl['clid']] = 1;
						}
						$cid[$ccl['clid']] = 1;
					}
				}
				self::$whetherToSend[$key] = 1;
				if(isset(self::$timeUserMsg[$key])){
					if($cid){
						self::$timeUserMsg[$key] = array_intersect_key(self::$timeUserMsg[$key], $cid);
					}else{
						self::$timeUserMsg[$key] = [];
					}
				}
			}
		}
	}

?>