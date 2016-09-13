<?php
$method=$_POST["method"];
$editId=$_POST["editId"];

if ($method=="edit")
{
	$password_new = $_POST["password_new"];
	$sql = "update tb_b_user set password = md5( concat( username, '$password_new' ) ) , pass_text = '$password_new' where username = '$login_username' ";
	$db->send_cmd($sql);
	$result = $db->affected_rows();
	$processResult = $result > 0 ? 1 : 8;
	//echo $sql;
}

$sql = "select a.*,b.hotspot_id from tb_b_user a left join tb_b_user_hotspot b on a.id = b.userid where a.id = '$editId' ";
//echo $sql;
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
	$username = $row["username"];
	$password = $row["pass_text"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$user_type = $row["user_type"];
	$email = $row["email"];
	$telno = $row["telno"];
	$hotspot_id = $row["hotspot_id"];
}
?>
<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script type="text/javascript">

 function save()
 {
	 
	var obj = document.getElementById("password_old");
	if (obj.value == "")
	{
		alert("กรุณากำหนดรหัสผ่านเดิม");
		obj.focus();
		return;
	}
	else
	{
		/*if ( !validateLength( obj , ">=" , 8) )
		{
			alert("กรุณากรอกรหัสผ่านอย่างน้อย 8 อักษร");
		}*/
	}

	obj = document.getElementById("password_new");
	if (obj.value == "")
	{
		alert("กรุณากำหนดรหัสผ่านใหม่");
		obj.focus();
		return;
	}
	else
	{
		/*if ( !validateLength( obj , ">=" , 8) )
		{
			alert("กรุณากรอกรหัสผ่านใหม่อย่างน้อย 8 อักษร");
		}*/
	}

	obj = document.getElementById("password_confirm");
	if (obj.value == "")
	{
		alert("กรุณากำหนดยืนยันรหัสผ่านใหม่");
		obj.focus();
		return;
	}

	var pass = document.getElementById("password_new");
	if ( obj.value != pass.value )
	{
		alert("ยืนยันรหัสผ่านไม่ตรงกัน กรุณากรอกให้ตรงกัน");
		obj.focus();
		return;
	}

	if (confirm("ต้องการบันทึกข้อมูล ? "))
	{
		document.forms[0].method.value = "<?=empty($method) ? "edit" : $method ?>";
		document.forms[0].status.value = "new";
		document.forms[0].submit();
	}

 }



</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<tbody> 
	<?php
	include "processresult_bar.php";
	//$result = $db->affected_rows();
	//$processResult = $result > 0 ? 1 : 8;
	?>
	<tr>
		<td>
			<table width ="100%">

				<tr>
					<td align = "right"><h3>รหัสผ่านเดิม : <h3></td>
					<td><input type = "password" size = "30" name = "password_old" id = "password_old" ></td>
				</tr>
				
				<tr>
					<td align = "right"><h3>รหัสผ่านใหม่ : <h3></td>
					<td><input type = "password" size = "30" name = "password_new" id = "password_new" ></td>
				</tr>
				
				<tr>
					<td align = "right"><h3>ยืนยันรหัสผ่านใหม่ : <h3></td>
					<td><input type = "password" size = "30" name = "password_confirm" id = "password_confirm" ></td>
				</tr>
				
				
				<tr>
					<td align = "center" colspan ="2">
						<input type = "button" name = "savearticle" onclick = "save()" id = "savearticle" value = " บันทึก ">&nbsp;&nbsp;<input type = "button" name = "cancel" id = "cancel" value = " ยกเลิก ">
						<input type = "hidden" name="editId" id = "editId" value="<?=$_POST["editId"]?>">
					</td>
				</tr>
			</table>
		</td>
	</tr> 
</tbody> 
</table>