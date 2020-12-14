<?php 
	class Language {

		private $lang = [];
		
		public function __get($nazwa) {
			return $this->lang[$nazwa];
		}

		public function load($langues, $file){
			$path = 'langues/'.$langues.'/'.$file.'.lang.php';
			if(file_exists($path)){
				require_once $path;
				$this->lang = array_merge($this->lang, $lang);
			}
		}

		public function sprintf($string){
			$array = func_get_args();
			$num_args = count($array);
			for($i = 1; $i < $num_args; $i++){
				$string = str_replace('{'.$i.'}', $array[$i], $string);
			}
			return $string;
		}

	}
?>