<?php
$method=$_POST["method"];
$editId=$_POST["editId"];

$sql = "select *  from tb_b_user_group where id = '$editId' ";
//echo $sql;
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
	$group_name = $row["group_name"];
	$price = $row["price"];
	$group_status = $row["group_status"];
	$package_detail = $row["package_detail"];
	$account_active_day = $row["account_active_day"];
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
	/*else
	{
		if (isNumber(obj.value))
		{
			alert("กรุณากรอกเฉพาะตัวเลขเท่านั้น");
			obj.focus();
			return;
		}
	}*/

	/*obj = document.getElementById("account_active_day");
	if (obj.value == "")
	{
		alert("กรุณากรอกจำนวนวันหมดอายุของผู้ใช้");
		obj.focus();
		return;
	}
	else
	{
		if (isNumber(obj))
		{
			alert("กรุณากรอกเฉพาะตัวเลขเท่านั้น");
			obj.focus();
			return;
		}
	}*/

	if (confirm("ต้องการบันทึกข้อมูล ? "))
	{
		document.forms[0].method.value = "<?=empty($method) ? "save" : $method ?>";
		document.forms[0].status.value = "init";
		document.forms[0].submit();
	}

 }

 function enableDet(item)
 {
	 if (item.checked)
	 {
		 document.getElementById("att_det"+item.value).disabled = false;
	 }
	 else
	 {
		 document.getElementById("att_det"+item.value).disabled = true;
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
					<td align = "right"><h3>จำนวนวันหมดอายุของผู้ใช้ : <h3></td>
					<td><input type = "text" size = "30" name = "account_active_day" id = "account_active_day" value = "<?=$account_active_day?>"></td>
				</tr>
				<tr>
					<td align = "right"><input type = "checkbox" name = "default_package" id = "default_package" value = "Y" <?=$default_package=="Y"?"checked":""?>></td>
					<td><h3>กำหนดเป็น Package เริ่มต้นสำหรับผู้ลงทะเบียน<h3></td>
				</tr>
				<tr>
					<td align = "right" valign = "top"><h3>ข้อกำหนดการใช้ : <h3></td>
					<td>
						<table width = "100%">
						<?php
						$attHdrId = array();
						$attHdrName = array();
						$sql = "select * from tb_b_attribute_hdr where status = 'Y' order by id";
						$db->send_cmd($sql);
						$ii=0;
						while ($row=$db->get_result())
						{
							$attHdrId[$ii] = $row["id"];
							$attHdrName[$ii] = $row["attr_name"];
							$ii++;
						}
						
						for ($ii=0;$ii<count($attHdrId);$ii++)
						{
						?>
							<tr>
								<td align = "center"><input type = "checkbox" id = "att_hdr[]" name = "att_hdr[]" value = "<?=$attHdrId[$ii]?>" onclick = "enableDet(this)"></td>
								<td align = "right" width = "30%"><?=$attHdrName[$ii]?>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
								<td>
									<select id = "att_det<?=$attHdrId[$ii]?>" name = "att_det<?=$attHdrId[$ii]?>" disabled>
										<option value = "">เลือก</option>
										<?php
											$sql = "select * from tb_b_attribute_det where hdr_id = '".$attHdrId[$ii]."' and status = 'Y' order by id";
											$db->send_cmd($sql);
											while ($row=$db->get_result())
											{
												$detId = $row["id"];
												$detVal = $row["attr_value"];
												$detDesc = $row["attr_value"];
										?>
												<option value = "<?=$detVal?>"><?=$detDesc?></option>
										<?php
											}
										?>
									</select>
								</td>
							</tr>
						<?php
						}
						?>
						</table>
					</td>
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