<?php

	class ChannelNumber extends Command {

		public static $channelNumberTime = 0;

		public function execute(): void
		{
			if(self::$channelNumberTime < time()){
				$i = 0;
				$channellist = self::$tsAdmin->getElement('data', self::$tsAdmin->channelList('-topic'));
				foreach($channellist as $chl){
					if($chl['pid'] == $this->config['functions_ChannelNumber']['pid']){
						$i++;
						preg_match_all('/(\d+)(.*)/is', $chl['channel_name'], $matches);
						if(!empty($matches[1][0])){
							if($matches[1][0] != $i){
								$matches[2][0] = $matches[2][0] ?? NULL;
								if(!empty($matches[2][0]) && $matches[2][0]{0} == trim($this->config['functions_ChannelNumber']['separator'])){
									$matches[2][0] = trim(substr(trim($matches[2][0]), 1));
								}
								self::$tsAdmin->channelEdit($chl['cid'], ['channel_name' => substr($i.$this->config['functions_ChannelNumber']['separator'].$matches[2][0], 0, 40)]);
							}
						}else{
							self::$tsAdmin->channelEdit($chl['cid'], ['channel_name' => substr($i.$this->config['functions_ChannelNumber']['separator'].$chl['channel_name'], 0, 40)]);
						}
					}
				}
				self::$channelNumberTime = time()+10;
			}
		}
	}

?>