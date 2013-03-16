<?php
class File{
	public function exist($name){
		return is_file($name);
	}
	public function read ($name){
		$handle=fopen($name, 'r');
		$return='';
		while (!feof($handle)){
			$return.=fread($handle, 1000);
		}
		return $return;
	}
	public function write($name,$inner){
		$handle=fopen($name, 'w');
		return fwrite ($handle,$inner);
	}
}