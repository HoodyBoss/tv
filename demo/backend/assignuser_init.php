<?php
	$method = $_POST["method"];

	
	if ($method == "assignuser")
	{
		$select_user =  $_POST["select_user"];
		$user_group =  $_POST["user_group"];
		
		for ($ii=0;$ii<count($select_user);$ii++)
		{
			//echo "ID >> ".$select_user[$ii]."<br>";
			if (!empty($select_user[$ii]) && $select_user[$ii]!="ALL")
			{
				$sql = "update account set  ";
				$sql .= " user_group =  '".$user_group."' ";
				$sql .= " where id = '".$select_user[$ii]."' ";
				//echo $sql."<br>";
				$db->send_cmd($sql);
				$accountResult = $db->affected_rows();
				if ($accountResult>0)
				{
					$sql = "delete from radusergroup where username =  (select username from account where id = '".$select_user[$ii]."') ";
					$db->send_cmd($sql);
					$sql = "insert into radusergroup( username , groupname ) ";
					$sql .= " values( (select username from account where id = '".$select_user[$ii]."') , (select group_name from tb_b_user_group where id = '".$user_group."'))";
					//echo $sql."<br>";
					
					$db->send_cmd($sql);
					$groupResult = $db->affected_rows();
					if ($groupResult>0)
					{
						$sql = "delete from radcheck where username =  (select username from account where id = '".$select_user[$ii]."') ";
						$db->send_cmd($sql);
						$sql = "insert into radcheck( username , attribute , op , value ) ";
						$sql .= " values(  (select username from account where id = '".$select_user[$ii]."') , 'Cleartext-Password' , ':=' ,  (select password from account where id = '".$select_user[$ii]."') )";
						$db->send_cmd($sql);
						//echo $sql."<br>";
						$result = $db->affected_rows();
					}
				}
			}
		}

	}

?>

<script type="text/javascript">

	function submitAssignUser()
	{
		var isSelect = false;
		var obj_arr = document.forms[0].elements["select_user[]"];
		//alert( obj_arr );
		for (var ii=0;ii<obj_arr.length ;ii++ )
		{
			//alert(obj_arr[ii].checked);
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
		
		obj = document.getElementById("user_group");
		if (obj.value == "")
		{
			alert("กรุณาเลือกกลุ่ม / Package");
			obj.focus();
			return;
		}

		if (confirm("กำหนดกลุ่ม / Package "+obj.options[obj.selectedIndex].text))
		{
			localSubmitForm(new Array( 'method', 'status' ),new Array(  'assignuser' , 'init' ));
		}
	}

</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	<!-- <tr> 
		<td colspan = "20" valign = "middle"><a href = "adminhome.php?menu=ass&status=new&desc=จัดการข้อมูลผู้ใช้"><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></td> 
	</tr>  -->
	<tr>
		<td colspan = "20">
		ค้นหา : &nbsp;&nbsp;<input type = "text" name = "quicksearch" onkeypress = "enterKey()" id = "quicksearch" value = "<?=$_POST["quicksearch"]?>" onfocus="this.value=''">&nbsp;&nbsp;<img src="images/icn_search.png" onclick = "localSubmitForm(new Array(),new Array())">
		</td>
	</tr>
</thead> 
<thead> 
	<tr> 
		<td align = "center" width = "5%"><input type = "checkbox" id = "select_user[]" name = "select_user[]" value = "ALL" onclick = "checkAll(this)"></td>
		<td align = "center">Username</td>
		<td align = "center">ชื่อ</td> 
		<td align = "center">Email</td> 
		<td align = "center">เบอร์โทร</td> 
		<td align = "center">วันที่ลงทะเบียน</td>
		<!-- <td align = "center">Actions</td>  -->
	</tr> 
</thead> 
<tbody> 
	<?php

	$quicksearch = $_POST["quicksearch"];

	$sql = "SELECT ceil( count(*)/$recPerPage ) FROM account where status = '1' and ( user_group is null or user_group = '' ) ";

	if (!empty($quicksearch))
	{
		$sql .= " and ( username like '%$quicksearch%' or firstname like '%$quicksearch%'  or lastname like '%$quicksearch%' or mailaddr like '%$quicksearch%' or phone like '%$quicksearch%' or dateregis like '%$quicksearch%'   ) ";
	}
	
	//echo $sql;
	$db->send_cmd($sql);
	$noOfPage = 1;
	while ($row=$db->get_data())
	{
		$noOfPage = $row[0];
	}

	$sql = " select id,username,firstname,lastname,mailaddr,phone,date_format(dateregis,'%d/%m%Y') date_regis FROM account where status = '1' and ( user_group is null or user_group = '' )  ";
	
	if (!empty($quicksearch))
	{
		$sql .= " and ( username like '%$quicksearch%' or firstname like '%$quicksearch%'  or lastname like '%$quicksearch%' or mailaddr like '%$quicksearch%' or phone like '%$quicksearch%' or dateregis like '%$quicksearch%'   ) ";
	}

	$sql .= "  order by id desc ";
	//Paging
	$beginRec = ($pageNumber*$recPerPage)-$recPerPage;
	$sql .= " limit $beginRec,$recPerPage";
	//End paging
	//echo $sql;
	$db->send_cmd($sql);
	while ($row=$db->get_result())
	{
		$id = $row["id"];
		$username = $row["username"];
		$firstname = $row["firstname"];
		$lastname = $row["lastname"];
		$mailaddr = $row["mailaddr"];
		$phone = $row["phone"];
		$date_regis = $row["date_regis"];
	?>
	<tr> 
		<td align = "center"><input type = "checkbox" id = "select_user[]" name = "select_user[]" value = "<?=$id?>"></td>
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
		<!-- <td align = "center"><input type="image" src="images/icn_edit.png" title="Edit" onclick = "editItem('<?=$id?>'  )"><input type="image" src="images/icn_trash.png" title="Trash" onclick = "deleteItem('<?=$id?>' , '<?=$group_name?>' )"></td>  -->
	</tr> 
	<?php
	}

	include "paging.php";
	?>
	
	<tr> 
		<td colspan = "20"></td> 
	</tr>  
	<tr> 
		<td colspan = "20">
			<table width = "100%">
				<tr>
					<td>
						กลุ่ม / Package : &nbsp;
						<select name = "user_group" id = "user_group">
							<option value = "">เลือกกลุ่ม / Package</option>
							<?php
								$sql = "select * from tb_b_user_group where group_status = 'Y' ";
								$db->send_cmd($sql);
								while ($row=$db->get_result())
								{
							?>
							<option value = "<?=$row["id"]?>"><?=$row["group_name"]?></option>
							<?php
								}
							?>
						</select>
					</td>
				</tr>
			</table>
		</td> 
	</tr> 
	<tr> 
		<td colspan = "20" align = "center"><input type = "button" name = "assignUser" id = "assignUser" value = "กำหนด Package" onclick = "submitAssignUser()"></td> 
	</tr> 
	<tr> 
		<td colspan = "20"></td> 
	</tr> 
</tbody> 
</table>
<input type = "hidden" name="deleteId" id = "deleteId" >
<input type = "hidden" name="editId" id = "editId" >
