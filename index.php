<?php
/*
 * 源目录地址
 */
define ('STATIC_URL','http://www.lwjwz.tk/');

/*
 * 运行环境 DEV / PRODUCT / TEST
 */
define ('FWCDN_MODE','DEV');

$cacheFileClass='File';

/*
 * 环境设置
 */
if (defined('FWCDN_MODE')){
	switch (constant('FWCDN_MODE')){
		case 'DEV':
		case 'TEST':
			error_reporting(E_ALL);
		break;
		case 'PRODUCT':
			error_reporting(0);
		break;
	}
}
define ('FWCDN_ROOT',dirname(__FILE__).'/');
require FWCDN_ROOT.'include/FWCDN.class.php';
FWCDN::start();