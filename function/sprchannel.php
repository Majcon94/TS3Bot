<?php

	class SprChannel extends Command {

		public function execute(): void
		{
			$i = [];
			$channellist = self::$tsAdmin->getElement('data', self::$tsAdmin->channelList('-flags'));
			foreach($channellist as $cl){
				$delete = 0;
				if(!empty(in_array($cl['pid'], $this->config['functions_SprChannel']['pid'])) || ($this->config['functions_SprChannel']['cp'] == true && $cl['channel_flag_permanent'] == 0)){
					if(empty($i[$cl['pid']])){
						$i[$cl['pid']] = 1;
					}else{
						$i[$cl['pid']]++;
					}
					if($this->bot->cenzor($cl['channel_name'], 0) == true){
						$delete = 1;
					}else{
						$is = 0;
						foreach($channellist as $cl2){
							if($cl2['pid'] == $cl['cid']){
								$is++;
								if($this->bot->cenzor($cl2['channel_name'], 0) == true){
									$delete = 1;
									$sub[$is] = $cl2['cid'];
								}
							}
						}
					}
					if($delete == 1){
						if($this->config['functions_SprChannel']['setting'] == 0){
							if(!empty($sub)){
								foreach($sub as $key => $value){
									self::$tsAdmin->channelEdit($value, array('channel_name' => $key.' '.$this->config['functions_SprChannel']['new_name']));
								}
							}else{
								self::$tsAdmin->channelEdit($cl['cid'], array('channel_name' => $i[$cl['pid']].' .'.$this->config['functions_SprChannel']['new_name']));
								$this->bot->log(2, 'Wyedytowano kanał za wulgarną nazwę: (channel name: '.$cl['channel_name'].') (channel id: '.$cl['cid'].')');
							}
						}else{
							$this->bot->channelDelete($i, $cl['cid']);
							$this->bot->log(2, 'Usunięcie kanału za wulgarną nazwę (channel name: '.$cl['channel_name'].') (channel id: '.$cl['cid'].')');
						}
					}
				}
			}
		}
	}

?>