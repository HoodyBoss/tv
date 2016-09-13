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
<!--  -->
<script type="text/javascript">
<!--
	function deleteItem( item , title )
	{
		if (confirm("คุณต้องการลบข้อมูล "+title+" ?"))
		{
			document.getElementById("deleteId").value = item;
			document.getElementById("method").value = "delete";
			document.getElementById("status").value = "init";
			document.forms[0].action = "<?=$curFile?>";
			document.forms[0].submit();
		}
	}

	function editItem( item )
	{
		document.getElementById("editId").value = item;
		document.getElementById("method").value = "edit";
		document.getElementById("status").value = "new";
		document.forms[0].action = "<?=$curFile?>";
		document.forms[0].submit();
	}
//-->
</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	<tr> 
		<td colspan = "25" valign = "middle"><a href = "javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'hotspot' , 'new' , 'Hotspot' ))"><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></td> 
	</tr> 
	<?php
	include "processresult_bar.php";
	?>
</thead> 
<thead> 
	<tr> 
		<td align = "center"><b>ชื่อ</b></td>
		<td align = "center"><b>Identity</b></td>
		<td align = "center"><b>ช่องทีวี</b></td> 
		<td align = "center"><b>URL</b></td> 
		<td align = "center"><b>Actions</b></td> 
	</tr> 
</thead> 
<tbody> 
	<?php

	$bgcolor = "FFFFFF";

	$sql = "SELECT ceil( count(*)/$recPerPage ) FROM tb_b_hotspot a,tb_b_tv_channel b where a.tv_id = b.id and hotspot_status = 'Y' ";
	
	//echo $sql;
	$db->send_cmd($sql);
	$noOfPage = 1;
	while ($row=$db->get_data())
	{
		$noOfPage = $row[0];
	}

	$sql = " select a.id,hotspot_name,hotspot_macaddress,tv_name,concat( 'http://118.175.48.147:8251/index.php?id=',a.id) as link  FROM tb_b_hotspot  a,tb_b_tv_channel b where a.tv_id = b.id and hotspot_status = 'Y' order by a.id desc";
	
	$db->send_cmd($sql);
	while ($row=$db->get_result())
	{
		$id = $row["id"];
		$hotspot_name = $row["hotspot_name"];
		$tv_name = $row["tv_name"];
		$hotspot_macaddress = $row["hotspot_macaddress"];
		$link = $row["link"];

		$bgcolor = $bgcolor=="FFFFFF" ? "CCCCCC" : "FFFFFF";
	?>
	<tr bgcolor ="<?=$bgcolor?>"> 
		<td>
			<?=$hotspot_name?>
		</td>
		<td>
			<?=$hotspot_macaddress?>
		</td>
		<td align = "center">
			<?=$tv_name?>
		</td> 
		<td align = "center">
			<?=$link?>
		</td> 
		
		<td align = "center"><a class="fancybox fancybox.iframe" href="popup/site_preview_tv.php?id=<?=$row["id"]?>"><input type="image" src="images/icn_video.png" title="Preview" ></a>
		<input type="image" src="images/icn_edit.png" title="Edit" onclick = "editItem('<?=$id?>'  )"><input type="image" src="images/icn_trash.png" title="Trash" onclick = "deleteItem('<?=$id?>' , '<?=$name?>' )"></td> 
	</tr> 
	<?php
	}

	include "paging.php";
	?>
	
	<tr> 
		<td colspan = "5"></td> 
	</tr>  
</tbody> 
</table>
<input type = "hidden" name="deleteId" id = "deleteId" >
<input type = "hidden" name="editId" id = "editId" >
<input type = "hidden" name = "TABLENAME" id = "TABLENAME" value="tb_b_hotspot">