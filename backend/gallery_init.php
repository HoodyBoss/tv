
<script type="text/javascript">
<!--  
	function deleteItem( item , title )
	{
		if (confirm("คุณต้องการลบ รูปภาพ "+title+" ?"))
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
    
    function moveUpp( item )
	{
        document.getElementById("editId").value = item;
		document.getElementById("method").value = "active_record";
		document.getElementById("status").value = "init";
		document.forms[0].action = "<?=$curFile?>";
		document.forms[0].submit();
	}
//-->
</script>
<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	<tr> 
		<td colspan = "5" valign = "middle"><a href = "javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'gallery' , 'new' , 'จัดการข้อมูลรูปภาพ' ))"><img src="images/icn_new_article.png" width = "25" height = "25" title = "เพิ่มรูปภาพ"></a></td> 
	</tr>
	<?php
    tracefile_debug("gallery_init.php" , "Method >> $method");
    tracefile_debug("gallery_init.php" , "processResult >> $processResult");
	
	function rmFileInDir($path)
	{
		if (empty($path)) { 
			return false;
		}
		return is_file($path) ?
				@unlink($path) :
				array_map(__FUNCTION__, glob($path.'/*')) ;
	}
	  
	function getCode( $db2 , $id )
	{
		$sql = "select code from tb_b_gallery where id = '$id' ";
        tracefile_debug("gallery_init.php" , "Get code sql >> $sql");
		$db2->send_cmd($sql);
		$row = $db2->get_result();
		$code = $row["code"];
		$db2->free_result();
        tracefile_debug("gallery_init.php" , "Get code >> $code");
		return $code;
	}
	

    if ( $method == "save" && $processResult==1 )
    {
        
        $obj = new SystemConfig();
		$config = $obj->unserializeObj( "SystemConfig" );
        $code = rand(100000000000000,999999999999999);
        
        $gallery_path = $config->getUploadPath().$code."/";
        mkdir($gallery_path);
        
        tracefile_debug("gallery_init.php" , "Gallery Path is >> $gallery_path");
        
        $gallery_id = $insert_id;
        tracefile_debug("gallery_init.php" , "gallery_id >> $gallery_id");
        //Upload file zip
        $zip = zip_open($_FILES["pics_file"]["tmp_name"]); // เปิดไฟล์ naxza.zip ด้วย zip lib
        if ($zip) { // เช็คว่าเปิดได้หรือเปล่า
            while ($zip_entry = zip_read($zip)) { // while loop เพื่ออ่านค่าใน zip ไฟล์
                $fp = fopen($gallery_path.zip_entry_name($zip_entry), "w"); // สร้าง folder naxza และนำชื่อไฟล์จากใน zip ไปสร้างไว้ใน folder
                if (zip_entry_open($zip, $zip_entry, "r")) { // อ่านค่าไฟล์ใน zip ขึ้นมา
                    $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)); //เก็บลงตัวแปร $buf
                    fwrite($fp,"$buf"); // ทำการเขียนลงไปในชื่อไฟล์ใน folder naxza
                    zip_entry_close($zip_entry); //ปิดการเปิดไฟล์ใน zip
                    fclose($fp); // ปิดการเขียนใน folder naxza
                }
                
            }
            zip_close($zip); // ปิดการเปิดไฟล์ zip

            $img_insqry = "insert into tb_b_gallery_items ( gallery_id , code , img_file  ) values ( '$gallery_id' , '$code' ";
            $sortedData = array();
            $ii=0;
            foreach(scandir($gallery_path) as $file) {
                tracefile_debug("gallery_init.php" , "File name >> ".$file);
                if(filetype($gallery_path . $file)=="file") {
                    $sortedData[$ii++] = $img_insqry.",'$file')";
                }
            }
            
            
            $insert_result = 0;
            for ($ii=0;$ii<count($sortedData);$ii++)
            {
                $db->send_cmd($sortedData[$ii]);
                tracefile_debug("gallery_init.php" , "Insert Gallery item >> ".$sortedData[$ii]);
            }
            
            $insert_result = $db->affected_rows();
            
            if ( $insert_result > 0 )
            {
				$sql = "update tb_b_gallery set status = 'N'";
				$db->send_cmd( $sql );

                $sql = "update tb_b_gallery set code = '$code' , status = 'Y' where id = '$gallery_id' ";   
                $db->send_cmd( $sql );
            }
        }
        //End

        $processResult = $result > 0 ? 1 : 8;
    }
	else if ( $method == "edit" )
    {
        
        $obj = new SystemConfig();
		$config = $obj->unserializeObj( "SystemConfig" );
		$editId = $_POST["editId"];

		$code = getCode( $db , $editId );
        
        $gallery_path = $config->getUploadPath().$code."/";
		rmFileInDir( $gallery_path );
        mkdir($gallery_path);
        
        tracefile_debug("gallery_init.php" , "Gallery Path is >> $gallery_path");

        //Upload file zip
        $zip = zip_open($_FILES["pics_file"]["tmp_name"]); // เปิดไฟล์ naxza.zip ด้วย zip lib
        if ($zip) { // เช็คว่าเปิดได้หรือเปล่า
            while ($zip_entry = zip_read($zip)) { // while loop เพื่ออ่านค่าใน zip ไฟล์
                $fp = fopen($gallery_path.zip_entry_name($zip_entry), "w"); // สร้าง folder naxza และนำชื่อไฟล์จากใน zip ไปสร้างไว้ใน folder
                if (zip_entry_open($zip, $zip_entry, "r")) { // อ่านค่าไฟล์ใน zip ขึ้นมา
                    $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)); //เก็บลงตัวแปร $buf
                    fwrite($fp,"$buf"); // ทำการเขียนลงไปในชื่อไฟล์ใน folder naxza
                    zip_entry_close($zip_entry); //ปิดการเปิดไฟล์ใน zip
                    fclose($fp); // ปิดการเขียนใน folder naxza
                }
                
            }
            zip_close($zip); // ปิดการเปิดไฟล์ zip

            $img_insqry = "insert into tb_b_gallery_items ( gallery_id , code , img_file  ) values ( '$editId' , '$code' ";
            $sortedData = array();
            $ii=0;
            foreach(scandir($gallery_path) as $file) {
                tracefile_debug("gallery_init.php" , "File name >> ".$file);
                if(filetype($gallery_path . $file)=="file") {
                    $sortedData[$ii++] = $img_insqry.",'$file')";
                }
            }
            
            $sql = "delete from tb_b_gallery_items where gallery_id = '$editId' ";
			$db->send_cmd( $sql );

            $insert_result = 0;
            for ($ii=0;$ii<count($sortedData);$ii++)
            {
                $db->send_cmd($sortedData[$ii]);
                tracefile_debug("gallery_init.php" , "Insert Gallery item >> ".$sortedData[$ii]);
            }
            
            $result = $db->affected_rows();
            
        }
        //End

        $processResult = $result > 0 ? 1 : 8;
    }
    else if ( $method == "active_record" )
    {
        tracefile_debug("gallery_init.php" , "Update active >> $method");
        //$sql = "update tb_b_gallery set status = 'N'";
        //$db->send_cmd( $sql );
        
        tracefile_debug("gallery_init.php" , "Inactive sql >> $sql");
        
        $id = $_POST["editId"];
        
        $sql = "update tb_b_gallery set status = if (status = 'Y' , 'N', 'Y') where id = '$id' ";
        $db->send_cmd( $sql );
        tracefile_debug("gallery_init.php" , "Active sql >> $sql");
        $result = $db->affected_rows();
        $processResult = $result > 0 ? 1 : 8;
    }
    
	include "processresult_bar.php";
      
    
	?>
