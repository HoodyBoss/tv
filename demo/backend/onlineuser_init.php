<?php

	$user_group = $_POST["user_group"]; 
	$quicksearch = $_POST["quicksearch"]; 

	$method = $_POST["method"];

	if ($method == "killsession")
	{
		$id =  $_POST["deleteId"];
		$select_user = $_POST["select_user"];
		for ($ii=0;$ii<count($select_user);$ii++)
		{
			$sql = "update radacct set package_status = 'N' , acctstoptime = now() where radacctid = '".$select_user[$ii]."' ";
			$result = $db->send_cmd($sql);
			$sql = "SELECT `radcheck`.`username`, `radcheck`.`attribute`, `radcheck`.`value`*1024*1024*1024, `radacct`.`framedipaddress`, `radacct`.`xascendsessionsvrkey`, `radacct`.`nasipaddress`, `radacct`.`acctstoptime`, `radacct`.`realm` FROM `radcheck` CROSS JOIN `radacct` ON `radcheck`.`username` = `radacct`.`username` WHERE radacct.username = (select username from tb_b_account where id = '".$select_user[$ii]."' ) and acctinputoctets = 0 and acctoutputoctets = 0 ";
			$db->send_cmd($sql);
			//echo "<br>".$sql;
			$row=$db->get_result();
			$disconnect=exec(' echo "User-Name = '.$row["username"].', Framed-IP-Address = '.$row["framedipaddress"].', X-Ascend-Session-Svr-Key = '.$row["xascendsessionsvrkey"].', NAS-IP-Address = '.$row["nasipaddress"].'" | radclient -x NAS.IP.ADD.RESS:PORT disconnect SECRET ');
			//echo '<br>User-Name = '.$row["username"].', Framed-IP-Address = '.$row["framedipaddress"].', X-Ascend-Session-Svr-Key = '.$row["xascendsessionsvrkey"].', NAS-IP-Address = '.$row["nasipaddress"].'" | radclient -x NAS.IP.ADD.RESS:PORT disconnect SECRET';
			//echo "<br>Disconnect : $disconnect";
		}
	}
	

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

	function killUserSession()
	{
		var isSelect = false;
		var obj_arr = document.forms[0].elements["select_user[]"];
		for (var ii=0;ii<obj_arr.length ;ii++ )
		{
			if (obj_arr[ii].checked)
			{
				isSelect = true;
				break;
			}
		}
		
		if (!isSelect)
		{
			alert("กรุณาเลือกผู้ใช้อย่างน้อย 1 คน");
			return;
		}
		
		if (confirm("ต้องการยกเลิกการเข้าใช้งานของผู้ใช้ ?"))
		{
			localSubmitForm(new Array( 'method', 'status' ),new Array(  'killsession' , 'init' ));
		}
		
		
	}
//-->
</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	<!-- <tr> 
		<td colspan = "5" valign = "middle"><a href = "adminhome.php?menu=user_management&status=new&desc=จัดการข้อมูลผู้ใช้"><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></td> 
	</tr>  -->
	<tr>
		<td colspan = "20">
		กลุ่มผู้ใช้ : &nbsp;&nbsp;
					<select name = "package_id" id = "package_id" onchange = "localSubmitForm(new Array(),new Array())">
						<option value = "">None</option>
						<?php
						$package_id = $_POST["package_id"];
						$sql = "select * from tb_b_user_group where 0=0 $hotspot_clause";
						$db->send_cmd($sql);
						while ($row=$db->get_result())
						{
						?>
						<option value = "<?=$row["id"]?>" <?=$row["id"] == $package_id ? "selected" : ""?> ><?=$row["group_name"]?></option>
						<?php
						}//Close generate hotspot list
						?>
					</select>&nbsp;&nbsp;&nbsp;&nbsp;
	หรือค้นหา : &nbsp;&nbsp;<input type = "text" name = "useronline_quicksearch" onkeypress = "enterKey()" id = "useronline_quicksearch" value = "<?=$_POST["useronline_quicksearch"]?>" onfocus="this.value=''">&nbsp;&nbsp;<img src="images/icn_search.png" onclick = "localSubmitForm(new Array(),new Array())">
		</td>
	</tr>
