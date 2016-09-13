<?php
	include "utils/autogenerate.php";

	$method = $_POST["method"];
	
	if ($method == "backup")
	{
		//Backup account
		$sql = "INSERT INTO tb_b_account_hist (id, username, password, firstname, lastname, dateregis, status, user_group, hotspot_id, boardingpass_code, authen_url, flight_no, expire_date, last_access, cd, cb, mb, md , backup_date ) select id, username, password, firstname, lastname, dateregis, status, user_group, hotspot_id, boardingpass_code, authen_url, flight_no, expire_date, last_access, cd, cb, mb, md , now() from tb_b_account where expire_date < now()";
		//echo "<br>".$sql;
		$db->send_cmd($sql);
		$acctResult = $db->affected_rows();
		//echo "<br>Account res : ".$acctResult;
		if ($acctResult > 0)
		{
			//Backup radacct
			$sql = "INSERT INTO radacct_hist (radacctid, acctsessionid, acctuniqueid, username, groupname, realm, nasipaddress, nasportid, nasporttype, acctstarttime, acctstoptime, acctsessiontime, acctauthentic, connectinfo_start, connectinfo_stop, acctinputoctets, acctoutputoctets, calledstationid, callingstationid, acctterminatecause, servicetype, framedprotocol, framedipaddress, acctstartdelay, acctstopdelay, xascendsessionsvrkey, hotspot_macadd , backup_date)";
			$sql .= "SELECT radacctid, acctsessionid, acctuniqueid, username, groupname, realm, nasipaddress, nasportid, nasporttype, acctstarttime, acctstoptime, acctsessiontime, acctauthentic, connectinfo_start, connectinfo_stop, acctinputoctets, acctoutputoctets, calledstationid, callingstationid, acctterminatecause, servicetype, framedprotocol, framedipaddress, acctstartdelay, acctstopdelay, xascendsessionsvrkey, hotspot_macadd , now() FROM radacct where username in (select username from tb_b_account where expire_date < now() ) ";
			$db->send_cmd($sql);
			$radAcctResult = $db->affected_rows();
			//echo "<br>radAcctResult res : ".$radAcctResult;
			if ( $radAcctResult > 0 )
			{
				//Backup radcheck
				$sql = "INSERT INTO radcheck_hist ( id, username, attribute, op, value, c_time , backup_date)  select id, username, attribute, op, value, c_time , now() from radcheck where username in ( select username from tb_b_account where expire_date < now() )";
				$db->send_cmd($sql);
				$radChkResult = $db->affected_rows();
				//echo "<br>Rad check qry > ".$sql;
				//echo "<br>radChkResult res : ".$radChkResult;
				if ( $radChkResult > 0 )
				{
					//Delete data from main table
					//Account
					$db->send_cmd( "delete from radcheck where username in (select username from tb_b_account where expire_date < now() )" );
					$delRadChkResult = $db->affected_rows();
					$db->send_cmd( "delete from radacct where username in (select username from tb_b_account where expire_date < now() )" );
					$delRadAcctResult = $db->affected_rows();
					$db->send_cmd( "delete from tb_b_account where expire_date < now()" );
					$delAcctResult = $db->affected_rows();
					
					$processResult = 1;
				}
				else
				{
					$db->send_cmd( "delete from radacct_hist where username in (select username from radacct where username in (select username from tb_b_account where expire_date < now()) )" );
					$db->send_cmd( "delete from tb_b_account_hist where username in (select username from tb_b_account where expire_date < now())" );
					$processResult = 8;
				}
			}
			else
			{
				$db->send_cmd( "delete from tb_b_account_hist where username in (select username from tb_b_account where expire_date < now())" );
				$processResult = 8;
			}
		}
		else
		{
			$processResult = 8;
		}

		
		//$processResult = $result > 0 ? 1 : 8;
	}

	//echo $sql;

?>

<!--  -->
<script type="text/javascript">
<!--
	function deleteItem( item , title )
	{
		if (confirm("คุณต้องการลบข้อมูล "+title+" ?"))
		{
			document.getElementById("deleteId").value = item;
			document.getElementById("method").value = "delete";
			document.getElementById("status").value = "init";
			document.forms[0].action = "<?=$curFile?>";
			document.forms[0].submit();
		}
	}

	function editItem( item )
	{
		document.getElementById("editId").value = item;
		document.getElementById("method").value = "edit";
		document.getElementById("status").value = "new";
		document.forms[0].action = "<?=$curFile?>";
		document.forms[0].submit();
	}

	function backupuser( )
	{
		if (confirm("คุณต้องการ Backup ข้อมูลผู้ใช้ทั้งหมด ?"))
		{
			document.getElementById("method").value = "backup";
			document.getElementById("status").value = "init";
			document.forms[0].action = "<?=$curFile?>";
			document.forms[0].submit();
		}
	}
//-->
</script>

