<?php
	$method = $_POST["method"];

	if ($method == "delete")
	{
		$id =  $_POST["killsession"];
		
		$sql = "update radacct set package_status = 'N' where radacctid = '$id' ";
		$result = $db->send_cmd($sql);

	}
	
	$date = $_POST["date"];
	$start_time = $_POST["start_time"];
	$end_time = $_POST["end_time"];
?>
<!--  -->
<script type="text/javascript">
<!--
	
//-->
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
      google.load("visualization", "1.1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
		<?php
		$criteria_date = !empty($date) ? " STR_TO_DATE('".$date."','%d/%m/%Y')" : "now()";
		$start_t = empty( $start_time ) ? 0 : $start_time;
		$end_t = empty( $end_time ) ? 24 : $end_time;
		$sql = " select 'X' ";
		for ($ii=$start_t;$ii<$end_t ;$ii++ )
		{
			$start = $ii<=9? "0".$ii : $ii;
			$end = $ii<=8? "0".($ii+1) : $ii+1;
			$field_name = $ii == 23 ? "00" : $end;
			$sql .= " ,";
			$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('".$start.":00:01' as time) and cast('".$end.":00:00' as time) $hotspot_clause) cnt_".$field_name;
		}
		/*$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('01:00:01' as time) and cast('02:00:00' as time) $hotspot_clause) cnt_02 ";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('02:00:01' as time) and cast('03:00:00' as time) $hotspot_clause) cnt_03 ";
		$sql .= " ,";
		$sql .= " (select count(*) from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('03:00:01' as time) and cast('04:00:00' as time) $hotspot_clause) cnt_04";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('04:00:01' as time) and cast('05:00:00' as time) $hotspot_clause) cnt_05";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('05:00:01' as time) and cast('06:00:00' as time) $hotspot_clause) cnt_06";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('06:00:01' as time) and cast('07:00:00' as time) $hotspot_clause) cnt_07";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('07:00:01' as time) and cast('08:00:00' as time) $hotspot_clause) cnt_08";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('08:00:01' as time) and cast('09:00:00' as time) $hotspot_clause) cnt_09";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('09:00:01' as time) and cast('10:00:00' as time) $hotspot_clause) cnt_10";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('10:00:01' as time) and cast('11:00:00' as time) $hotspot_clause) cnt_11";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('11:00:01' as time) and cast('12:00:00' as time) $hotspot_clause) cnt_12";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('12:00:01' as time) and cast('13:00:00' as time) $hotspot_clause) cnt_13";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('13:00:01' as time) and cast('14:00:00' as time) $hotspot_clause) cnt_14";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('14:00:01' as time) and cast('15:00:00' as time) $hotspot_clause) cnt_15";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('15:00:01' as time) and cast('16:00:00' as time) $hotspot_clause) cnt_16";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('16:00:01' as time) and cast('17:00:00' as time) $hotspot_clause) cnt_17";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('17:00:01' as time) and cast('18:00:00' as time) $hotspot_clause) cnt_18";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('18:00:01' as time) and cast('19:00:00' as time) $hotspot_clause) cnt_19";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('19:00:01' as time) and cast('20:00:00' as time) $hotspot_clause) cnt_20";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('20:00:01' as time) and cast('21:00:00' as time) $hotspot_clause) cnt_21";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('21:00:01' as time) and cast('22:00:00' as time) $hotspot_clause) cnt_22";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('22:00:01' as time) and cast('23:00:00' as time) $hotspot_clause) cnt_23";
		$sql .= " ,";
		$sql .= " (select count(*)  from account a,radacct b where a.username = b.username and DATE(".$criteria_date.") = DATE(acctstarttime) and cast( date_format(acctstarttime,'%H:%i:%S') as time) between cast('23:00:01' as time) and cast('23:59:59' as time) $hotspot_clause) cnt_00 ";
		*/
		$sql .= " FROM nas limit 0,1 ";
		//Paging

		//End paging
		//echo $sql;
		$db->send_cmd($sql);
		while ($row=$db->get_result())
		{
			echo "['เวลา', 'จำนวนผู้ใช้งาน'],";
			for ($ii=$start_t;$ii<$end_t ;$ii++ )
			{
				//$field_name = $ii<=9? "0".$ii : $ii;
				$start = $ii<=9? "0".$ii : $ii;
				$end = $ii<=8? "0".($ii+1) : $ii+1;
				$field_name = $start;//$ii == 23 ? "00" : $start;

				if ($ii < ($end_t - 1))
				{
		?>
					['<?=$field_name?>:00', <?=$row["cnt_".$field_name]==null ? 0 : $row["cnt_".$field_name]?>],
		<?php
				}
				else
				{
		?>
					['<?=$field_name?>:00', <?=$row["cnt_".$field_name]==null ? 0 : $row["cnt_".$field_name]?>]
		<?php
				}
			}
		}
		?>
        ]);

        var options = {
          title: 'จำนวนผู้ใช้งาน',
          hAxis: {title: 'เวลา',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>

<table class="tablesorter" cellspacing="0" width = "100%"> 
<thead> 
	<tr>
		<td colspan = "20">
		วันที่ : <input type = "text" name = "date" id = "date" class = "tcal" value = "<?=$date?>">
		 &nbsp;&nbsp;
		เริ่มเวลา : &nbsp;&nbsp;
					<select name = "start_time" id = "start_time" >
						<option value = "">None</option>
						<?php
						for($ii=0;$ii<24;$ii++)
						{
							$time = $ii<=9 ? "0".$ii : $ii;
						?>
						<option value = "<?=$ii?>" <?=$ii == $start_time ? "selected" : ""?> ><?=$time?></option>
						<?php
						}//Close generate hotspot list
						?>
					</select>
			&nbsp;&nbsp;
		- ถึงเวลา : &nbsp;&nbsp;
					<select name = "end_time" id = "end_time" >
						<option value = "">None</option>
						<?php
						for($ii=0;$ii<24;$ii++)
						{
							$time = $ii<=9 ? "0".$ii : $ii;
						?>
						<option value = "<?=$ii?>" <?=$ii == $end_time ? "selected" : ""?> ><?=$time?></option>
						<?php
						}//Close generate hotspot list
						?>
					</select>
			&nbsp;&nbsp;<img src="images/icn_search.png" onclick = "localSubmitForm(new Array(),new Array())">
		</td>
	</tr>
</thead> 
<tbody> 
	
	<tr> 
		<td align = "center" colspan = "25">
			<div id="chart_div" style="width:900; height:500"></div>
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
<input type = "hidden" name="deleteId" id = "deleteId" >
<input type = "hidden" name="editId" id = "editId" >