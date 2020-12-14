<?php

	class RekordOnline extends Command {

		public function execute(): void
		{
			$file = file_get_contents('includes/rekord.php');
			$explode = explode('|', $file);
			$serverinfo = $this->bot->getServerInfo();
			$count = $serverinfo['virtualserver_clientsonline'] - $serverinfo['virtualserver_queryclientsonline'];
			if($explode[0] < $count){
				$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_RekordOnline']['cid'], [
					'channel_name' => self::$l->sprintf(self::$l->success_RekordOnline, $count, $this->bot->padding_numbers($count, 'osoba', 'osoby', 'osób')), 'channel_description' => self::$l->sprintf(self::$l->success_description_RekordOnline, date($this->config['functions_RekordOnline']['format']))
				]);
				if(!empty($channelEdit['errors'][0])){
					$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_RekordOnline']['cid'].' nie istnieje Funkcja: rekord_online()');
				}
				file_put_contents('includes/rekord.php', $count.'|'.time());
				$this->bot->log(2, 'Ustanowiono rekord osób online: '.$count);
			}
		}
	}

?>