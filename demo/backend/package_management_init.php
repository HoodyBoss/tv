<?php
	$method = $_POST["method"];

	if ($method == "save")
	{
		$group_name =  $_POST["group_name"];
		$price =  $_POST["price"];
		$package_detail =  $_POST["package_detail"];
		$account_active_day =  $_POST["account_active_day"];
		$image =  $_FILES["image"]["name"];
		
		$default_package =  $_POST["default_package"];
		$default_package = !empty($default_package) ? "Y" : "N";

		$extension = end(explode(".", $_FILES["image"]["name"]));
		$attachFileName = rand(1000000,9999999).".".$extension;


		$sql = "insert into tb_b_user_group ( group_name , price , package_detail , cd , cb , hotspot_id , default_package , account_active_day ) values ( '$group_name' , '$price' , '$package_detail'  , now() , '$username' , '$hotspot' ,'$default_package' , '$account_active_day' ) ";
		$db->send_cmd($sql);
		$result = $db->affected_rows();
		
		if ($result>0)
		{
			$att_hdr = $_POST["att_hdr"];
			for ($ii=0;$ii<count($att_hdr);$ii++)
			{
				$att_det = $_POST["att_det".$att_hdr[$ii]];
				$sql = "insert into radgroupreply ( groupname , attribute , op , value  ) values ( '$group_name' , (select attr_name from tb_b_attribute_hdr where id = '".$att_hdr[$ii]."' ) , ':='  , '$att_det' ) ";
				$db->send_cmd($sql);
				$result = $db->affected_rows();
				$processResult = $result > 0 ? 1 : 8;
				//$sql = "insert into radgroupcheck ( groupname , attribute , op , value  ) values ( '$group_name' , (select attr_name from tb_b_attribute_hdr where id = '".$att_hdr[$ii]."' ) , ':='  , '$att_det' ) ";
				//$db->send_cmd($sql);
			}
		}

	}
	else if ($method == "delete")
	{
		$id =  $_POST["deleteId"];
		
		$sql = "update tb_b_user_group set group_status = 'N' where id = '$id' ";
		$db->send_cmd($sql);
		$result = $db->affected_rows();
		if ($result>0)
		{
			$sql = "delete from radgroupreply where groupname= (select group_name from tb_b_user_group where id = '$id' ) ";
			$db->send_cmd($sql);
			$result = $db->affected_rows();
			$processResult = $result > 0 ? 1 : 8;
		}

	}
	else if ($method == "edit")
	{
		$editId =  $_POST["editId"];
		$group_name =  $_POST["group_name"];
		$price =  $_POST["price"];
		$package_detail =  $_POST["package_detail"];
		$default_package =  $_POST["default_package"];
		$account_active_day =  $_POST["account_active_day"];
		$default_package = !empty($default_package) ? "Y" : "N";		

		$sql = "update tb_b_user_group set md=now() , mb='admin' ";
		if (!empty($group_name))
			$sql .= ", group_name =  '$group_name' ";
		if (!empty($price))
			$sql .= ", price =  '$price' ";
		if (!empty($package_detail))
			$sql .= ", package_detail =  '$package_detail' ";
		if (!empty($default_package))
			$sql .= ", default_package =  '$default_package' ";
		if (!empty($account_active_day))
			$sql .= ", account_active_day =  '$account_active_day' ";

		$sql .= " where id = '$editId' ";
		//echo $sql."<br>";
		$db->send_cmd($sql);
		$result = $db->affected_rows();
		if ($result>0)
		{
			$sql = "delete from radgroupreply where groupname= (select group_name from tb_b_user_group where id = '$editId' ) ";
			//echo $sql."<br>";
			$db->send_cmd($sql);
			$result = $db->affected_rows();
			if ($result>0)
			{
				$att_hdr = $_POST["att_hdr"];
				for ($ii=0;$ii<count($att_hdr);$ii++)
				{
					$att_det = $_POST["att_det".$att_hdr[$ii]];
					$sql = "insert into radgroupreply ( groupname , attribute , op , value  ) values ( '$group_name' , (select attr_name from tb_b_attribute_hdr where id = '".$att_hdr[$ii]."' ) , ':='  , '$att_det' ) ";
					//echo $sql."<br>";
					$db->send_cmd($sql);
					$result = $db->affected_rows();
					$processResult = $result > 0 ? 1 : 8;
				}
			}
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
//-->
</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	<tr> 
		<td colspan = "20" valign = "middle"><a href = "javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'package_management' , 'new' , 'จัดการ Package' ))"><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></td> 
	</tr> 
	<?php
	include "processresult_bar.php";
	//$result = $db->affected_rows();
	//$processResult = $result > 0 ? 1 : 8;
	?>
</thead> 
<thead> 
	<tr> 
		<td align = "center">Package</td> 
		<td align = "center">ราคา</td> 
		<td align = "center">User Active Day</td> 
		<td align = "center">Actions</td> 
	</tr> 
</thead> 
<tbody> 
	<?php
	$sql = "SELECT ceil( count(*)/$recPerPage ) FROM tb_b_user_group where group_status = 'Y'  $hotspot_clause  ";
	
	//echo $sql;
	$db->send_cmd($sql);
	$noOfPage = 1;
	while ($row=$db->get_data())
	{
		$noOfPage = $row[0];
	}

	$sql = " select * FROM tb_b_user_group where group_status = 'Y' $hotspot_clause order by id desc";
	//echo $sql;
	$db->send_cmd($sql);
	while ($row=$db->get_result())
	{
		$id = $row["id"];
		$group_name = $row["group_name"];
		$price = $row["price"];
		$group_status = $row["group_status"];
		$account_active_day = $row["account_active_day"];
	?>
	<tr> 

		<td>
			<?=$group_name?>
		</td> 
		<td align = "center">
			<?=$price?>
		</td> 
		<td align = "center">
			<?=$account_active_day?>
		</td> 
		<td align = "center"><input type="image" src="images/icn_edit.png" title="Edit" onclick = "editItem('<?=$id?>'  )"><input type="image" src="images/icn_trash.png" title="Trash" onclick = "deleteItem('<?=$id?>' , '<?=$group_name?>' )"></td> 
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