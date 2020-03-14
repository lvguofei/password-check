<?php
error_reporting(E_ALL ^ E_DEPRECATED);
final class lib{
	
    final protected function __clone()
    {
        // TODO: Implement __clone() method.
    }
    public function connect_db(){

		$host='';
		$root = '';
		$pwd = '';
		$dbname = "";
		$con = mysql_connect($host,$root,$pwd);
		if(!$con){
			die(mysql_error());
		}
		mysql_select_db($dbname) or die("Could not select database!");  
		mysql_query('set names "utf8"');
	}
}
?>