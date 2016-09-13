<?php
	$method = $_POST["method"];

	if ($method == "save")
	{
		$group_name =  $_POST["group_name"];
		$price =  $_POST["price"];
		$package_detail =  $_POST["package_detail"];
		$image =  $_FILES["image"]["name"];

		$extension = end(explode(".", $_FILES["image"]["name"]));
		$attachFileName = rand(1000000,9999999).".".$extension;

		if ($_FILES["image"]["error"] > 0)
		{
			
		}
		else
		{
			if (!empty($image))
			{
				
				$attachFile = move_uploaded_file($_FILES["image"]["tmp_name"],
				  "attachfiles/" .$attachFileName );
			}
		}

		$sql = "insert into account ( group_name , price , package_detail , cd , cb  ) values ( '$group_name' , '$price' , '$package_detail'  , now() , '$username'   ) ";
		$result = $db->send_cmd($sql);

	}
	else if ($method == "delete")
	{
		$id =  $_POST["deleteId"];
		
		$sql = "update account set package_status = 'N' where id = '$id' ";
		$result = $db->send_cmd($sql);

	}
	else if ($method == "edit")
	{
		$editId =  $_POST["editId"];
		$group_name =  $_POST["group_name"];
		$price =  $_POST["price"];
		$package_detail =  $_POST["package_detail"];

		$image =  $_FILES["image"]["name"];
		if (!empty($image))
		{
			$extension = end(explode(".", $_FILES["image"]["name"]));
			$attachFileName = rand(1000000,9999999).".".$extension;

			if ($_FILES["image"]["error"] > 0)
			{
				
			}
			else
			{
					$attachFile = move_uploaded_file($_FILES["image"]["tmp_name"],
					  "attachfiles/" .$attachFileName );
			}
		}

		$sql = "update account set md=now() , mb='admin' ";
		if (!empty($group_name))
			$sql .= ", group_name =  '$group_name' ";
		if (!empty($price))
			$sql .= ", price =  '$price' ";
		if (!empty($package_detail))
			$sql .= ", package_detail =  '$package_detail' ";

		$sql .= " where id = '$editId' ";
		//echo $sql;
		$result = $db->send_cmd($sql);

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
//-->
</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	<tr> 
		<td colspan = "5" valign = "middle"><a href = "adminhome.php?menu=user_management&status=new&desc=จัดการข้อมูลผู้ใช้"><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></td> 
	</tr> 
</thead> 
<thead> 
	<tr> 
		<td align = "center">Username</td>
		<td align = "center">ชื่อ</td> 
		<td align = "center">Email</td> 
		<td align = "center">เบอร์โทร</td> 
		<td align = "center">วันที่ลงทะเบียน</td>
		<td align = "center">Actions</td> 
	</tr> 
</thead> 
<tbody> 
	<?php

	$sql = "SELECT ceil( count(*)/$recPerPage ) FROM account where status = '1' ";
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

	$sql = " select username,firstname,lastname,mailaddr,phone,date_format(dateregis,'%d/%m%Y') date_regis FROM account where status = '1'   ";
	if (!empty($quicksearch))
	{
		$sql .= " and ( username like '%$quicksearch%' or firstname like '%$quicksearch%'  or lastname like '%$quicksearch%' or mailaddr like '%$quicksearch%' or phone like '%$quicksearch%' or dateregis like '%$quicksearch%'   ) ";
	}
	$sql .= " order by id desc ";
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
		<td align = "center"><input type="image" src="images/icn_edit.png" title="Edit" onclick = "editItem('<?=$id?>'  )"><input type="image" src="images/icn_trash.png" title="Trash" onclick = "deleteItem('<?=$id?>' , '<?=$group_name?>' )"></td> 
	</tr> 
	<?php
	}

	include "paging.php";
	?>
	
	<tr> 
		<td colspan = "5"></td> 
	</tr>  
</tbody> 
</table>
<input type = "hidden" name="deleteId" id = "deleteId" >
<input type = "hidden" name="editId" id = "editId" >