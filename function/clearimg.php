<?php

	class ClearImg extends Command {

		public static $clearImgTime = 0;

		public function execute(): void
		{
			if(self::$clearImgTime < time()){
				$channellist = self::$tsAdmin->getElement('data', self::$tsAdmin->channelList("-flags"));
				foreach($channellist as $chl){
					$edit = 0;
					if(!empty(in_array($chl['pid'], $this->config['functions_ClearImg']['pid'])) || ($this->config['functions_ClearImg']['cp'] == true && $chl['channel_flag_permanent'] == 0)){
						$channelinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->channelInfo($chl['cid']));
						$channeldesc = $channelinfo['channel_description'];
						$re = '/\[img\](.*?)\[\/img\]/im';
						preg_match_all($re, $channeldesc, $matches, PREG_SET_ORDER, 0);
						foreach($matches as $mat){
							$parse = parse_url(str_ireplace('www.', '', $mat[1]));
							if(empty($parse['host']) || !in_array($parse['host'], $this->config['functions_ClearImg']['url'])){
								$edit = 1;
								$channeldesc = str_ireplace($mat[0], self::$l->success_edit_description_ClearImg, $channeldesc);
							}
						}
						if($edit == 1){
							self::$tsAdmin->channelEdit($chl['cid'], [ 'channel_description' => $channeldesc ]);
						}
						foreach($channellist as $chl2){
							if($chl2['pid'] == $chl['cid']){
								$channelinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->channelInfo($chl2['cid']));
								$channeldesc = $channelinfo['channel_description'];
								$edit2 = 0;
								$re = '/\[img\](.*?)\[\/img\]/im';
								preg_match_all($re, $channeldesc, $matches, PREG_SET_ORDER, 0);
								foreach($matches as $mat){
									$parse = parse_url(str_ireplace('www.', '', $mat[1]));
									if(!in_array($parse['host'], $this->config['functions_ClearImg']['url'])){
										$edit2 = 1;
										$channeldesc = substr(str_ireplace($mat[0], self::$l->success_edit_description_ClearImg, $channeldesc), 0, 8191);
									}
								}
								if($edit2 == 1){
									self::$tsAdmin->channelEdit($chl2['cid'], [ 'channel_description' => $channeldesc ]);
								}
							}
						}
					}
				}
				self::$clearImgTime = time()+1;
			}
		}
	}

?>