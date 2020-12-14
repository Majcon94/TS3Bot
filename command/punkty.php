<?php
	$clientGetDbIdFromUid = Bot::$tsAdmin->getElement('data', Bot::$tsAdmin->clientGetDbIdFromUid($invokeruid));
	$cldbid = $clientGetDbIdFromUid['cldbid'];
	$query = Bot::$db->query("SELECT `pkt` FROM `users` WHERE `cldbid` = {$cldbid}");
	while($row = $query->fetch()){
		$this->sendMessage($invokerid, "Aktualnie posiadasz {$row['pkt']} punktów.");
	}
?>