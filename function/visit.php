<?php

	class Visit extends Command {

		private static $count = 0;

		public function execute(): void
		{
			$clientDbList =  self::$tsAdmin->clientDbList(0, 2, true);
			$clientDbList =  self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbList(0, 2, true));
			if(self::$count < $clientDbList[0]['count']){
				$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_Visit']['cid'], [
					'channel_name' => self::$l->sprintf(self::$l->success_Visit, $clientDbList[0]['count'], $this->bot->padding_numbers($clientDbList[0]['count'], 'osoba', 'osoby', 'osób'))
				]);
				self::$count = $clientDbList[0]['count'];
				if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
					$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_RekordOnline']['cid'].' nie istnieje Funkcja: Visit()');
				}
			}
		}
	}

?>