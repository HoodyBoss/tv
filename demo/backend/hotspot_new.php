<?php
$method=$_POST["method"];
$editId=$_POST["editId"];
$language=empty($_POST["language"])?"th":$_POST["language"];
$sql = "select *  from tb_b_hotspot where id = '$editId' ";
//echo $sql;
$db->send_cmd($sql);
$firstclass = "class=\"first-news\"";
$rnd=0;
while ($row=$db->get_result())
{
	$id = $row["id"];
	$hotspot_name = $row["hotspot_name"];
	$tv_id = $row["tv_id"];
	$image = $row["hotspot_image"];
	$hotspot_macaddress = $row["hotspot_macaddress"];
}
?> 
<!-- Add jQuery library -->
	<script type="text/javascript" src="popup/js/jquery-1.10.1.min.js"></script>

	<!-- Add mousewheel plugin (this is optional) -->
	<script type="text/javascript" src="popup/js/jquery.mousewheel-3.0.6.pack.js"></script>

	<!-- Add fancyBox main JS and CSS files -->
	<script type="text/javascript" src="popup/src/jquery.fancybox.js?v=2.1.5"></script>
	<link rel="stylesheet" type="text/css" href="popup/src/jquery.fancybox.css?v=2.1.5" media="screen" />

	<!-- Add Button helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="popup/src/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<script type="text/javascript" src="popup/src/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

	<!-- Add Thumbnail helper (this is optional) -->
	<link rel="stylesheet" type="text/css" href="popup/src/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
	<script type="text/javascript" src="popup/src/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<!-- Add Media helper (this is optional) -->
	<script type="text/javascript" src="popup/src/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			/*
			 *  Simple image gallery. Uses default settings
			 */

			$('.fancybox').fancybox();

			/*
			 *  Different effects
			 */

			// Change title type, overlay closing speed
			$(".fancybox-effects-a").fancybox({
				helpers: {
					title : {
						type : 'outside'
					},
					overlay : {
						speedOut : 0
					}
				}
			});

			// Disable opening and closing animations, change title type
			$(".fancybox-effects-b").fancybox({
				openEffect  : 'none',
				closeEffect	: 'none',

				helpers : {
					title : {
						type : 'over'
					}
				}
			});

			// Set custom style, close if clicked, change title type and overlay color
			$(".fancybox-effects-c").fancybox({
				wrapCSS    : 'fancybox-custom',
				closeClick : true,

				openEffect : 'none',

				helpers : {
					title : {
						type : 'inside'
					},
					overlay : {
						css : {
							'background' : 'rgba(238,238,238,0.85)'
						}
					}
				}
			});

			// Remove padding, set opening and closing animations, close if clicked and disable overlay
			$(".fancybox-effects-d").fancybox({
				padding: 0,

				openEffect : 'elastic',
				openSpeed  : 150,

				closeEffect : 'elastic',
				closeSpeed  : 150,

				closeClick : true,

				helpers : {
					overlay : null
				}
			});

			/*
			 *  Button helper. Disable animations, hide close button, change title type and content
			 */

			$('.fancybox-buttons').fancybox({
				openEffect  : 'none',
				closeEffect : 'none',

				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,

				helpers : {
					title : {
						type : 'inside'
					},
					buttons	: {}
				},

				afterLoad : function() {
					this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
				}
			});


			/*
			 *  Thumbnail helper. Disable animations, hide close button, arrows and slide to next gallery item if clicked
			 */

			$('.fancybox-thumbs').fancybox({
				prevEffect : 'none',
				nextEffect : 'none',

				closeBtn  : false,
				arrows    : false,
				nextClick : true,

				helpers : {
					thumbs : {
						width  : 50,
						height : 50
					}
				}
			});

			/*
			 *  Media helper. Group items, disable animations, hide arrows, enable media and button helpers.
			*/
			$('.fancybox-media')
				.attr('rel', 'media-gallery')
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});

			/*
			 *  Open manually
			 */

			$("#fancybox-manual-a").click(function() {
				$.fancybox.open('1_b.jpg');
			});

			$("#fancybox-manual-b").click(function() {
				$.fancybox.open({
					href : 'iframe.html',
					type : 'iframe',
					padding : 5
				});
			});

			$("#fancybox-manual-c").click(function() {
				$.fancybox.open([
					{
						href : '1_b.jpg',
						title : 'My title'
					}, {
						href : '2_b.jpg',
						title : '2nd title'
					}, {
						href : '3_b.jpg'
					}
				], {
					helpers : {
						thumbs : {
							width: 75,
							height: 50
						}
					}
				});
			});


		});
	</script>
	<style type="text/css">
		.fancybox-custom .fancybox-skin {
			box-shadow: 0 0 50px #222;
		}
	</style>
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
	 
	var obj = document.getElementById("hotspot_name");
	if (obj.value == "")
	{
		alert("กรุณากรอกชื่อ");
		obj.focus();
		return;
	}

	obj = document.getElementById("hotspot_macaddress");
	if (obj.value == "")
	{
		alert("กรุณากรอก Identity");
		obj.focus();
		return;
	}

	obj = document.getElementById("tv_id");
	if (obj.value == "")
	{
		alert("กรุณาเลือกช่อง tv");
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

 function reviewMap()
 {
	 var hotspot_name = document.getElementById("hotspot_name");
	 var lat = document.getElementById("lat");
	 var lng = document.getElementById("lng");

	 if (lat.value=="")
	 {
		 alert("กรุณากรอกละติจูด (Lat)");
		 lat.focus();
		 return;
	 }

	 if (lng.value=="")
	 {
		 alert("กรุณากรอกลองติจูด (Long)");
		 lng.focus();
		 return;
	 }

	 window.open("preview_map.php?name="+hotspot_name.value+"&lat="+lat.value+"&lng="+lng.value,"reviewmap","width=800,height=500");
 }

</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<tbody> 
	<tr>
		<td>
			<table width ="100%">
				<tr>
					<td align = "right"><h3>ชื่อ : <h3></td>
					<td><input type = "text" size = "50" name = "hotspot_name" id = "hotspot_name" value = "<?=$hotspot_name?>"></td>
				</tr>
				<tr>
					<td align = "right"><h3>Identity : <h3></td>
					<td><input type = "text" size = "50" name = "hotspot_macaddress" id = "hotspot_macaddress" value = "<?=$hotspot_macaddress?>"></td>
				</tr>
				 <tr>
					<td align = "right"><h3>รูป (ถ้ามี) : <h3></td>
					<td><input type = "file" name = "hotspot_image" id = "hotspot_image">&nbsp;&nbsp;รูปภาพ jpeg,png เท่านั้น &nbsp;&nbsp;
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
					<td align = "right"><h3>ช่องทีวี : <h3></td>
					<td>
						<!-- <select name = "tv_id" id = "tv_id" >
						<option value = "">None</option>
						<?php
						//Generate hotspot list into select list
						for ($ii=0;$ii<count($tvidarray);$ii++)
						{
						?>
						<option value = "<?=$tvidarray[$ii]?>" <?=$tvidarray[$ii] == $tv_id ? "selected" : $ii==0 ? "selected" : "" ?> ><?=$tvnamearray[$ii]?></option>
						<?php
						}//Close generate hotspot list
						?>
					</select> 
					หรือ <a class="fancybox fancybox.iframe" href="popup/site_tv_selection.php?id=<?=$id?>&tv_id=<?=$tv_id?>">เลือกที่นี่</a> -->

					<table width = "96%" align = "center">
					<?php
					//Generate hotspot list into select list
					for ($ii=0;$ii<count($tvidarray);$ii++)
					{
						if ($ii==0 || $ii%4==0)
							echo "<tr>";
					?>
						<td width = "25%" align = "center"><!-- -->
						<!-- href = "javascript: assignChannel('<?=$tvidarray[$ii]?>')" -->
							<input type = "radio" name = "tv_id" id = "tv_id" value = "<?=$tvidarray[$ii]?>"  <?=$tv_id==$tvidarray[$ii] ? "checked":""?>><br>
							<a class="fancybox fancybox.iframe"   href="popup/tvpreview.php?id=<?=$tvidarray[$ii]?>"  title = "<?=$tvnamearray[$ii]?>" >
								<img src="attachfiles/<?=$tvimgarray[$ii]?>" width = "150" height = "150">
							</a>
						</td>
					<?php
						if ($ii%4==3)
							echo "</tr>";
					}//Close generate hotspot list
					?>
					
				</table>
					</td>
				</tr> 
				
				
				
				<tr>
					<td align = "center" colspan ="2">
						<input type = "button" name = "savearticle" onclick = "save()" id = "savearticle" value = " บันทึก ">&nbsp;&nbsp;<input type = "button" name = "cancel" id = "cancel" value = " ยกเลิก " onclick = " localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'hotspot' , 'init' , 'Hotspot Registration' ))">
						<input type = "hidden" name="editId" id = "editId" value="<?=$_POST["editId"]?>">
					</td>
				</tr>
			</table>
		</td>
	</tr> 
</tbody> 
</table>
<input type = "hidden" name = "TABLENAME" id = "TABLENAME" value="tb_b_hotspot">
<input type = "hidden" name = "PARAMS" id = "PARAMS" value="hotspot_name|hotspot_macaddress|tv_id|hotspot_image">
<input type = "hidden" name = "PARAMSTYPE" id = "PARAMSTYPE" value="text|text|text|img">
<input type = "hidden" name = "PARAMSLANG" id = "PARAMSLANG" value="N|N|N|N">