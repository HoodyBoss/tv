
<script type="text/javascript">
<!--
	function displayPSF(workCode , no )
	{
		if (no == "1")
		{
			window.open("aps01-pdf.php?workCode="+workCode,"psf01excel","height=1000,width=1200,resizable=yes,scrollbars=yes,toolbar=yes");
		}
		else if (no == "7")
		{
			window.open("aps07-pdf.php?workCode="+workCode,"psf07excel","height=1000,width=1200,resizable=yes,scrollbars=yes,toolbar=yes");
		}
		else if (no == "5")
		{
			window.open("aps05-pdf.php?workCode="+workCode,"psf05excel","height=1000,width=1200,resizable=yes,scrollbars=yes,toolbar=yes");
		}
	}

	function enterKey()
	{
		//alert(window.event.keyCode);
		var keyCode = window.event.keyCode;
		if (keyCode==13)
		{
			localSubmitForm(new Array('1','design-downloaddocument'),new Array('page','menu_type'));
		}
	}
//-->
</script>
			<article class="module width_3_quarter">
			<header><h3 class="tabs_involved">Download เอกสาร</h3>
			<!-- <ul class="tabs">
				<li><a href="#tab1">Posts</a></li>
				<li><a href="#tab2">Comments</a></li>
			</ul> -->
			</header>

			<div class="tab_container">
				<table width = "100%">
					<tr>
						<td width = "33%" align = "center">
							<a href = "aps01.pdf"><h2>APF01</h2></a>
						</td>
						<td width = "33%" align = "center">
							<a href = "aps07.pdf"><h2>APF07</h2></a>
						</td>
						<td width = "33%" align = "center">
							<a href = "APS05.pdf"><h2>APF05</h2></a>
						</td>
					<tr>
			</div><!-- end of .tab_container -->
			
			</article><!-- end of content manager article -->
			<br>

			<br>
			<article class="module width_3_quarter">
			<header><!-- <h3 class="tabs_involved">Download เอกสาร</h3> -->
			<!-- <ul class="tabs">
				<li><a href="#tab1">Posts</a></li>
				<li><a href="#tab2">Comments</a></li>
			</ul> -->
			</header>

			<div class="tab_container">
				<!-- <div id="tab3" class="tab_content"> -->
				<table class="tablesorter" cellspacing="0"> 
					<thead> 
						<tr>
							<td colspan = "20">
							ค้นหา : &nbsp;&nbsp;<input type = "text" name = "quicksearch" onkeypress = "enterKey()" id = "quicksearch" value = "<?=$_POST["quicksearch"]?>" onfocus="this.value=''">&nbsp;&nbsp;<img src="images/icn_search.png" onclick = "localSubmitForm(new Array('1','design-downloaddocument'),new Array('page','menu_type'))">
							</td>
						</tr>
						<tr> 
							<td align = "center"><b>จังหวัด</b></td> 
							<td align = "center"><b>รหัสจัดทำใบสั่งงาน</b></td> 
							<td align = "center"><b>รหัส</b></td> 
							<td align = "center"><b>วันที่</b></td> 
							<td align = "center"><b>ชื่อ</b></td>
							<td align = "center"><b>Email</b></td>
							<td align = "center"><b>เอกสาร (PDF)</b></td> 
						</tr> 
					</thead> 
					<tbody> 
						<?
							$quicksearch = $_POST["quicksearch"];
							//Pagecount
							$recordPerPage = empty($_POST["recordPerPage"]) ? 10 : $_POST["recordPerPage"];
							$pageNumber = empty($_POST["pageNumber"]) ? 1 : $_POST["pageNumber"];
							$groupPage = empty($_POST["groupPage"]) ? 0 : $_POST["groupPage"];

							$sql = "SELECT ceil( count(*)/$recordPerPage ) ";
							$sql .= " from t_work_hdr where  work_status in ('D','E','F','K','T') ";
							if ( !in_array( $_SESSION["user_type"] ,  $adminUser ) && !in_array( $_SESSION["user_type"] ,  $adminSupervisor ))
							{
								//$sql .= " and province_tot = '$province_tot'";
								//$sql .= " and create_by = '$username'";
								if ( in_array( $_SESSION["user_type"] ,  $vendorUser ))
								{
									$sql .= " and vendor = (select id from t_subvendor where code = '$username')";
								}
								else if ( in_array( $_SESSION["user_type"] ,  $contractorUser ))
								{
									//$sql .= " and vendor = (select id from t_subcontractor where code = '$username')";
									$sql .= " AND work_code IN (SELECT work_code FROM t_work_setup WHERE subcontractor IN ( SELECT id FROM t_subcontractor WHERE code ='$username' ))";
								}
								else
								{
									$sql .= " and province_tot = '$province_tot'";
								}
							}


							if (!empty($quicksearch))
							{
								$sql .= " and ( work_code like '%$quicksearch%' or permanent_code like '%$quicksearch%'  or province_tot in (select province_tot from province where province_name like  '%$quicksearch%' )) ";
							}
							//echo $sql."<br>+++++++++++++++++<br>";
							$db->send_cmd($sql);
							$noOfPage = 1;
							while ($row=$db->get_data())
							{
								$noOfPage = $row[0];
							}

							$sql = "SELECT work_code , date_format(work_date,'%d/%m/%Y') , workday , if (work_status='A','Created','') status ,'NORMAL' , work_detail  , permanent_code , (select province_name from province where province.province_tot = t_work_hdr.province_tot) province_name , (select email from user where user.username = t_work_hdr.create_by ) email, (select concat(firstname,' ' , lastname)   from user where user.username = t_work_hdr.create_by ) seniortech_name ";
							$sql .=",vendor_job_status , ext_job_status ,ifnull ( (select distinct job_status from t_work_setup_hdr where t_work_setup_hdr.work_code = t_work_hdr.work_code and job_status = 'A' ";
							if ( in_array( $_SESSION["user_type"] ,  $contractorUser ))
							{
								$sql .= " and contractor = '$username' ";
							}
							$sql .= " ) , 'I') contractor_job_status ";
							$sql .= " from t_work_hdr where work_status  in ('D','E','F','K','T') ";
							if ( !in_array( $_SESSION["user_type"] ,  $adminUser ) && !in_array( $_SESSION["user_type"] ,  $adminSupervisor ))
							{
								//$sql .= " and province_tot = '$province_tot'";
								//$sql .= " and create_by = '$username'";
								if ( in_array( $_SESSION["user_type"] ,  $vendorUser ))
								{
									$sql .= " and vendor = (select id from t_subvendor where code = '$username')";
								}
								else if ( in_array( $_SESSION["user_type"] ,  $contractorUser ))
								{
									//$sql .= " and vendor = (select id from t_subcontractor where code = '$username')";
									$sql .= " AND work_code IN (SELECT work_code FROM t_work_setup WHERE subcontractor IN ( SELECT id FROM t_subcontractor WHERE code ='$username' ))";

								}
								else
								{
									$sql .= " and province_tot = '$province_tot'";
								}
							}

							if (!empty($quicksearch))
							{
								$sql .= " and ( work_code like '%$quicksearch%' or permanent_code like '%$quicksearch%'  or province_tot in (select province_tot from province where province_name like  '%$quicksearch%' )) ";
							}
							
							$beginRec = ($pageNumber*$recPerPage)-$recPerPage;
							$sql .= " limit $beginRec,$recordPerPage";
							//echo $sql;
							$rec_found = false;

							$db->send_cmd($sql);
							while ($row=$db->get_result())
							{
								$rec_found = true;
								$vendor_job_status = $row["vendor_job_status"];
								$ext_job_status = $row["ext_job_status"];
								$contractor_job_status = $row["contractor_job_status"];

								$enableDoc = false;
								if ( !in_array( $_SESSION["user_type"] ,  $contractorUser ) && $vendor_job_status == "A")
									$enableDoc  = true;
								else if ( !in_array( $_SESSION["user_type"] ,  $vendorUser ) && $contractor_job_status == "A")
									$enableDoc  = true;
								else if ( $_SESSION["user_type"] != "EXT_ADMIN" && $ext_job_status == "A")
									$enableDoc  = true;
						?>
						<tr> 
							<td align = "left"><?=$row["province_name"]?></td> 
							<!-- <td><input type="checkbox"></td>  -->
							<td align = "center"><?=$row[0]?></td> 
							<td align = "center"><?=$row["permanent_code"]?></td> 
							<td align = "center"><?=$row[1]?></td> 
							<td align = "left"><?=$row["seniortech_name"]?></td> 
							<td align = "left"><?=$row["email"]?></td> 
							<!-- <td align = "center"><?=$row[3]?></td>  -->
							<td align = "center">
								<?//="".$contractor_job_status?>
								<a href = "javascript: displayPSF('<?=$row["work_code"]?>','1')" >APF01</a> 
								<?
									if ($enableDoc)
									{
								?>
								/ <a href = "javascript: displayPSF('<?=$row["work_code"]?>','7')" >APF07</a> 
								/ <a href = "javascript: displayPSF('<?=$row["work_code"]?>','5' , '<?=$username?>')" >APF05</a>
								<?
									}
								?>
							</td> 
							
							
						</tr> 
						<? 
								//$schoolcode_str .= "|".$row[0];
							}
							if ($rec_found)
							{
						?>
							<tr> 
								<td align="right" colspan = "15">แสดง 
									<select name = "recPerPageOpt" onchange = "localSubmitForm(new Array(this.options[this.selectedIndex].value,'0'),new Array('recordPerPage','groupPage'))">
										<option value = "10" <?=$recordPerPage==10?"selected":""?>>10</option>
										<option value = "20" <?=$recordPerPage==20?"selected":""?>>20</option>
										<option value = "50" <?=$recordPerPage==50?"selected":""?>>50</option>
										<option value = "100" <?=$recordPerPage==100?"selected":""?>>100</option>
									</select>
									&nbsp;&nbsp;Page : &nbsp;&nbsp;
									
									<?
										$groupPageLimit = 10;

										$startPage = 1;
										$endPage = ($noOfPage>$groupPageLimit) ? $groupPageLimit : $noOfPage;
										
										if ($groupPage != 0 && $noOfPage>$groupPageLimit)
										{
											$startPage = ($groupPage*$groupPageLimit)+1;
											$endPage = (($groupPage*$groupPageLimit)+$groupPageLimit) > $noOfPage ? $noOfPage : ($groupPage*$groupPageLimit)+$groupPageLimit;
									?>
									<a href = "javascript: localSubmitForm(new Array('1','0'),new Array('pageNumber','groupPage'))"> First </a>
									&nbsp;&nbsp;<a href = "javascript: localSubmitForm(new Array('<?=$groupPage-1?>','<?=(($groupPage-1)*$groupPageLimit)+1?>'),new Array('groupPage','pageNumber'))"> &lt;&lt; </a>&nbsp;&nbsp;
									<?
										}
									?>
									<?
									//Paging
									for ($ii=$startPage;$ii<=$endPage;$ii++)
									{
										if ($pageNumber != $ii)
										{
											echo "&nbsp;<a href = \"javascript: localSubmitForm(new Array('".$ii."'),new Array('pageNumber'))\">".$ii."</a>&nbsp;"; 
										}
										else
										{
											echo "&nbsp;".$ii."&nbsp;"; 
										}
									}
									?>
									<?
										if ($groupPage < floor($noOfPage/$groupPageLimit) && $noOfPage>$groupPageLimit)
										{
									?>
									&nbsp;&nbsp;<a href = "javascript: localSubmitForm(new Array('<?=$groupPage+1?>','<?=(($groupPage+1)*$groupPageLimit)+1?>'),new Array('groupPage','pageNumber'))"> &gt;&gt; </a>
									&nbsp;&nbsp;<a href = "javascript: localSubmitForm(new Array('<?=$noOfPage?>','<?=floor($noOfPage/$groupPageLimit)?>'),new Array('pageNumber','groupPage'))"> Last </a>
									<?
										}
									?>
									
								</td> 
							</tr> 
						<?
							}
							else
							{
						?>
						<tr> 
							<td align="center" colspan = "9"><font color = "red">Record not found!</font></td> 
						</tr> 
						<?
							}
						?>
					</tbody> 
				</table>

				<!-- </div> --><!-- end of #tab2 -->
				
			</div><!-- end of .tab_container -->
			
			</article><!-- end of content manager article -->
			
			<input type = "hidden" name = "workCode" id = "workCode">
			<input type = "hidden" name = "sentApproveFlag" id = "sentApproveFlag">
			<input type = "hidden" name = "recordPerPage" id = "recordPerPage" value = "<?=$recordPerPage?>">
			<input type = "hidden" name = "pageNumber" id = "pageNumber" value = "<?=$pageNumber?>">
			<input type = "hidden" name = "groupPage" id = "groupPage" value = "<?=$groupPage?>">
			<div class="clear"></div>
			
			<!-- <article class="module width_full">
				
				<div align ="right">
					<?
					if ($school_status=="A")
					{
					?>
					<input type = "submit" value = "    Save    " name = "save">	
					<?
					}
					else
					{
					?>
					<input type = "submit" value = "    Save Unplan    " name = "unplan" >	
					<?
					}
					?>
				</div>
			</article> --> <!-- end of post new article -->
			
			<div class="spacer"></div>
			