<?php

	class DelInfoChannel extends Command {

		public static $delInfoChannel_list = NULL;

		public function execute(): void
		{
			$channellist = self::$tsAdmin->getElement('data', self::$tsAdmin->channelList("-topic"));
			$channel_list = NULL;
			$i = 0;
			$czas_del = time()-$this->config['functions_DelInfoChannel']['time']*86400;
			foreach($channellist as $cl){
				if($cl['pid'] == $this->config['functions_DelInfoChannel']['pid']){
					if($cl['channel_topic'] != 'WOLNY'){
						if(strtotime($cl['channel_topic']) <= $czas_del){
							$i++;
							$channel_list .=  self::$l->sprintf(self::$l->DelInfoChannel_row, $this->bot->getUrlChannel($cl['cid'], $cl['channel_name']));
						}
					}
				}
			}
			if($channel_list != self::$delInfoChannel_list){
				$date['channel_description'] = self::$l->sprintf(self::$l->DelInfoChannel_list, $channel_list);
				if($this->config['functions_DelInfoChannel']['counter'] == 1){
					$date['channel_name'] = self::$l->sprintf(self::$l->DelInfoChannel_name, $i);
				}
				$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_DelInfoChannel']['cid'], $date);
				if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
					$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_DelInfoChannel']['cid'].' nie istnieje Funkcja: DelInfoChannel()');
				}
				self::$delInfoChannel_list = $channel_list;
			}
		}
	}

?>