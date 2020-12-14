<?php

	class AktualnaData extends Command {

		public static $aktualnadata = NULL;

		public function execute(): void
		{
			$data = date($this->config['functions_AktualnaData']['format']);
			if($data != self::$aktualnadata){
				$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_AktualnaData']['cid'], [ 'channel_name' => self::$l->sprintf(self::$l->success_channel_name_AktualnaData, $data) ]);
				if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
					$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_AktualnaData']['cid'].' nie istnieje Funkcja: AktualnaData()');
				}
				self::$aktualnadata = $data;
			}
		}
	}

?>