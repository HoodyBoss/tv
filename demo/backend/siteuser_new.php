<?php
$method=$_POST["method"];
$editId=$_POST["editId"];

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

<script type="text/javascript">

 function save()
 {
	//alert( "1" );
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
	//alert( "2" );
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
	//alert( "3" );
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
	//alert( "4" );
	obj = document.getElementById("firstname");
	if (obj.value == "")
	{
		alert("กรุณากรอกชื่อ");
		obj.focus();
		return;
	}
	//alert( " 5" );
	obj = document.getElementById("email");
	if (obj.value == "")
	{
		alert("กรุณากรอก Email");
		obj.focus();
		return;
	}
	else
	{
		if ( !validateEmail(obj) )
		{
			alert("กรุณากรอก Email ให้ถูกต้อง");
			obj.focus();
			return;
		}
	}
	//alert( "6" );
	obj = document.getElementById("telno");
	if (obj.value == "")
	{
		alert("กรุณากรอก เบอร์โทร");
		obj.focus();
		return;
	}
	//alert( " 7" );
	obj = document.getElementById("user_type");
	if (obj.value == "")
	{
		alert("กรุณาเลือกประเภท");
		obj.focus();
		return;
	}

	/*obj = document.getElementById("hotspot_id");
	if (obj.value == "")
	{
		alert("กรุณาเลือก Hotspot");
		obj.focus();
		return;
	}
	*/
	if (confirm("ต้องการบันทึกข้อมูล ? "))
	{
		document.forms[0].method.value = "<?=empty($method) ? "save" : $method ?>";
		document.forms[0].status.value = "init";
		document.forms[0].submit();
	}
	
 }

 function generateData(dest)
{
	var obj = document.getElementById(dest);
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 10; i++ )
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
	xmlhttp.open("GET","getuserexisting.php?username="+str.value,true);
	xmlhttp.send();
}


</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<tbody> 
	<tr>
		<td>
			<table width ="100%">

				<tr>
					<td align = "right"><h3>Username : <h3></td>
					<td><input type = "text" size = "30" name = "username" id = "username" value = "<?=$username?>" onblur = "<?=$validateUser?>" maxlength = "20">&nbsp;&nbsp;<a href = "javascript: generateData('username')"> Generate Username</a>
					&nbsp;&nbsp;<div id="validateUserMsg"><h2></h2></div></td>
				</tr>
				
				<tr>
					<td align = "right"><h3>Password : <h3></td>
					<td><input type = "text" size = "30" name = "password" id = "password" value = "<?=$password?>" maxlength = "20">&nbsp;&nbsp;<a href = "javascript: generateData('password')"> Generate Password</a></td>
				</tr>
				
				<tr>
					<td align = "right"><h3>ชื่อ-นามสกุล : <h3></td>
					<td><input type = "text" size = "50" name = "firstname" id = "firstname" value = "<?=$firstname?>"> - <input type = "text" size = "50" name = "lastname" id = "lastname" value = "<?=$lastname?>"></td>
				</tr>
				
				<tr>
					<td align = "right"><h3>Email : <h3></td>
					<td><input type = "text" size = "30" name = "email" id = "email" value = "<?=$email?>"></td>
				</tr>
				<tr>
					<td align = "right"><h3>เบอร์โทร : <h3></td>
					<td><input type = "text" size = "30" name = "telno" id = "telno" value = "<?=$telno?>"></td>
				</tr>
				<tr>
					<td align = "right"><h3>ประเภท : <h3></td>
					<td>
						<select name = "user_type" id = "user_type">	
							<option value ="">เลือก</option>
							<option value ="ADMIN_SITE"  <?=$user_type == "ADMIN_SITE" ? "selected" : ""?> >Site Admin</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align = "right"><h3>Hotspot : <h3></td>
					<td>
						<select name = "hotspot_id" id = "hotspot_id" >
							<option value = "">None</option>
							<?php
							//Generate hotspot list into select list
							for ($ii=0;$ii<count($hotspotid_array);$ii++)
							{
							?>
							<option value = "<?=$hotspotid_array[$ii]?>" <?=$hotspotid_array[$ii] == $hotspot_id ? "selected" : ""?> ><?=$hotspotname_array[$ii]?></option>
							<?php
							}//Close generate hotspot list
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td align = "center" colspan ="2">
						<input type = "button" name = "savearticle" onclick = "save()" id = "savearticle" value = " บันทึก ">&nbsp;&nbsp;<input type = "button" name = "cancel" id = "cancel" value = " ยกเลิก ">
						<input type = "hidden" name="editId" id = "editId" value="<?=$_POST["editId"]?>">
						<input type = "hidden" name="validateUserFlag" id = "validateUserFlag" value="NO">
					</td>
				</tr>
			</table>
		</td>
	</tr> 
</tbody> 
</table>