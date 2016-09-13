<?php
	$hotspot = $_POST["hotspot"];
	$graphType = $_POST["graphType"];
	
	$sql = "select hotspot_ipaddress,hotspot_dns from tb_b_hotspot where id = '$hotspot' ";
	//echo $sql;
	$db->send_cmd($sql);
	$rs = $db->get_result();

	$iframeSrc = empty( $rs["hotspot_dns"] ) ? $rs["hotspot_ipaddress"] : $rs["hotspot_dns"] ;
	$defalutGraphType = empty( $graphType ) ? "" : $graphType;
	
?>


<table class="tablesorter" cellspacing="0" width = "100%"> 
	<thead>
		<tr>
			<td colspan = "25">
				<select name = "graphType" id = "graphType" onchange= "localSubmitForm(new Array(),new Array())">
					<option value = "">เลือก Graph</option>
					<?php
					$sql = "select * from tb_b_hotspot_graph where hotspot_id = '$hotspot' ";
					$db->send_cmd($sql);
					while ($row=$db->get_result())
					{
						$defalutGraphType = empty( $graphType ) && $row["default_flag"] == "Y" ? $row["graph_path"] : $defalutGraphType;
					?>
					<option value = "<?=$row["graph_path"]?>"  <?=$graphType==$row["graph_path"] ? "selected":""?>><?=$row["graph_name"]?></option>
					<?php
					}
					?>
				</select>
			</td>
		</tr>
	</thead>
	<tbody> 
		
		<tr> 
			<td align = "center" colspan = "25" height = "1200" valign = "top">
				 <iframe src="<?=$iframeSrc?><?=$defalutGraphType?>/" frameborder="0" width = "100%" height = "98%" scrolling="yes"></iframe>
			</td>
		</tr> 
		
		<tr> 
			<td colspan = "25"><?//=$sql?></td> 
		</tr>  
		<tr> 
			<td colspan = "25" align = "left"></td> 
		</tr>  
	</tbody> 
</table>
