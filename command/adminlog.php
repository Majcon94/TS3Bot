<?php
	if(empty($msg[1])){
		$this->sendMessage($invokerid, Bot::$l->error_give_clidbid_adminlog);
	}else{
		if(is_numeric($msg[1])){
			$cldbid = $msg[1];
		}else{
			$clientGetDbIdFromUid = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetDbIdFromUid($msg[1]));
			if(!empty($clientGetDbIdFromUid)){
				$cldbid = $clientGetDbIdFromUid['cldbid'];
			}
		}
		if(empty($msg[2])){
			$data = date('d.m.Y');
		}else{
			$sr = str_replace([ '-', '/' ], '.', $msg[2]);
			$dataexp = explode('.', $sr);
			if(empty($dataexp[0]) || empty($dataexp[1]) || empty($dataexp[2]) || $dataexp[0] > 31 || $dataexp[0] < 1 || $dataexp[1] > 12 || $dataexp[1] < 1 || $dataexp[2] < 1950 || $dataexp[2] > date('Y')){
				$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->error_wrong_format_adminlog, date('d.m.Y')));
			}else{
				$data = $dataexp[0].'.'.$dataexp[1].'.'.$dataexp[2];
			}
		}
		if(!empty($data)){
			$filename = 'log/admin/'.$cldbid.'/'.date('d.m.Y').'_log.log';
			if(file_exists($filename)) {
				$file = file($filename);
				$log = NULL;
				for ($i = max(0, count($file)-26); $i < count($file); $i++) {
					$log .= $file[$i];
				}
				$clientDbInfo = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientDbInfo($cldbid));
				$nick = $this->getUrlName($cldbid, $clientDbInfo['client_unique_identifier'], $clientDbInfo['client_nickname']);
				$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->success_display_log_adminlog, $nick, $log));
			}else{
				$this->sendMessage($invokerid, Bot::$l->sprintf(Bot::$l->error_no_logs_adminlog, $cldbid, $data));
			}
		}
	}
