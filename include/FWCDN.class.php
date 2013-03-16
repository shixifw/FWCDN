<?php
class FWCDN{
	protected static $content_type='text/html';
	protected static $cacheExt=array(
		'jpg'=>'',
		'jpeg'=>'',
		'png'=>'image/png',
		'css'=>'',
		'js'=>'',
		'zip'=>'',
		'rar'=>'',
		'pdf'=>'',
	); 
	protected static $succeed=true;
	protected static $ext;
	public static function start(){
		function __autoload($class){
			if (is_file (FWCDN_ROOT.'include/'.ucfirst(strtolower($class)).'.class.php')){
				require FWCDN_ROOT.'include/'.ucfirst(strtolower($class)).'.class.php';
			}
		}
		if (!isset($_GET['q'])){
			require FWCDN_ROOT.'views/welcome.php';
			exit;
		}
		$name=$_GET['q'];
		if (!self::canCache($name)){
			//header("HTTP/1.1 301 Moved Permanently");
			//header("Location: ".constant('STATIC_URL').$name);
			exit;
		}
		self::handle($name);
		
	}
	public static function canCache($name){
		$name=basename($name);
		$name=explode ('.',$name);
		$name=array_pop($name);
		if (isset(self::$cacheExt[$name])){
			self::$ext=$name;
			return true;
		}
		else{
			return false;
		}
	} 
	public static function handle($name){
		global $cacheFileClass;
		$handle=new $cacheFileClass();
		if ($handle->exist(FWCDN_ROOT.'cdn/'.$name)){
			$content=$handle->read(FWCDN_ROOT.'cdn/'.$name);
		}
		else{
			$content=file_get_contents(STATIC_URL.$name);
			var_dump($content);
			self::_mkdirs(dirname(FWCDN_ROOT.'cdn/'.$name),0766);
			$handle->write(FWCDN_ROOT.'cdn/'.$name,$content);
		}
		self::render($content);
		
	}
	public static function render($content){
		if(!self::$succeed){
			self::error();
			return ;
		}else{
			header("Expires: " . date("D, j M Y H:i:s GMT", time()+2592000));//缓存一月
			header('Content-type: '.self::$cacheExt[self::$ext]);
			//header('Content-type: image/png');
			ob_clean();
			echo $content;
		}
	} 
	public static function _mkdirs($path,$mode=0755){
		if (!is_dir($path)){
			self::_mkdirs(dirname($path),$mode);
			@mkdir($path,$mode);
			return;
		}
		return;
	}
	public static function error(){
		echo "<strong>something seems wrong.</strong>";
	} 
}