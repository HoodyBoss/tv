		<?php
		if (!empty($hotspot_flag))
		{
		?>
		&nbsp;&nbsp;&nbsp;&nbsp;TV Station : &nbsp;&nbsp;
		 <select name = "hotspot_id" id = "hotspot_id" onchange = "localSubmitForm(new Array('hotspot'),new Array(this.value))">
				<option value = "">None</option>
				<?php
				//Generate hotspot list into select list

				for ($ii=0;$ii<count($user_hotspotid_array);$ii++)
				{
					$default_hostpot = empty($hotspot) && $ii==0 ? $user_hotspotid_array[$ii] : $hotspot;
				?>
				<option value = "<?=$user_hotspotid_array[$ii]?>" <?=$user_hotspotid_array[$ii] == $hotspot ? "selected" : $ii==0 ? "selected" : "" ?> ><?=$user_hotspotname_array[$ii]?></option>
				<?php
				}//Close generate hotspot list
				?>
			</select> 
		<?php
		}
		?>
		<hr/>
		<h3>Site Setup</h3>
			<ul class="toggle">
		<?php
		if (isset($_SESSION["login_user_type"]) && ($_SESSION["login_user_type"]=="ADMIN_SITE_SUPER" || $_SESSION["login_user_type"]=="ADMIN_SUPER"))
		{
		?>
			  <li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'hotspot' , 'init' , 'TV Station' ))">TV Station</a></li>
			  <!--<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'siteuser' , 'init' , 'Manage User' ))">Manage User</a></li>
			  <li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'backupuser' , 'init' , 'Backup User' ))">Backup User</a></li> -->
		<?php
		}
		else
		{
		?>
				<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'changepassword' , 'new' , 'เปลี่ยนรหัสผ่าน' ))">เปลี่ยนรหัสผ่าน</a></li>
		<?php
		}
		?>
		<?php
		if (isset($_SESSION["login_user_type"]) && $_SESSION["login_user_type"]=="LANGUAGE")
		{
		?>
		<h3>จัดการเนื้อหา</h3>
		<ul class="toggle">
			<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'news' , 'init' , 'จัดการข้อมูล ข่าวสารประชาสัมพันธ์' ))">จัดการข้อมูล ข่าวสารประชาสัมพันธ์</a></li>
			<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'shortmsg' , 'init' , 'จัดการข้อมูล ข่าวสั้น' ))">จัดการข้อมูล ข่าวสั้น</a></li>
		</ul>
		<!-- <h3>จัดการข้อมูลพื้นฐาน</h3>
			<ul class="toggle">
				<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'multilanguage' , 'init' , 'Manage Multilanguage' ))">Manage Multilanguage</a></li>
			</ul> -->
		<?php
		}
		else if (isset($_SESSION["login_user_type"]) && $_SESSION["login_user_type"]=="SITE_STAFF")
		{
		?>
		<h3>จัดการเนื้อหา</h3>
		<ul class="toggle">
			<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'news' , 'init' , 'จัดการข้อมูล ข่าวสารประชาสัมพันธ์' ))">จัดการข้อมูล ข่าวประชาสัมพันธ์</a></li>
			<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'shortmsg' , 'init' , 'จัดการข้อมูล ข่าวสั้น' ))">จัดการข้อมูล ข่าวสั้น</a></li>
		</ul>
		<!-- <h3>จัดการข้อมูลพื้นฐาน</h3>
			<ul class="toggle">
				<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'user_management' , 'init' , 'Manage User Account' ))">Manage User Account</a></li>
			</ul> -->
		<?php
		}
		else
		{
		?>
			</ul>
		<h3>จัดการเนื้อหา</h3>
		<ul class="toggle">
			<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'news' , 'init' , 'จัดการข้อมูล ข่าวสารประชาสัมพันธ์' ))">จัดการข้อมูล ข่าวประชาสัมพันธ์</a></li>
			<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'shortmsg' , 'init' , 'จัดการข้อมูล ข่าวสั้น' ))">จัดการข้อมูล ข่าวสั้น</a></li>
		</ul>
		<h3>จัดการข้อมูลพื้นฐาน</h3>
		<ul class="toggle">
			 <li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'tvchannel' , 'init' , 'จัดการข้อมูลช่องโทรทัศน์' ))">จัดการข้อมูลช่องโทรทัศน์</a></li> 
			<!-- <li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'user_management' , 'init' , 'Manage User Account' ))">Manage User Account</a></li>
			<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'multilanguage' , 'init' , 'Manage Multilanguage' ))">Manage Multilanguage</a></li> -->
		</ul>
		<!-- <h3>ข้อมูลการใช้งาน</h3>
		<ul class="toggle">
			 <li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'onlineuser' , 'init' , 'รายชื่อ Online' ))">รายชื่อ Online</a></li>
			<li class="icn_new_article"><a href="javascript: localSubmitForm(new Array( 'menu', 'status' , 'desc' ),new Array(  'hotspot' , 'graphmonitoring' , 'Graph' ))">Hotspot Monitoring</a></li>
		</ul> -->
		<?php
		}
		?>
		<footer>
			<hr />
			<p><strong>Copyright &copy; 2011 Website Admin</strong></p>
			<p>Theme by <a href="http://www.medialoot.com">MediaLoot</a></p>
		</footer>