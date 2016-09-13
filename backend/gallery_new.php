<?php
$method=$_REQUEST["method"];
$editId=$_REQUEST["editId"];
$language=empty($_REQUEST["language"])?"en":$_REQUEST["language"];
$sql = "select *  from tb_b_gallery where id = '$editId' ";
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
    $title_th = $row["title_th"];
	$image = $row["img_file"];
}
?>

<script type="text/javascript">

 function save()
 {

	<?php
	if (empty($image))
	{
	?>
	var image = document.getElementById("img_file");
	if (image.value == "")
	{
		alert("กรุณาเลือกรูป");
		image.focus();
		return;
	}
	else
	{
		file = image.files[0];
		if ( file.size > 512000 )
		{
			alert("กรุณาเลือกไฟล์ที่มีขนาดไม่เกิน 500 KB");
			input.focus();
			return; 
		}
	}
	<?php
	}
	?>
     
    var input = document.getElementById("pics_file");
	if (input.value.indexOf(".zip")<0)
	{
		alert("กรุณาเลือกไฟล์ .zip เท่านั้น");
		
		return;
	}
	else
	{
		file = input.files[0];
		if ( file.size > 26214400 )
		{
			alert("กรุณาเลือกไฟล์ที่มีขนาดไม่เกิน 25 MB");
			input.focus();
			return; 
		}
	}
    
    
	if (confirm("ต้องการบันทึกข้อมูล ? "))
	{
		document.forms[0].method.value = "<?=empty($method) ? "save" : $method ?>";
		document.forms[0].status.value = "init";
		document.forms[0].submit();
	}

 }

</script>

<table class="tablesorter" cellspacing="0" width = "100%"> 
<tbody> 
	<tr>
		<td>
			<table width ="100%">
                <tr>
					<td align = "right"><h3>ชื่ออัลบั้ม : <h3></td>
					<td><input type = "text" name = "title_th" id = "title_th" value = "<?=$title_th?>" >
					</td>
				</tr>
				<tr>
					<td align = "right"><h3>รูปอัลบั้ม : <h3></td>
					<td><input type = "file" name = "img_file" id = "img_file">&nbsp;&nbsp;รูปภาพ jpeg, png เท่านั้น &nbsp;(ขนาดไม่เกิน 500 KB)
					<?php
						if (!empty($image))
						{
					?>
						<a href="attachfiles/<?=$image?>" target="_blank"><img src="attachfiles/<?=$image?>" width = "35" height = "35"></a>
					<?php
						}
					?>
					</td>
				</tr>
				<tr>
					<td align = "right"><h3>รูปทั้งหมด : <h3></td>
					<td>
                        <input type = "file" name = "pics_file" id = "pics_file">&nbsp;&nbsp;ไฟล์ zip เท่านั้น &nbsp;(ขนาดไม่เกิน 25 MB)
					</td>
				</tr>
				
				<tr>
					<td align = "center" colspan ="2">
						<input type = "button" name = "savearticle" onclick = "save()" id = "savearticle" value = " บันทึก ">&nbsp;&nbsp;<input type = "button" name = "cancel" id = "cancel" value = " ยกเลิก " onclick = "localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'gallery' , 'init' , 'จัดการข้อมูล รูปภาพ ' ))">
						<input type = "hidden" name="editId" id = "editId" value="<?=$_REQUEST["editId"]?>">
					</td>
				</tr>
			</table>
		</td>
	</tr> 
</tbody> 
</table>
<input type = "hidden" name = "TABLENAME" id = "TABLENAME" value="tb_b_gallery">
<input type = "hidden" name = "PARAMS" id = "PARAMS" value="title_th|img_file">
<input type = "hidden" name = "PARAMSTYPE" id = "PARAMSTYPE" value="text|file">
<input type = "hidden" name = "PARAMSLANG" id = "PARAMSLANG" value="N|N">