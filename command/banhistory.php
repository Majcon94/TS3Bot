<?php
	if(!empty($msg[1])){
		$list = NULL;
		$query = Bot::$db->prepare("SELECT COUNT(`id`) as `count`, `banid`, `ip`, `uid`, `cldbid`, `lastnickname`, `created`, `duration`, `invokername`, `invokercldbid`, `invokeruid`, `reason` FROM `banhistory` WHERE `ip` = :msg OR `uid` = :msg OR `cldbid` = :msg GROUP BY `id`");
		$query->bindValue(':msg', $msg[1], PDO::PARAM_STR);
		$query->execute();
		while($row = $query->fetch()){
			if(!empty($row['count'])){
				$invokername = $this->getUrlName($row['invokercldbid'], $row['invokeruid'], $row['invokername']);
				$list .= Bot::$l->sprintf(Bot::$l->row_banhistory, $row['banid'], $row['ip'] ?? 'Brak danych', $row['uid'] ?? 'Brak danych', $row['cldbid'] ?? 'Brak danych', $row['lastnickname'] ?? 'Brak danych', date('d.m.Y H:i:s', $row['created']), $row['duration'] == 0 ? 'PERM' : date('d.m.Y H:i:s', $row['created']+$row['duration']), $row['reason'], $invokername);
			}
		}
		if(!empty($list)){
			$this->sendMessage($invokerid, $list);
		}else{
			$this->sendMessage($invokerid, 'Brak banów');
		}
	}else{
		$this->sendMessage($invokerid, Bot::$l->error_give_cldbid_banhistory);						
	}
?>