<?php
	include "utils/autogenerate.php";
	$method = $_POST["method"];
	
	$userforprint = array();
	$user_count = 0;

	if ($method == "save")
	{

		$image =  $_FILES["image"]["name"];

		$firstname =  $_POST["firstname"];
		$lastname =  $_POST["lastname"];
		$email =  $_POST["email"];
		$telno =  $_POST["telno"];
		$user_type =  $_POST["user_type"];
		$hotspot_id =  $_POST["hotspot_id"];
		$username =  $_POST["username"];
		$password =  $_POST["password"];
		$user_group =  $_POST["user_group"];

		$gen_type = $_POST["gen_type"];
		$user_count = $_POST["user_count"];
		$expire_date = 1;

		if ( $gen_type != "group")
			$user_count = 1;
		
		for ($ii=0;$ii<$user_count;$ii++)
		{

			if ( $gen_type == "group")
			{	
				$username = generate_username();
				$password = generate_password();
				$firstname =  "DUMMY";
				$lastname =  "DUMMY";
				$expire_date = 2;
			}
			
			$pass_md5 = md5( $password );
			$authen_url = md5( $username.$password );

			$userinfo = array();
			$userinfo["username"] = $username;
			$userinfo["password"] = $password;
			$userinfo["expiredate"] = date("d/m/Y H:i:s", mktime( date("H") , date("i"),  date("s") , date("m")  , date("d")+$expire_date, date("Y")));
			$userforprint[$ii] = $userinfo;

			$sql = "insert into tb_b_account ( username , password , firstname , lastname  ,  dateregis , user_group , status , expire_date , authen_url , boardingpass_code ) values ( '$username' , '$pass_md5' , '$firstname' , '$lastname' , now() , '3' ,'A' , ADDDATE( now()  , ".$expire_date." ) , '$authen_url' , 'DUMMY".$pass_md5."' ) ";
			$result = $db->send_cmd($sql);
			$tb_b_accountResult = $db->affected_rows();
			if ($tb_b_accountResult>0)
			{
				$sql = "delete from radusergroup where username = '$username' ";
				$db->send_cmd($sql);
				$sql = "insert into radusergroup( username , groupname ) ";
				$sql .= " values(  '$username'  ,  'register' )";
				
				$db->send_cmd($sql);
				$groupResult = $db->affected_rows();
				if ($groupResult>0)
				{
					$sql = "delete from radcheck where username =  '$username'  ";
					$db->send_cmd($sql);
					$sql = "insert into radcheck( username , attribute , op , value ) ";
					$sql .= " values(  '$username'  , 'Cleartext-Password' , ':=' ,  '$password'  )";
					$db->send_cmd($sql);
					$result = $db->affected_rows();
					$processResult = $result > 0 ? 1 : 8;
				}
			}
		}

	}
	else if ($method == "delete")
	{
		$id =  $_POST["deleteId"];

		$sql = "delete from radacc where username = (select username from tb_b_account where id = '$id' )";
		$db->send_cmd($sql);
		//echo $sql;
		$sql = "delete from tb_b_account where id = '$id' ";
		$result = $db->send_cmd($sql);
		$result = $db->affected_rows();
		$processResult = $result > 0 ? 1 : 8;
	}
	else if ($method == "edit")
	{
		$editId =  $_POST["editId"];
		$firstname =  $_POST["firstname"];
		$lastname =  $_POST["lastname"];
		$email =  $_POST["email"];
		$telno =  $_POST["telno"];
		$hotspot_id =  $_POST["hotspot_id"];
		$username =  $_POST["username"];
		$password =  $_POST["password"];
		$user_group =  $_POST["user_group"];
		
		
		$pass_md5 = md5( $password );
		$authen_url = md5( $username.$password );

		$image =  $_FILES["image"]["name"];
		if (!empty($image))
		{
			$extension = end(explode(".", $_FILES["image"]["name"]));
			$attachFileName = rand(1000000,9999999).".".$extension;

		}

		$userinfo = array();
		$userinfo["username"] = $username;
		$userinfo["password"] = $password;
		$userforprint[$ii] = $userinfo;
		$user_count = 1;
	
		$sql = "update tb_b_account set md=now() , mb='$login_username' ";
		if (!empty($firstname))
			$sql .=" , firstname = '$firstname' ";		
		if (!empty($lastname))
			$sql .=" , lastname = '$lastname' ";
		if (!empty($authen_url))
			$sql .=" , authen_url = '$authen_url' ";
		if (!empty($username))
			$sql .=" , username = '$username' ";
		if (!empty($password))
			$sql .=" , password  = '".$pass_md5."' ";
		if (!empty($flight_no))
			$sql .=" , flight_no  = 'flight_no' ";
		if (!empty($user_group))
			$sql .=" , expire_date  = ADDDATE( now()  ,1 ) ";

		$sql .= " where id = '$editId' ";
		//echo $sql;
		$result = $db->send_cmd($sql);

		$result = $db->affected_rows();
		$processResult = $result > 0 ? 1 : 8;

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
			<div align = "left"><a href = "javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'user_management' , 'new' , 'จัดการข้อมูลผู้ใช้' )) "><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></div>
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
		<td align = "center">Actions</td> 
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
		<td align = "center"><!-- <input type="image" src="images/icn_edit.png" title="Edit" onclick = "editItem('<?=$id?>'  )"> --><input type="image" src="images/icn_trash.png" title="Trash" onclick = "deleteItem('<?=$id?>' , '<?=$firstname." ".$lastname?>' )"></td> 
	</tr> 
	<?php
	}

	include "paging.php";
	?>
	
	<tr> 
		<td colspan = "20"></td> 
	</tr>  
</tbody> 
</table>

<input type = "hidden" name="deleteId" id = "deleteId" >
<input type = "hidden" name="editId" id = "editId" >
