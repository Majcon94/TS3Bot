<?php

	class ServerName extends Command {

		private static $servername_online = 0;

		public function execute(): void
		{
			$serverinfo = $this->bot->getServerInfo();
			$count = $serverinfo['virtualserver_clientsonline'] - $serverinfo['virtualserver_queryclientsonline'];
			if(self::$servername_online != $count){
				self::$tsAdmin->serverEdit(array('virtualserver_name' => str_replace('{1}', $count, $this->config['functions_ServerName']['name'])));
				self::$servername_online = $count;
			}
		}
	}

?>