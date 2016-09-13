<?php
$method=$_REQUEST["method"];
$editId=$_REQUEST["editId"];
$language=empty($_REQUEST["language"])?"th":$_REQUEST["language"];
$sql = "select *  from tb_b_news where id = '$editId' ";
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
	$title = $row["title_$language"];
	$date = $row["date"];
	$image = $row["image"];
	$short_msg = $row["short_msg_$language"];
	$detail = $row["detail_$language"];
	$detail = str_replace(  "../backend/assets/" , "assets/" , $detail );
	$detail_file = $row["detail_file_$language"];
}
?>
<script src="tinymce/tinymce.min.js" type="text/javascript"></script>
<script type="text/javascript">
/*tinymce.init({
    selector: "textarea"
 });
*/
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
	 var language = document.getElementById("language");
	if (language.value == "")
	{
		alert("กรุณาเลือกภาษา");
		language.focus();
		return;
	}
	var title = document.getElementById("title");
	if (title.value == "")
	{
		alert("กรุณากรอกข้อมูลหัวข้อ");
		title.focus();
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

	var date = document.getElementById("date");
	if (date.value == "")
	{
		alert("กรุณากรอกข้อมูลระบุวันที่");
		date.focus();
		return;
	}

	/*var short_msg = document.getElementById("short_msg");
	if (short_msg.value == "")
	{
		alert("กรุณากรอกข้อความสั้น");
		short_msg.focus();
		return;
	}
	*/

	if (confirm("ต้องการบันทึกข้อมูลข่าวสาร ? "))
	{
		document.forms[0].method.value = "<?=empty($method) ? "save" : $method ?>";
		document.forms[0].status.value = "init";
		document.forms[0].submit();
	}

 }

 function changeLang()
 {
	 var language = document.getElementById("language");
	 if (language.value != "")
	 {
		document.forms[0].method.value = "<?=empty($method) ? "save" : $method ?>";
		document.forms[0].status.value = "new";
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
					<td align = "right"><h3>ภาษา : <h3></td>
					<td>
						<select name = "language" id = "language" onchange = "changeLang()">
							<option value = "">เลือกภาษา</option>
							<option value = "th" <?=$language=="th"?"selected":""?>>ไทย</option>
							<option value = "en" <?=$language=="en"?"selected":""?>>English</option>
							<option value = "ch" <?=$language=="ch"?"selected":""?>>Chinese</option>
						</select>
					</td>
				</tr>
				<tr>
					<td align = "right"><h3>หัวข้อ : <h3></td>
					<td><input type = "text" size = "50" name = "title" id = "title" value = "<?=$title?>"></td>
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
					<td align = "right"><h3>วันที่ : <h3></td>
					<td><input type = "text" name = "date" id = "date" class = "tcal" value = "<?=$date?>"></td>
				</tr>
				<!-- <tr>
					<td align = "right"><h3>ข้อความสั้น : <h3></td>
					<td><input type = "text" size = "50" name = "short_msg" id = "short_msg" value = "<?=$short_msg?>"></td>
				</tr> -->
				<tr>
					<td align = "right" valign = "top"><h3>รายละเอียด : <h3></td>
					<td><textarea name = "detail" id = "detail" cols = "100" rows="20"><?=$detail?></textarea></td>
				</tr>
				
				<tr>
					<td align = "center" colspan ="2">
						<input type = "button" name = "savearticle" onclick = "save()" id = "savearticle" value = " บันทึก ">&nbsp;&nbsp;<input type = "button" name = "cancel" id = "cancel" value = " ยกเลิก " onclick = "localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'news' , 'init' , 'NEWS & ANNOUNCEMENT' ))">
						<input type = "hidden" name="editId" id = "editId" value="<?=$_REQUEST["editId"]?>">
					</td>
				</tr>
			</table>
		</td>
	</tr> 
</tbody> 
</table>
<input type = "hidden" name = "TABLENAME" id = "TABLENAME" value="tb_b_news">
<input type = "hidden" name = "PARAMS" id = "PARAMS" value="title|image|date|detail">
<input type = "hidden" name = "PARAMSTYPE" id = "PARAMSTYPE" value="text|file|text|text">
<input type = "hidden" name = "PARAMSLANG" id = "PARAMSLANG" value="Y|N|N|Y">