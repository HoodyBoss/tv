<?php

$method=$_POST["method"];
$editId=$_POST["editId"];

$gen_type = $_POST["gen_type"];

$sql = "select * from tb_b_account where id = '$editId' ";
//echo $sql;
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
	$user_name = $row["username"];
	$pass_word = "";//$row["password"];
	$firstname = $row["firstname"];
	$lastname = $row["lastname"];
	$flight_no = $row["flight_no"];
	$hotspot_id = $row["hotspot_id"];
	$user_group = $row["user_group"];
}
?>

<script type="text/javascript">

 function save()
 {
	<?php
		if ($gen_type == "onebyone")
		{
	?>
	var obj = document.getElementById("username");
	if (obj.value == "")
	{
		alert("กรุณากำหนด Username");
		obj.focus();
		return;
	}
	else
	{
		if ( !validateLength( obj , ">=" , <?=$env_var["username_length"]?>) )
		{
			alert("กรุณากำหนด Username อย่างน้อย <?=$env_var["username_length"]?> อักษร");
			obj.focus();
			return;
		}
	}
	
	<?php
		
		if (empty($method) || $method == "save")
		{
			$validateUser = "loadXMLDoc()";	
	?>
	var validateUserMsg = document.getElementById("validateUserMsg").innerHTML;
	if (validateUserMsg!="")
	{
		alert("กรุณากำหนด Username ใหม่อีกครั้ง ");
		obj.focus();
		return;
	}
	<?php
		}
	?>

	obj = document.getElementById("password");
	if (obj.value == "")
	{
		alert("กรุณากำหนดรหัสผ่าน");
		obj.focus();
		return;
	}
	else
	{
		if ( !validateLength( obj , ">=" , <?=$env_var["password_length"]?>) )
		{
			alert("กรุณากรอกรหัสผ่านอย่างน้อย <?=$env_var["password_length"]?> อักษร");
			obj.focus();
			return;
		}
	}
	<?php
		}
	?>
	if (confirm("ต้องการบันทึกข้อมูล ? "))
	{
		document.forms[0].method.value = "<?=empty($method) ? "save" : $method ?>";
		document.forms[0].status.value = "init";
		document.forms[0].submit();
	}

 }

 function generateData(dest , len)
{
	var obj = document.getElementById(dest);
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < len; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    obj.value = text;

	<?=$validateUser?>;
}

function loadXMLDoc()
{
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange=function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			document.getElementById("validateUserMsg").innerHTML=xmlhttp.responseText;
		}
	}
	var str = document.getElementById("username");
	xmlhttp.open("GET","getaccountexist.php?username="+str.value,true);
	xmlhttp.send();
}


</script>

<table class="tablesorter" cellspacing="0" width = "100%"> 
<tbody> 
	<tr>
		<td>
			<table width ="100%">
				<tr>
					<td colspan = "2"><h3><font color="red">*</font>&nbsp;&nbsp;ต้องกรอกข้อมูลในช่อง<h3></td>
				</tr>
				<tr>
					<td align = "right"><h3>เลือก : <h3></td>
					<td>
						<select id = "gen_type" name = "gen_type" onchange = "localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'user_management' , 'new' , 'จัดการข้อมูลผู้ใช้' ))">
							<option value = "onebyone" <?=empty($gen_type) || $gen_type=="onebyone" ? "selected" : ""?>>แบบทีละคน</option>
							<option value = "group"" <?=$gen_type=="group" ? "selected" : ""?>>แบบกลุ่ม</option>
						</select>
					</td>
				</tr>
				<?php
				
				if (empty($gen_type) || $gen_type ==  "onebyone")
				{
				?>
				<tr>
					<td align = "right"><h3>Username : <h3></td>
					<td><input type = "text" size = "30" name = "username" id = "username" value = "<?=$user_name?>" onblur = "<?=$validateUser?>" maxlength = "20" <?=$method=="edit"?"readonly style = \"background-color:gray\" ":"style = \"background-color:yellow\" "?>>&nbsp;&nbsp;<font color="red">*</font>&nbsp;&nbsp;<a href = "javascript: generateData('username' , <?=$env_var["username_length"]?>);"> Generate Username</a>
					&nbsp;&nbsp;<div id="validateUserMsg"><h2></h2></div></td>
				</tr>
				
				<tr>
					<td align = "right"><h3>Password : <h3></td>
					<td><input type = "text" size = "30" name = "password" id = "password" value = "<?=$pass_word?>" maxlength = "20" style = "background-color:yellow">&nbsp;&nbsp;<font color="red">*</font>&nbsp;&nbsp;<a href = "javascript: generateData('password' , <?=$env_var["password_length"]?>)"> Generate Password</a></td>
				</tr>
				
				<tr>
					<td align = "right"><h3>ชื่อ-นามสกุล : <h3></td>
					<td><input type = "text" size = "50" name = "firstname" id = "firstname" value = "<?=$firstname?>"> - <input type = "text" size = "50" name = "lastname" id = "lastname" value = "<?=$lastname?>"></td>
				</tr>

				<tr>
					<td align = "right"><h3>เที่ยวบิน : <h3></td>
					<td><input type = "text" size = "30" name = "flight_no" id = "flight_no" value = "<?=$flight_no?>"></td>
				</tr>
				<?php
				}
				else
				{
				?>
				<tr>
					<td align = "right"><h3>จำนวนผู้ใช้ : <h3></td>
					<td>
						<input type = "text" size = "30" name = "user_count" id = "user_count" value = "" maxlength = "20" style = "background-color:yellow">
					</td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td align = "center" colspan ="2">
						<input type = "button" name = "savearticle" onclick = "save()" id = "savearticle" value = " บันทึก ">&nbsp;&nbsp;<input type = "button" name = "cancel" id = "cancel" value = " ยกเลิก " onclick = "localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'user_management' , 'init' , 'จัดการข้อมูลผู้ใช้' ))">
						<input type = "hidden" name="editId" id = "editId" value="<?=$_POST["editId"]?>">
						<input type = "hidden" name="validateUserFlag" id = "validateUserFlag" value="NO">
					</td>
				</tr>
			</table>
		</td>
	</tr> 
</tbody> 
</table>
