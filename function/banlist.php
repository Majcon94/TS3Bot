<?php

	class BanList extends Command {

		public static $banList_old = NULL;

		public function execute(): void
		{
			$banList = self::$tsAdmin->getElement('data', self::$tsAdmin->banList());
			if(!empty($banList)){
				$banList = array_reverse($banList);
				$i = 0;
				$row = NULL;
				foreach($banList as $bl) {
					if(!empty($bl['lastnickname']) && !empty($bl['uid'])){
						$i++;
						if($bl['duration'] == 0){
							$duration = 'PERM';
						}else{
							$duration = date('d.m.Y H:i:s', $bl['created']+$bl['duration']);
						}
						$clientGetDbIdFromUid = self::$tsAdmin->getElement('data', self::$tsAdmin->clientGetDbIdFromUid($bl['uid']));
						$lastnickname = $this->bot->getUrlName($clientGetDbIdFromUid['cldbid'] ?? 'b/d', $bl['uid'] ?? 'b/d', $bl['lastnickname'] ?? 'b/d') ?? 'b\d';
						$invokername = $this->bot->getUrlName($bl['invokercldbid'], $bl['invokeruid'], $bl['invokername']);
						$created = date('d.m.Y H:i:s', (int)$bl['created']);
						$row .= self::$l->sprintf(self::$l->BanList_row, $i, $lastnickname, $bl['reason'], $invokername, $created, $duration);
					}
					if($i >= $this->config['functions_BanList']['limit']){
						break;
					}
				}
				$data = self::$l->sprintf(self::$l->BanList_data, $row);
				if($data != self::$banList_old){
					$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_BanList']['cid'], ['channel_description' => $data]);
					if(!empty($channelEdit['errors'][0])){
						$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_BanList']['cid'].' nie istnieje Funkcja: BanList()');
					}
					self::$banList_old = $data;
				}
			}else if(!empty(self::$banList_old)){
				self::$banList_old = NULL;
				$channelEdit = self::$tsAdmin->channelEdit($this->config['functions_BanList']['cid'], ['channel_description' => self::$l->empty_list_of_bans_BanList ]);
				if(!empty($channelEdit['errors'][0])){
					$this->bot->log(1, 'Kanał o ID:'.$this->config['functions_BanList']['cid'].' nie istnieje Funkcja: BanList()');
				}
			}
		}
	}

?>