</thead> 
<thead> 
	<tr> 
		<td align = "center"></td>
		<td align = "center">Username</td>
		<td align = "center">ชื่อ</td> 
		<td align = "center">เวลาเข้า</td> 
		<td align = "center">เวลาที่ใช้ (วินาที)</td> 
		<td align = "center">วันที่ลงทะเบียน</td>
		<!-- <td align = "center">Actions</td>  -->
	</tr> 
</thead> 
<tbody> 
	<?php
	
	$useronline_quicksearch = $_POST["useronline_quicksearch"];

	$sql = "SELECT ceil( count(*)/$recPerPage ) FROM tb_b_account a,radacct b where a.username = b.username and acctinputoctets =0 and acctoutputoctets = 0   ";//$hotspot_clause
	if (!empty($useronline_quicksearch))
	{
		$sql .= " and ( username like '%$useronline_quicksearch%' or firstname like '%$useronline_quicksearch%'  or lastname like '%$useronline_quicksearch%' or mailaddr like '%$useronline_quicksearch%' or phone like '%$useronline_quicksearch%' or dateregis like '%$useronline_quicksearch%'   ) ";
	}

	if (!empty($package_id))
	{
		$sql .= " and a.user_group = '$package_id' ";
	}

	//echo $sql;
	$db->send_cmd($sql);
	$noOfPage = 1;
	while ($row=$db->get_data())
	{
		$noOfPage = $row[0];  
	}

	$sql = " select radacctid id,a.id userid,a.username,firstname,lastname,acctstarttime,date_format( acctsessiontime,'%d/%m/%Y') session_time,date_format(dateregis,'%d/%m/%Y') date_regis FROM tb_b_account a,radacct b where a.username = b.username  and acctinputoctets = 0 and acctoutputoctets = 0  ";//$hotspot_clause
	if (!empty($quicksearch))
	{
		$sql .= " and ( username like '%$quicksearch%' or firstname like '%$quicksearch%'  or lastname like '%$quicksearch%' or mailaddr like '%$quicksearch%' or phone like '%$quicksearch%' or dateregis like '%$quicksearch%'   ) ";
	}
	if (!empty($package_id))
	{
		$sql .= " and a.user_group = '$package_id' ";
	}
	$sql .= " order by b.acctstarttime ";
	//Paging

	$beginRec = ($pageNumber*$recPerPage)-$recPerPage;
	$sql .= " limit $beginRec,$recPerPage";
	//End paging
	//echo $sql;
	$db->send_cmd($sql);
	while ($row=$db->get_result())
	{
		$id = $row["userid"];
		$username = $row["username"];
		$firstname = $row["firstname"];
		$lastname = $row["lastname"];
		$mailaddr = $row["mailaddr"];
		$phone = $row["phone"];
		$date_regis = $row["date_regis"];
	?>
	<tr> 
		<td align = "center"> <input type = "checkbox" id = "select_user[]" name = "select_user[]" value = "<?=$id?>"> </td>
		<td>
			<?=$username?>
		</td>
		<td>
			<?=$firstname." ".$lastname?>
		</td> 
		<td align = "center">
			<?=$mailaddr?>
		</td> 
		<td align = "center">
			<?=$phone?>
		</td>
		<td align = "center">
			<?=$date_regis?>
		</td>
		<!-- <td align = "center"><input type="image" src="images/icn_edit.png" title="Edit" onclick = "editItem('<?=$id?>'  )"><input type="image" src="images/icn_trash.png" title="Trash" onclick = "deleteItem('<?=$id?>' , '<?=$group_name?>' )"></td> --> 
	</tr> 
	<?php
	}

	include "paging.php";
	?>
	
	<tr> 
		<td colspan = "25"></td> 
	</tr>  
	<tr> 
		<td colspan = "25" align = "left"><input type = "button" name = "killSession" value = " ยกเลิกการใช้งานของผู้ใช้ " onclick = "killUserSession()"></td> 
	</tr>  
</tbody> 
</table>
<input type = "hidden" name="deleteId" id = "deleteId" >
<input type = "hidden" name="editId" id = "editId" >