<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	 <tr> 
		<td colspan = "20" valign = "middle">
			
			<div align = "left">
			กลุ่ม / Package : &nbsp;
						<select name = "group_id" id = "group_id" onchange = "localSubmitForm(new Array() , new Array())">
							<option value = "">เลือกกลุ่ม / Package</option>
							<?php
								$group_id = $_POST["group_id"];
								$sql = "select * from tb_b_user_group where group_status = 'Y'  $hotspot_clause ";
								$db->send_cmd($sql);
								while ($row=$db->get_result())
								{
							?>
							<option value = "<?=$row["id"]?>" <?=$group_id==$row["id"] ? "selected" : ""?>><?=$row["group_name"]?></option>
							<?php
								}
							?>
						</select>
			&nbsp;&nbsp;&nbsp;&nbsp;
			ค้นหา : &nbsp;&nbsp;<input type = "text" name = "quicksearch" onkeypress = "enterKey()" id = "quicksearch" value = "<?=$_POST["quicksearch"]?>" onfocus="this.value=''">&nbsp;&nbsp;<img src="images/icn_search.png" onclick = "localSubmitForm(new Array(),new Array())"></div>
			<div align = "right"><a href = "javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'user_management' , 'new' , 'จัดการข้อมูลผู้ใช้' )) "><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></div>
		</td>  
	</tr> 
	<?php
	include "processresult_bar.php";
	//$result = $db->affected_rows();
	//$processResult = $result > 0 ? 1 : 8;
	?>
</thead> 
<thead> 
	<tr> 
		<!-- <td align = "center" width = "5%"><input type = "checkbox" id = "select_all" name = "select_all" value = "ALL" onclick = "checkAll(this)"></td> -->
		<td align = "center">Username</td>
		<td align = "center">Name</td> 
		<td align = "center">Package</td> 
		<td align = "center">Used</td> 
		<td align = "center">Download</td>
		<td align = "center">Upload</td>
		<!-- <td align = "center">Actions</td>  -->
	</tr> 
</thead> 
<tbody> 
	<?php

	$quicksearch = $_POST["quicksearch"];

	$sql = "SELECT ceil( count(*)/$recPerPage ) FROM tb_b_account where 0=0 ";
	
	if (!empty($quicksearch))
	{
		$sql .= " and ( username like '%$quicksearch%' or name like '%$quicksearch%'   ) ";
	}

	if (!empty($group_id))
	{
		$sql .= " and user_group = '$group_id' ";
	}

	//echo $sql;
	$db->send_cmd($sql);
	$noOfPage = 1;
	while ($row=$db->get_data())
	{
		$noOfPage = $row[0];
	}

	$sql = "select `acc`.`id` AS `userid`,`acc`.`username` AS `username`,concat(`acc`.`firstname`,' ',`acc`.`lastname`) AS `name`,(select `ug`.`group_name` from `tb_b_user_group` `ug` where (`ug`.`id` = `acc`.`user_group`)) AS `usergroup`,(select sum(`ra`.`acctsessiontime`) from `radacct` `ra` where (convert(`ra`.`username` using utf8) = `acc`.`username`)) AS `used`,(select sum(`ra`.`acctinputoctets`) from `radacct` `ra` where (convert(`ra`.`username` using utf8) = `acc`.`username`)) AS `download`,(select sum(`ra`.`acctoutputoctets`) from `radacct` `ra` where (convert(`ra`.`username` using utf8) = `acc`.`username`)) AS `upload` from `tb_b_account` `acc` where 0=0 ";
	if (!empty($quicksearch))
	{
		$sql .= " and ( username like '%$quicksearch%' or name like '%$quicksearch%'   ) ";
	}
	if (!empty($group_id))
	{
		$sql .= " and user_group = '$group_id' ";
	}

	$sql .= " order by id desc ";
	//Paging
	$recordPerPage = empty($_REQUEST["recordPerPage"]) ? 10 : $_REQUEST["recordPerPage"];
	$pageNumber = empty($_REQUEST["pageNumber"]) ? 1 : $_REQUEST["pageNumber"];
	$groupPage = empty($_REQUEST["groupPage"]) ? 0 : $_REQUEST["groupPage"];
	$beginRec = ($pageNumber*$recordPerPage)-$recordPerPage;
	$sql .= " limit $beginRec,$recordPerPage";
	//End paging
	//echo $sql;
	$db->send_cmd($sql);
	while ($row=$db->get_result())
	{
		$id = $row["userid"];
		$username = $row["username"];
		$name = $row["name"];
		$used = $row["used"];
		$usergroup = $row["usergroup"];
		$download = $row["download"];
		$upload = $row["upload"];
	?>
	<tr> 
		
		<td>
			<?=$username?>
		</td>
		<td>
			<?=$name?>
		</td> 
		<td align = "center">
			<?=$usergroup?>
		</td> 
		<td align = "center">
			<?=empty($used) ? 0 : DateIntervalFromSec( $used )?>
		</td>
		<td align = "center">
			<?=empty($download) ? 0 : ByteUsed( $download )?>
		</td>
		<td align = "center">
			<?=empty($upload) ? 0 : ByteUsed( $upload ) ?>
		</td>
		<!-- <td align = "center"><input type="image" src="images/icn_edit.png" title="Edit" onclick = "editItem('<?=$id?>'  )"><input type="image" src="images/icn_trash.png" title="Trash" onclick = "deleteItem('<?=$id?>' , '<?=$firstname." ".$lastname?>' )"></td>  -->
	</tr> 
	<?php
	}

	include "paging.php";
	?>
	
	<tr> 
		<td colspan = "20"></td> 
	</tr> 
	<tr> 
		<td colspan = "20"><input type = "button" value = " Backup expired user " onclick = "backupuser()"></td> 
	</tr> 
</tbody> 
</table>

