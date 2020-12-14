<?php

	class AktualnieOnline extends Command {

		public static $aktualnie_online = 0;
		
		public function execute(): void
		{
			$serverinfo = $this->bot->getServerInfo();
			$count = $serverinfo['virtualserver_clientsonline'] - $serverinfo['virtualserver_queryclientsonline'];
			if(self::$aktualnie_online != $count){
				$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_AktualnieOnline']['cid'], [ 'channel_name' => self::$l->sprintf(self::$l->success_AktualnieOnline, $count, $this->bot->padding_numbers($count, 'osoba', 'osoby', 'osób'))]);
				if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
						$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_AktualnieOnline']['cid'].' nie istnieje Funkcja: AktualnieOnline()');
				}
				self::$aktualnie_online = $count;
			}
		}
	}

?>