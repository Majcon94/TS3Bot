<?php

	class StatusYt extends Command {

		private static $statusYt_time = 0;
		private static $statusYt_description = [];

		public function execute(): void
		{
			if(self::$statusYt_time <= time()){
				foreach($this->config['functions_StatusYt']['cid_id'] as $cid => $id){
					self::$statusYt_description[$cid] = self::$statusYt_description[$cid] ?? NULL;
					$jdc = json_decode($this->bot->file_get_contents_curl("https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id={$id}&key={$this->config['functions_StatusYt']['key']}"));
					if(!empty($jdc->items[0])){
						$channel_description = self::$l->sprintf(self::$l->channel_description_StatusYt, $jdc->items[0]->id, $jdc->items[0]->snippet->title, $jdc->items[0]->statistics->subscriberCount, $jdc->items[0]->statistics->viewCount, $jdc->items[0]->snippet->description, $jdc->items[0]->snippet->thumbnails->medium->url);
						$channel_name = self::$l->sprintf(self::$l->channel_name_StatusYt, $jdc->items[0]->snippet->title, $jdc->items[0]->statistics->subscriberCount);
						self::$tsAdmin->channelEdit($cid, [ 'channel_name' => $channel_name ]);
						if(self::$statusYt_description[$cid] != $channel_description){
							$channelEdit = self::$tsAdmin->channelEdit($cid, [ 'channel_description' => $channel_description ]);
							if(!empty($channelEdit['errors'][0])){
								$this->bot->log(1, 'Kanał o ID:'.$cid.' nie istnieje Funkcja: statusYt()');
							}
							self::$statusYt_description[$cid] = $channel_description;
						}
					}
				}
				self::$statusYt_time = time()+60;
			}
		}
	}

?>