</thead> 
<tbody> 
	<?php
	
	//Prepare condition before query data
	$condition =  "where 1=1 order by status desc ";
	try
	{
		//Get no of page to do paging
		$noOfPage = $dataTable->getPageCount( $db ,  "tb_b_gallery" , $condition , $recPerPage );

		//Prepare column display on datatable
		$colArray = array( "id" ,  "title_th" , "status", "img_file" );
		$colNameArray = array(  "img_file" ,"title_th" , "status" , "action" );
		$colDescArray = array( "รูปอัลบั้ม" ,"ชื่ออัลบั้ม" , "เปิดใช้งาน" ,  "Action" );
		$colTypeArray = array( "img" , "text" , "text" , "action-A|E|D" );
        $colAlignArray = array( "center" , "center" , "center" , "center" );

		//Get data for data table
		$data =  $dataTable->getData( $db ,  "tb_b_gallery" , $condition , $colArray ) ;
		
		echo $dataTable->genHeader( $colDescArray );
		echo $dataTable->genDetail( $colNameArray , $colTypeArray , $data , $colAlignArray );

		include "paging.php";
	}
	catch(Exception $e)
	{
		echo "<tr><td colspan = \"25\">".$e->getMessage()."</td></tr>";
	}
	?>

	<!--tr> 
		<!--td colspan = "5"><input type = "button" value = " กำหนดการใช้งาน " onclick = "changeActive()"></td>
	</tr> -->
</tbody> 
</table>
<input type = "hidden" name = "deleteId" id = "deleteId" >
<input type = "hidden" name = "editId" id = "editId" >
<input type = "hidden" name = "TABLENAME" id = "TABLENAME" value="tb_b_gallery">