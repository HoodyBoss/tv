<?php
	error_reporting(1);
	class connect_db {
		// ======= Start variable of class ===========
		var $host="localhost";
		var $database="tv_demo";
		var $user="chong";
		var $password="123qwe";
		var $link_con=0;
		var $sqlquery;
		var $result;
		var $count;
		var $ERRNO;
		var $ERROR;		

		// ======= Stop variable of class ===========

		// ======= Start method of class ===========
		function connect_db() {
	  		$this->link_con = mysql_connect($this->host, $this->user, $this->password) or die("Can't Connect" . mysql_error());
			mysql_select_db($this->database, $this->link_con);
		}

		function change_db($database) {
			mysql_select_db($database, $this->link_con);
		}

		function get_database() {
			return $this->database;
		}

		function send_cmd($query){
  			$this->sqlquery = $query;
  			$this->result = mysql_query($query,$this->link_con);
  			$this->ERRNO = mysql_errno();
  			$this->ERROR = mysql_error();
  			$this->count = mysql_num_rows($this->result);
  			return $this->count;
		}

		function affected_rows() {
			return mysql_affected_rows($this->link_con);
		}

		function get_id() {
			return mysql_insert_id($this->link_con);
		}

		function get_data(){
			return mysql_fetch_row($this->result);
		}

		function get_result(){
			return mysql_fetch_array($this->result , MYSQL_BOTH);
		}

		function data_seek($torow){
			return mysql_data_seek($this->result,$torow);
		}

		function num_rows(){
			return $this->count;
		}

		function show_error() {
			echo $this->sqlquery."<br>".mysql_errno().":".mysql_error()."<br>\n";
		}

		function free_result(){
			mysql_free_result($this->result);
		}

		function close() {
			mysql_close($this->link_con);
		}
		// ======= Stop method of class ===========
	} // end of class
	$db = new connect_db();

	// =========== Check current filename =================
	$FileName = basename($PHP_SELF);
	// =========== Check current database ================
	$Database = $db->get_database();
	// ======== Set up global system value =================
	$BG = "#FFFFFF";
	$BG_BORDER = "#6699CC";
	$BG_DATA = "#FFFFFF";
	$BG_MENU = "#016B9E";
	$BG_MENU_ACTIVE = "#990000";
	$activity_id = 41;
	
	$sql = "SET NAMES UTF8" ;
	$db->send_cmd($sql);
	
	$conn =  mysql_connect($db_host,$db_user,$db_pass);
	mysql_select_db($db_name);
	
?>
