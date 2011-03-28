<?php defined('SYSPATH') or die('No direct script access.'); ?>

2010-06-17 00:58:44 --- ERROR: Kohana_Exception [ 0 ]: Invalid method find_by_name called in Model_Maker ~ MODPATH/orm\classes\kohana\orm.php [ 293 ]
2010-06-17 00:59:56 --- ERROR: Database_Exception [ 1054 ]: Unknown column 'sadasd' in 'where clause' [ SELECT `makers`.* FROM `makers` WHERE `sadasd` LIKE '%sadasd%' AND `type` = 0 ORDER BY `makers`.`id` ASC ] ~ MODPATH/database\classes\kohana\database\mysql.php [ 174 ]
2010-06-17 01:07:42 --- ERROR: ErrorException [ 8 ]: Undefined index: type ~ APPPATH/classes\controller\admin\makers.php [ 28 ]
2010-06-17 10:00:01 --- ERROR: ErrorException [ 2 ]: mysql_connect() [function.mysql-connect]: Access denied for user 'root'@'localhost' (using password: YES) ~ MODPATH/database\classes\kohana\database\mysql.php [ 56 ]