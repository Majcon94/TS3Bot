<?php

	class CleanChannel extends Command {

		public function execute(): void
		{
			$channellist = self::$tsAdmin->getElement('data', self::$tsAdmin->channelList("-topic -flags -voice -limits -icon"));
			$i = 0;
			foreach($channellist as $cl){
				if($cl['pid'] == $this->config['functions_CleanChannel']['pid']){
					$i++;
					if($cl['channel_topic'] != 'WOLNY' && $cl['channel_topic'] != date('d.m.Y')){
						if(!empty(self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($cl['cid'])))){
							self::$tsAdmin->channelEdit($cl['cid'], [ 'channel_topic' => date('d.m.Y') ]);
						}else{
							foreach($channellist as $cl2){
								if($cl2['pid'] == $cl['cid'] && !empty(self::$tsAdmin->getElement('data', self::$tsAdmin->channelClientList($cl2['cid'])))){
									self::$tsAdmin->channelEdit($cl['cid'], [ 'channel_topic' => date('d.m.Y') ]);
								}
							}
						}
						$czas_del = time()-$this->config['functions_CleanChannel']['time']*86400;
						$czas = strtotime($cl['channel_topic']);
						if($czas <= $czas_del){
							$this->bot->channelDelete($i, $cl['cid']);
							$this->bot->log(2, 'Usunięcie kanału za brak aktywności (channel name: '.$cl['channel_name'].')');
						}
					}
				}
			}
		}
	}

?>