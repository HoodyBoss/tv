<?php
$method=$_REQUEST["method"];
$editId=$_REQUEST["editId"];
$language=empty($_REQUEST["language"])?"th":$_REQUEST["language"];
$sql = "select *  from tb_b_shortmsg where id = '$editId' ";
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
	$short_msg = $row["short_msg_$language"];
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
	var inputName = ["short_msg"];
	var inputType = ["text"];//Enter type for validate special fields ( eg. if enter "number" program will validate must enter number only). Following is posible data for this var "text" , "number" , "email" 
	var inputFormat = ["" ];//Enter regular expression for validate format 
	var inputRequire = [1];//Require field 0=Not require , 1=Require
	var inputDesc  = ["ข่าวสั้น"];	

	if ( validateForm( inputName , inputType , inputFormat , inputRequire , inputDesc ) )
	{
		if (confirm("ต้องการบันทึกข้อมูล ? ") )
		{
			document.forms[0].method.value = "<?=empty($method) ? "save" : $method ?>";
			document.forms[0].status.value = "init";
			document.forms[0].submit();
		}
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
					<td align = "right"><h3>ข่าวสั้น : <h3></td>
					<td><input type = "text" size = "50" name = "short_msg" id = "short_msg" value = "<?=$short_msg?>"></td>
				</tr>
				
				<tr>
					<td align = "center" colspan ="2">
						<input type = "button" name = "savearticle" onclick = "save()" id = "savearticle" value = " บันทึก ">&nbsp;&nbsp;<input type = "button" name = "cancel" id = "cancel" value = " ยกเลิก " onclick = "localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'shortmsg' , 'init' , 'ข่าวสั้น' ))">
						<input type = "hidden" name="editId" id = "editId" value="<?=$_REQUEST["editId"]?>">
					</td>
				</tr>
			</table>
		</td>
	</tr> 
</tbody> 
</table>
<input type = "hidden" name = "TABLENAME" id = "TABLENAME" value="tb_b_shortmsg">
<input type = "hidden" name = "PARAMS" id = "PARAMS" value="short_msg">
<input type = "hidden" name = "PARAMSTYPE" id = "PARAMSTYPE" value="text">
<input type = "hidden" name = "PARAMSLANG" id = "PARAMSLANG" value="Y">