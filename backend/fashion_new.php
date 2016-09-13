<?php
$method=$_POST["method"];
$editId=$_POST["editId"];
$language=empty($_POST["language"])?"th":$_POST["language"];
$sql = "select *  from tb_b_fashion where id = '$editId' ";
//echo $sql;
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
	$type = $row["type"];
}
?>
<script src="js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script type="text/javascript">
/*tinymce.init({
    selector: "textarea"
 });
 */
 tinymce.init({
    selector: "textarea",theme: "modern"
   , plugins: [
         "advlist autolink link image lists charmap print preview hr anchor pagebreak",
         "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
         "table contextmenu directionality emoticons paste textcolor responsivefilemanager"
   ],
   toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect"
   /*, toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code "
  , image_advtab: true ,
   external_filemanager_path:"filemanager/"
 , filemanager_title:"Responsive Filemanager" ,
  , external_plugins: { "filemanager" : "filemanager/plugin.min.js"}*/
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
	/*var image = document.getElementById("image");
	if (image.value == "")
	{
		alert("กรุณาเลือกรูป");
		image.focus();
		return;
	}*/
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

	var short_msg = document.getElementById("short_msg");
	if (short_msg.value == "")
	{
		alert("กรุณากรอกข้อความสั้น");
		short_msg.focus();
		return;
	}

	/*var detail = document.getElementById("detail");
	if (detail.value == "")
	{
		alert("กรุณากรอกรายละเอียด");
		detail.focus();
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
						</select>
					</td>
				</tr>
				<!-- <tr>
					<td align = "right"><h3>ประเภท : <h3></td>
					<td>
						<select name = "type" id = "type" >
							<option value = "">เลือกประเภท</option>
							<option value = "1" <?=$type=="1"?"selected":""?>>ข่าวประกาศ</option>
							<option value = "2" <?=$type=="2"?"selected":""?>>ข่าวประชาสัมพันธ์</option>
						</select>
					</td>
				</tr> -->
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
				<tr>
					<td align = "right"><h3>ข้อความสั้น : <h3></td>
					<td><input type = "text" size = "50" name = "short_msg" id = "short_msg" value = "<?=$short_msg?>"></td>
				</tr>
				<tr>
					<td align = "right" valign = "top"><h3>รายละเอียด : <h3></td>
					<td><textarea name = "detail" id = "detail" cols = "100" rows="20"><?=$detail?></textarea></td>
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