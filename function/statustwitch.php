<?php

	class StatusTwitch extends Command {

		private static $statusTwitch_time = 0;
		private static $statusTwitch_online = [];
		private $token = NULL;
		private $users = NULL;
		private $follows = NULL;
		private $emot = NULL;
		private $streams = NULL;

		private function setToken(): void
		{
			$ch = curl_init();
				curl_setopt_array($ch, [
				CURLOPT_URL => "https://id.twitch.tv/oauth2/token?client_id={$this->config['functions_StatusTwitch']['apikay']}&client_secret={$this->config['functions_StatusTwitch']['secret']}&grant_type=client_credentials",
				CURLOPT_POST => 1,
				CURLOPT_RETURNTRANSFER => true,
			]);
			$token = json_decode(curl_exec($ch), true);
			if(!$token['access_token']){
				// tu log że ni ma tokena
			}else{
				$this->token = $token['access_token'];
			}
		}

		private function setUsers(string $name): void
		{
			$ch = curl_init();
				curl_setopt_array($ch, [
					CURLOPT_URL => "https://api.twitch.tv/helix/users?login={$name}",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTPHEADER => [
						'Authorization: Bearer '.$this->token,
						'Client-ID: '.$this->config['functions_StatusTwitch']['apikay']
						],
				]);
			$this->users = json_decode(curl_exec($ch));
		}

		private function setFollows(): void
		{
			$ch = curl_init();
				curl_setopt_array($ch, [
					CURLOPT_URL => "https://api.twitch.tv/helix/users/follows?to_id={$this->users->data[0]->id}&first=1",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTPHEADER => [
						'Authorization: Bearer '.$this->token,
						'Client-ID: '.$this->config['functions_StatusTwitch']['apikay']
					],
				]);
			$this->follows = json_decode(curl_exec($ch));
		}

		private function setEmotes(): void
		{
			$ch = curl_init();
			curl_setopt_array($ch, [
			CURLOPT_URL => "https://api.twitchemotes.com/api/v4/channels/{$this->users->data[0]->id}",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => [
				'Authorization: Bearer '.$this->token,
				'Client-ID: '.$this->config['functions_StatusTwitch']['apikay']
				],
			]);
			$emotes = json_decode(curl_exec($ch));
			$emot = NULL;
			foreach($emotes->emotes as $e){
				$emot .= "[img]https://static-cdn.jtvnw.net/emoticons/v1/{$e->id}/1.0[/img] {$e->code}\n";
			}
			$this->emot = $emot;
		}

		private function setStreams(string $name): void
		{
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL => "https://api.twitch.tv/helix/streams?user_login={$name}",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => [
					'Authorization: Bearer '.$this->token,
					'Client-ID: '.$this->config['functions_StatusTwitch']['apikay']
				],
			]);
			$this->streams = json_decode(curl_exec($ch));
		}
	
		public function execute(): void
		{
			if(self::$statusTwitch_time <= time()){
				foreach($this->config['functions_StatusTwitch']['cid_name'] as $cid => $value){
					$this->setToken();
					$this->setUsers($value['users']);
					$this->setFollows();
					$this->setEmotes();
					$this->setStreams($value['users']);
					if(empty(self::$statusTwitch_online[$this->users->data[0]->id])){
						self::$statusTwitch_online[$this->users->data[0]->id] = 0;
					}
					if(!empty($this->streams->data[0])){
						$ch = curl_init();
							curl_setopt_array($ch, [
							CURLOPT_URL => "https://api.twitch.tv/helix/games?id={$this->streams->data[0]->game_id}",
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HTTPHEADER => [
								'Authorization: Bearer '.$this->token,
								'Client-ID: '.$this->config['functions_StatusTwitch']['apikay']
							],
						]);
						$games = json_decode(curl_exec($ch));
						$strtotime = strtotime($this->streams->data[0]->started_at);
						$data = $this->bot->przelicz_czas(time()-$strtotime);
						$txt_time = $this->bot->wyswietl_czas($data, 1, 1, 1, 0, 0);
						$statusTwitch_name = self::$l->sprintf($value['channel_name'], '[Online]');
						$channel_description = self::$l->sprintf(self::$l->online_StatusTwitch, $this->users->data[0]->profile_image_url, 'https://twitch.tv/'.$this->streams->data[0]->user_name, $this->streams->data[0]->user_name, $games->data[0]->name, $this->streams->data[0]->title, $this->streams->data[0]->viewer_count, $txt_time, $this->follows->total, $this->emot);
						$channelinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->channelInfo($cid));
						if($channelinfo['channel_description'] != $channel_description){
							$data['channel_description'] = $channel_description;
							if($channelinfo['channel_name'] != $statusTwitch_name){
								$data['channel_name'] = $statusTwitch_name;
							}
							$channelEdit = self::$tsAdmin->channelEdit($cid, $data);
							if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
								$this->bot->log(1, 'Kanał o ID:'.$cid.' nie istnieje Funkcja: statusTwitch()');
							}
						}
						if(self::$statusTwitch_online[$this->users->data[0]->id] == 0 && $value['info'] == true){
							self::$statusTwitch_online[$this->users->data[0]->id] = 1;
							foreach($this->bot->getClientList() as $cl) {
								self::$tsAdmin->sendMessage(1, $cl['clid'], self::$l->sprintf($value['info_text'], $this->streams->data[0]->user_name, 'https://twitch.tv/'.$this->streams->data[0]->user_name));
							}
						}
					}else{
						if(self::$statusTwitch_online[$this->users->data[0]->id] == 1){
							self::$statusTwitch_online[$this->users->data[0]->id] = 0;
						}
						$statusTwitch_name = self::$l->sprintf($value['channel_name'], '[Offline]');
						$channel_description = self::$l->sprintf(self::$l->offline_StatusTwitch, $this->users->data[0]->profile_image_url, 'https://twitch.tv/'.$this->users->data[0]->display_name, $this->users->data[0]->display_name, $this->follows->total, $this->emot);
						$channelinfo = self::$tsAdmin->getElement('data', self::$tsAdmin->channelInfo($cid));
						if($channelinfo['channel_description'] != $channel_description){
							$data['channel_description'] = $channel_description;
							if($channelinfo['channel_name'] != $statusTwitch_name){
								$data['channel_name'] = $statusTwitch_name;
							}
							$channelEdit = self::$tsAdmin->channelEdit($cid, $data);
							if(!empty($channelEdit['errors'][0]) && $channelEdit['errors'][0] != 'ErrorID: 771 | Message: channel name is already in use'){
								$this->bot->log(1, 'Kanał o ID:'.$cid.' nie istnieje Funkcja: statusTwitch()');
							}
						}
					}
				}
				self::$statusTwitch_time = time()+60;
			}
		}
	}

?>