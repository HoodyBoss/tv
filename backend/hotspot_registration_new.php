<?php
$method=$_POST["method"];
$editId=$_POST["editId"];

$sql = "select *  from account where id = '$editId' ";
//echo $sql;
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
	$username = $row["username"];
	$price = $row["price"];
	$group_status = $row["group_status"];
	$package_detail = $row["package_detail"];
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
	 
	var obj = document.getElementById("group_name");
	if (obj.value == "")
	{
		alert("กรุณากรอกชื่อกลุ่ม");
		obj.focus();
		return;
	}	

	obj = document.getElementById("price");
	if (obj.value == "")
	{
		alert("กรุณากรอกราคา Package ( ถ้าเป็น Free Package กรุณาใส่ 0 )");
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
					<td><input type = "text" size = "50" name = "group_name" id = "group_name" value = "<?=$group_name?>"></td>
				</tr>
				
				<tr>
					<td align = "right"><h3>ราคา : <h3></td>
					<td><input type = "text" size = "30" name = "price" id = "price" value = "<?=$price?>"></td>
				</tr>
				<tr>
					<td align = "right" valign = "top"><h3>รายละเอียด (ถ้ามี) : <h3></td>
					<td><textarea name = "package_detail" id = "package_detail" cols = "100" rows="20"><?=$package_detail?></textarea></td>
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