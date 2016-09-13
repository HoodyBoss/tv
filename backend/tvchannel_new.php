<?php
$method=$_REQUEST["method"];
$editId=$_REQUEST["editId"];
$language=empty($_REQUEST["language"])?"en":$_REQUEST["language"];
$sql = "select *  from tb_b_tv_channel where id = '$editId' ";
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
	$tv_name = $row["tv_name"];
	$tv_url = $row["tv_url"];
	$tv_desc = $row["tv_desc"];
	$image = $row["image"];
}
?>
<script src="tinymce/tinymce.min.js" type="text/javascript"></script>
<script type="text/javascript">

 tinymce.init({
   selector: "textarea", 
	theme: "modern", 
	width: 680, 
	height: 300, 
	subfolder:"", 
	plugins: [ 
	"advlist autolink link image lists charmap print preview hr anchor pagebreak", 
	"searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking", 
	"table contextmenu directionality emoticons paste textcolor filemanager" 
	]
	 , image_advtab: true 
	,toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink anchor | image media | print preview code" 
 });

 function save()
 {

	var obj = document.getElementById("tv_name");
	if (obj.value == "")
	{
		alert("กรุณากรอกข้อมูลชื่อ");
		obj.focus();
		return;
	}
	
	<?php
	if (empty($image))
	{
	?>
	var image = document.getElementById("image");
	if (image.value == "")
	{
		alert("กรุณาเลือกรูป");
		image.focus();
		return;
	}
	<?php
	}
	?>

	obj = document.getElementById("tv_url");
	if (obj.value == "")
	{
		alert("กรุณากรอกข้อมูล Link สำหรับดูออนไลน์");
		obj.focus();
		return;
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
					<td align = "right"><h3>ชื่อ : <h3></td>
					<td><input type = "text" size = "50" name = "tv_name" id = "tv_name" value = "<?=$tv_name?>"></td>
				</tr>
				<tr>
					<td align = "right"><h3>รูป : <h3></td>
					<td><input type = "file" name = "image" id = "image">&nbsp;&nbsp;รูปภาพ jpeg,png เท่านั้น &nbsp;&nbsp;
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
					<td align = "right" valign = "top"><h3>Link สำหรับดูออนไลน์ : <h3></td>
					<td><textarea name = "tv_url" id = "tv_url" cols = "100" rows="20"><?=$tv_url?></textarea></td>
				</tr>
				
				<tr>
					<td align = "center" colspan ="2">
						<input type = "button" name = "savearticle" onclick = "save()" id = "savearticle" value = " บันทึก ">&nbsp;&nbsp;<input type = "button" name = "cancel" id = "cancel" value = " ยกเลิก " onclick = "localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'tv_channel' , 'init' , 'จัดการข้อมูลช่องโทรทัศน์' ))">
						<input type = "hidden" name="editId" id = "editId" value="<?=$_REQUEST["editId"]?>">
					</td>
				</tr>
			</table>
		</td>
	</tr> 
</tbody> 
</table>
<input type = "hidden" name = "TABLENAME" id = "TABLENAME" value="tb_b_tv_channel">
<input type = "hidden" name = "PARAMS" id = "PARAMS" value="tv_name|image|tv_url">
<input type = "hidden" name = "PARAMSTYPE" id = "PARAMSTYPE" value="text|file|text">
<input type = "hidden" name = "PARAMSLANG" id = "PARAMSLANG" value="N|N|N">