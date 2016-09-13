<?php
	$method = $_POST["method"];

	if ($method == "save")
	{
		$firstname =  $_POST["firstname"];
		$lastname =  $_POST["lastname"];
		$email =  $_POST["email"];
		$telno =  $_POST["telno"];
		$user_type =  $_POST["user_type"];
		$hotspot_id =  $_POST["hotspot_id"];
		$username =  $_POST["username"];
		$password =  $_POST["password"];
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

		$sql = "insert into tb_b_user ( username , password , firstname , lastname , email , telno , user_type ,  cd , cb , pass_text  ) values ( '$username' ,md5( '".$username.$password."' ), '$firstname' , '$lastname' , '$email' , '$telno' , '$user_type'  , now() , '$login_username' , '$password' ) ";
		$db->send_cmd($sql);
		$result = $db->affected_rows();
		$processResult = $result > 0 ? 1 : 8;
		
		if ($result > 0 )
		{
			$sql = "insert into tb_b_user_hotspot ( userid , hotspot_id  ) values ( (select max(id) from tb_b_user where username = '$username' and firstname = '$firstname' and lastname = '$lastname' and email = '$email' and telno = '$telno' and user_type = '$user_type' ) , '$hotspot_id' ) ";
			$db->send_cmd($sql);
			//echo $sql;
		}
		
		$subject = "Your username and password for WiFi City";
		$msg = "Dear ".$firstname." ".$lastname."\n";
		$msg .= "\tYour information following\n";
		$msg .= "\t\tUsername : $username\n";
		$msg .= "\t\tPassword : $password\n";
		$headers = 'From: pomprawit@hotmail.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		mail( $email , $subject , $msg , $header );
	}
	else if ($method == "delete")
	{
		$id =  $_POST["deleteId"];
		
		$sql = "update tb_b_user set status = 'N' where id = '$id' ";
		$db->send_cmd($sql);
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
		$user_type =  $_POST["user_type"];
		$hotspot_id =  $_POST["hotspot_id"];
		$username =  $_POST["username"];
		$password =  $_POST["password"];
		
		//Web background image		
		$sql = "update tb_b_user set md=now() , mb='admin' ";
		if (!empty($firstname))
			$sql .=" , firstname = '$firstname' ";		
		if (!empty($lastname))
			$sql .=" , lastname = '$lastname' ";
		if (!empty($email))
			$sql .=" , email = '$email' ";
		if (!empty($telno))
			$sql .=" , telno = '$telno' ";
		if (!empty($user_type))
			$sql .=" , user_type = '$user_type' ";
		if (!empty($username))
			$sql .=" , username = '$username' ";
		if (!empty($password))
		{
			$sql .=" , pass_text = '".$password."' ";
			$sql .=" , password =md5( '".$username.$password."' ) ";
		}

		$sql .= " where id = '$editId' ";
		//echo $sql;
		$db->send_cmd($sql);
		$result = $db->affected_rows();
		$processResult = $result > 0 ? 1 : 8;
		
		if ($result > 0 )
		{
			$sql = "delete from tb_b_user_hotspot where userid =  '$editId' ";
			$db->send_cmd($sql);

			$sql = "insert into tb_b_user_hotspot ( userid , hotspot_id  ) values ( '$editId'  , '$hotspot_id' ) ";
			$db->send_cmd($sql);
		}

		$subject = "Your username and password for WiFi City";
		$msg = "Dear ".$firstname." ".$lastname."\n";
		$msg .= "\tYour information following\n";
		$msg .= "\t\tUsername : $username\n";
		$msg .= "\t\tPassword : $password\n";
		$headers = 'From: pomprawit@hotmail.com' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		mail( $email , $subject , $msg , $header );
		
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
			document.forms[0].submit();
		}
	}

	function editItem( item )
	{
		document.getElementById("editId").value = item;
		document.getElementById("method").value = "edit";
		document.getElementById("status").value = "new";
		document.forms[0].submit();
	}
//-->
</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	<tr> 
		<td colspan = "50" valign = "middle"><a href = "javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'siteuser' , 'new' , 'User Site' )) "><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></td> 
	</tr> 
	<?php
	include "processresult_bar.php";
	?>
</thead> 
<thead> 
	<tr> 
		<td align = "center">Username</td>
		<td align = "center">ชื่อ</td> 
		<td align = "center">Email</td> 
		<td align = "center">เบอร์โทร</td> 
		<td align = "center">ประเภท</td>
		<td align = "center">Actions</td> 
	</tr> 
</thead> 
<tbody> 
	<?php

	$sql = "SELECT ceil( count(*)/$recPerPage ) FROM tb_b_user where status = 'Y' ";
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

	$sql = " select id,username,firstname,lastname,email,telno,date_format(cd,'%d/%m%Y') date_regis,user_type FROM tb_b_user where status = 'Y'   ";
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
		$email = $row["email"];
		$phone = $row["telno"];
		$date_regis = $row["date_regis"];
		$user_type = $row["user_type"];
	?>
	<tr> 
		
		<td>
			<?=$username?>
		</td>
		<td>
			<?=$firstname." ".$lastname?>
		</td> 
		<td align = "center">
			<?=$email?>
		</td> 
		<td align = "center">
			<?=$phone?>
		</td>
		<td align = "center">
			<?=$user_type?>
		</td>
		<td align = "center">
			<?php
			if ($login_user_type == "ADMIN_SUPER")
			{
				if ($user_type != "ADMIN_SUPER")
				{
			?>
			<input type="image" src="images/icn_edit.png" title="Edit" onclick = "editItem('<?=$id?>'  )"><input type="image" src="images/icn_trash.png" title="Trash" onclick = "deleteItem('<?=$id?>' , '<?=$group_name?>' )">
			<?php
				}
			}
			?>
		</td> 
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