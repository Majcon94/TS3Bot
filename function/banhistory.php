<?php

	class BanHistory extends Command {

		private static $old_banList = [];

		public function execute(): void
		{
			$banList = self::$tsAdmin->getElement('data', self::$tsAdmin->banList());
			$array_diff_key = array_diff_key($banList, self::$old_banList);
			if(!empty($array_diff_key)){
				foreach($array_diff_key as $value){
					if(!empty($value['ip']) || !empty($value['uid'])){
						try {
							$query = self::$db->query("SELECT COUNT(id) as `count` FROM `banhistory` WHERE `banid` = {$value['banid']}");
							while($row = $query->fetch()){
								if($row['count'] == 0){
									if(!empty($value['uid'])){
										$clientGetDbIdFromUid = self::$tsAdmin->getElement('data', self::$tsAdmin->clientGetDbIdFromUid($value['uid']));
										if(!empty($clientGetDbIdFromUid)){
											$cldbid = $clientGetDbIdFromUid['cldbid'];
										}else{
											$cldbid = 0;
										}
									}else{
										
										$cldbid = 0;
									}
									self::$db->query("INSERT INTO `banhistory` (`id`, `banid`, `ip`, `uid`, `cldbid`, `lastnickname`, `created`, `duration`, `invokername`, `invokercldbid`, `invokeruid`, `reason`) VALUES (NULL, {$value['banid']}, '{$value['ip']}', '{$value['uid']}', {$cldbid}, '{$value['lastnickname']}', {$value['created']}, '{$value['duration']}', '{$value['invokername']}', {$value['invokercldbid']}, '{$value['invokeruid']}', '{$value['reason']}')");
								}
							}
						} catch (PDOException $e) {
							$this->bot->log(1, $e->getMessage());
						}
					}
				}
				self::$old_banList = $banList;
			}
		}
	}

?>