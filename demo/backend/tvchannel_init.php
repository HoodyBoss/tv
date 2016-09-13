
<script type="text/javascript">
<!--
	function deleteItem( item , title )
	{
		if (confirm("คุณต้องการลบช่องโทรทัศน์ "+title+" ?"))
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
		<td colspan = "5" valign = "middle"><a href = "javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'tvchannel' , 'new' , 'จัดการข้อมูลช่องโทรทัศน์' ))"><img src="images/icn_new_article.png" width = "25" height = "25" title = "สร้างใหม่"></a></td> 
	</tr>
	<?php
	include "processresult_bar.php";
	?>
</thead> 

	<?php
	
	//Prepare condition before query data
	$condition =  "where status = 'Y' ";
	try
	{
		//Get no of page to do paging
		$noOfPage = $dataTable->getPageCount( $db ,  "tb_b_tv_channel" , $condition , $recPerPage );

		//Prepare column display on datatable
		$colArray = array( "id" , "tv_name" , "image" );
		$colNameArray = array( "image" , "tv_name", "action" );
		$colDescArray = array( "" , "ช่องโทรทัศน์" , "Action" );
		$colTypeArray = array( "img" , "text" , "action-M|E|D" );

		//Get data for data table
		$data =  $dataTable->getData( $db ,  "tb_b_tv_channel" , $condition , $colArray) ;
		
		echo $dataTable->genHeader( $colDescArray );
		echo $dataTable->genDetail( $colNameArray , $colTypeArray , $data );

		include "paging.php";
	}
	catch(Exception $e)
	{
		echo "<tr><td colspan = \"25\">".$e->getMessage()."</td></tr>";
	}
	?>

	<tr> 
		<td colspan = "5"></td> 
	</tr>  
</tbody> 
</table>
<input type = "hidden" name = "deleteId" id = "deleteId" >
<input type = "hidden" name = "editId" id = "editId" >
<input type = "hidden" name = "TABLENAME" id = "TABLENAME" value="TB_B_TV_CHANNEL">