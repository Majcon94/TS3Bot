<?php

	class MonitoringPublicChannels extends Command {

		public function execute(): void
		{
			$channellist = self::$tsAdmin->getElement('data', self::$tsAdmin->channelList());
			$i = [];
			foreach($channellist as $chl){
				if(array_key_exists($chl['pid'], $this->config['functions_MonitoringPublicChannels']['config'])){
					if(empty($i[$chl['pid']])){
						$i[$chl['pid']] = 1;
					}else{
						$i[$chl['pid']]++;
					}
					$name = substr(self::$l->sprintf($this->config['functions_MonitoringPublicChannels']['config'][$chl['pid']]['channel_name'], $i[$chl['pid']]), 0, 40);
					if($chl['channel_name'] != $name){
						self::$tsAdmin->channelEdit($chl['cid'], ['channel_name' => $name]);
					}
					if($chl['total_clients'] != 0){
						$busyChannels[$chl['pid']][$chl['cid']] = 1;
					}else{
						$freeChannels[$chl['pid']][$chl['cid']] = 1;
					}
					$allChannels[$chl['pid']][$chl['cid']] = 1;
				}
			}
			foreach($this->config['functions_MonitoringPublicChannels']['config'] as $key => $value){
				if(empty($freeChannels[$key])){
					$data = [
						'cpid'	=> $key,
						'channel_name'	=> substr(self::$l->sprintf($value['channel_name'], $i[$key]+1), 0, 40),
						'channel_description'						=> $value['channel_description'],
						'channel_flag_permanent' 					=> 1,
						'channel_flag_maxfamilyclients_unlimited' 	=> 1,
						'channel_flag_maxclients_unlimited' 		=> 1,
						'channel_maxclients'						=> ($value['channel_maxclients'] == 0) ? '-1' : $value['channel_maxclients'],
						'channel_maxfamilyclients' 					=> '-1',
						'channel_password' 							=> '',
						'channel_codec'								=> 4,
						'channel_codec_quality'						=> 6,
						'channel_flag_semi_permanent'				=> 0,
						'channel_needed_talk_power'					=> 0,
					];
					self::$tsAdmin->channelCreate($data);
				}else if(count($allChannels[$key]) > $value['number_permanent_channels'] && count($freeChannels[$key]) > $value['minimal_number_channels']){
					self::$tsAdmin->channelDelete(array_key_last($freeChannels[$key]));
				}
			}
		}
	}
?>