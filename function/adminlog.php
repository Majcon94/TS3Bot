<?php

	class AdminLog extends Command {

		public static $oldLogs = [];
		
		public function execute(): void
		{
			$adminList = [];
			foreach($this->config['functions_AdminLog']['gid'] as $gid){
				$serverGroupClientList = self::$tsAdmin->getElement('data', self::$tsAdmin->serverGroupClientList($gid));
				foreach($serverGroupClientList as $sgcl){
					if(isset($sgcl['cldbid'])){
						$adminList[$sgcl['cldbid']] = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($sgcl['cldbid']));
					}
				}
			}
			$logView = self::$tsAdmin->getElement('data', self::$tsAdmin->logView(50));
			$array_reduce = array_reduce($logView, function ($array_reduce, $value) {
				return array_merge($array_reduce, array_values($value));
			}, []);
			$array_diff = array_diff($array_reduce, self::$oldLogs);
			if($array_diff){
				foreach($array_diff as $ad){
					$log = null;
					$explode = explode('|', $ad);
					$explodedate = explode('.', $explode[0]);
					$data = date("d-m-Y H:i:s", strtotime($explodedate[0]));
					preg_match_all('/ban added reason=\'(.*)\' cluid=\'(.*)\' bantime=(\d+) by client \'(.*)\'\(id:(\d+)\)/m', $ad, $matches, PREG_SET_ORDER, 0);
					if(isset($matches[0][5]) && array_key_exists($matches[0][5], $adminList)){
						$clientGetDbIdFromUid = self::$tsAdmin->getElement('data', self::$tsAdmin->clientGetDbIdFromUid($matches[0][2]));
						$clientDbInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($clientGetDbIdFromUid['cldbid']));
						$log = '['.$data.'] '.$adminList[$matches[0][5]]['client_nickname'].'('.$adminList[$matches[0][5]]['client_database_id'].') zbanował '.$clientDbInfo['client_nickname'].'('.$clientDbInfo['client_database_id'].') powód: '.$matches[0][1].' czas: '.$matches[0][3].'s';
						$cldbid = $matches[0][5];
					}
					preg_match_all('/ban deleted reason=\'(.*)\' cluid=\'(.*)\' bantime=(\d+) by client \'(.*)\'\(id:(\d+)\)/m', $ad, $matches, PREG_SET_ORDER, 0);
					if(isset($matches[0][5]) && array_key_exists($matches[0][5], $adminList)){
						$clientGetDbIdFromUid = self::$tsAdmin->getElement('data', self::$tsAdmin->clientGetDbIdFromUid($matches[0][2]));
						$clientDbInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($clientGetDbIdFromUid['cldbid']));
						$log = '['.$data.'] '.$adminList[$matches[0][5]]['client_nickname'].'('.$adminList[$matches[0][5]]['client_database_id'].') odbanował '.$clientDbInfo['client_nickname'].'('.$clientDbInfo['client_database_id'].') powód bana: '.$matches[0][1].' czas: '.$matches[0][3].'s';
						$cldbid = $matches[0][5];
					}
					preg_match_all('/\(id:(\d+)\)(.*)invokeruid=(.*) reasonmsg=(.*)\'/m', $ad, $matches, PREG_SET_ORDER, 0);
					if(isset($matches[0][3])){
						foreach($adminList as $al){
							if($al['client_unique_identifier'] == $matches[0][3]){
								if(strpos($matches[0][4], "bantime=") == false){
									$clientDbInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($matches[0][1]));
									$log = '['.$data.'] '.$al['client_nickname'].'('.$al['client_database_id'].') Wyrzucił z serwera '.$clientDbInfo['client_nickname'].'('.$clientDbInfo['client_database_id'].') powód: '.$matches[0][4];
									$cldbid = $al['client_database_id'];
								}
							}
						}
					}
					preg_match_all('/\(id:(\d+)\)([A-Za-z ]+)\'(.*)\'\(id:(\d+)\)\sby\sclient\s((\'(.*)\'\(id:(\d+)\)\sin\schannel\s\'(.*)\'\(id:(\d+)\))|(\'(.*)\'\(id:(\d+)\)))/m', $ad, $matches, PREG_SET_ORDER, 0);
					if((isset($matches[0][8]) && array_key_exists($matches[0][8], $adminList)) || (isset($matches[0][13]) && array_key_exists($matches[0][13], $adminList))){
						if(trim($matches[0][2]) == 'was added to channelgroup'){
							$clientDbInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($matches[0][1]));
							$log = '['.$data.'] '.$adminList[$matches[0][8]]['client_nickname'].'('.$adminList[$matches[0][8]]['client_database_id'].') Nadał rangę '.$matches[0][3].' dla '.$clientDbInfo['client_nickname'].'('.$clientDbInfo['client_database_id'].') na kanale '.$matches[0][9];
							$cldbid = $matches[0][8];
						}else if(trim($matches[0][2]) == 'was added to servergroup'){
							$clientDbInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($matches[0][1]));
							$log = '['.$data.'] '.$adminList[$matches[0][13]]['client_nickname'].'('.$adminList[$matches[0][13]]['client_database_id'].') Nadał rangę '.$matches[0][3].' dla '.$clientDbInfo['client_nickname'].'('.$clientDbInfo['client_database_id'].')';
							$cldbid = $matches[0][13];
						}else if(trim($matches[0][2]) == 'was removed from servergroup'){
							$clientDbInfo = self::$tsAdmin->getElement('data', self::$tsAdmin->clientDbInfo($matches[0][1]));
							$log = '['.$data.'] '.$adminList[$matches[0][13]]['client_nickname'].'('.$adminList[$matches[0][13]]['client_database_id'].') Ściągnął rangę '.$matches[0][3].' dla '.$clientDbInfo['client_nickname'].'('.$clientDbInfo['client_database_id'].')';
							$cldbid = $matches[0][13];
						}
					}
					preg_match_all('/client(.*)\'(.*)\'\(id:(\d+)\)/m', $ad, $matches, PREG_SET_ORDER, 0);
					if(isset($matches[0][3]) && array_key_exists($matches[0][3], $adminList)){
						if(trim($matches[0][1]) == 'connected'){
							$log = '['.$data.'] '.$adminList[$matches[0][3]]['client_nickname'].'('.$adminList[$matches[0][3]]['client_database_id'].') połączył się z serwerem';
							$cldbid = $matches[0][3];
						}else if(trim($matches[0][1]) == 'disconnected'){
							$log = '['.$data.'] '.$adminList[$matches[0][3]]['client_nickname'].'('.$adminList[$matches[0][3]]['client_database_id'].') rozłączył się z serwerem';
							$cldbid = $matches[0][3];
						}
					}
					preg_match_all('/channel \'(.*)\(id:(\d+)\)(.*)\(id:(\d+)\)/m', $ad, $matches, PREG_SET_ORDER, 0);
					if(isset($matches[0][4]) && array_key_exists($matches[0][4], $adminList)){
						$log = '['.$data.'] '.$adminList[$matches[0][4]]['client_nickname'].'('.$adminList[$matches[0][4]]['client_database_id'].') edytował kanał '.$matches[0][1].'('.$matches[0][2].')';
						$cldbid = $matches[0][4];
					}
					if(isset($log, $cldbid)){
						$catalog = "log/admin/{$cldbid}";
						if(!file_exists($catalog)) {
							mkdir($catalog, 0777, true);
						}
						$filename = $catalog.'/'.date('d.m.Y').'_log.log';
						if(file_exists($filename)) {
							$plik = file($filename, FILE_IGNORE_NEW_LINES);
							if(!in_array($log, $plik)) {
								$fp = @fopen($filename, "a"); 
								flock($fp, 2); 
								fwrite($fp, $log."\n");
								flock($fp, 3); 
								fclose($fp);
							}
						}else{
							$fp = @fopen($filename, "a"); 
							flock($fp, 2); 
							fwrite($fp, $log."\n"); 
							flock($fp, 3); 
							fclose($fp);
						}
					}
				}
				self::$oldLogs = $array_diff;
			}
		}
	}

?>