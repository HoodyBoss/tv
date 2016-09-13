<tr> 
	<td align="right" colspan = "15">แสดง 
		<select name = "recPerPageOpt" onchange = "localSubmitForm( new Array('recordPerPage','groupPage') , new Array(this.options[this.selectedIndex].value,'0'))">
			<option value = "10" <?=$recordPerPage==10?"selected":""?>>10</option>
			<option value = "20" <?=$recordPerPage==20?"selected":""?>>20</option>
			<option value = "50" <?=$recordPerPage==50?"selected":""?>>50</option>
			<option value = "100" <?=$recordPerPage==100?"selected":""?>>100</option>
		</select>
		&nbsp;&nbsp;Page : &nbsp;&nbsp;
		
		<?php
			$groupPageLimit = 10;

			$startPage = 1;
			$endPage = ($noOfPage>$groupPageLimit) ? $groupPageLimit : $noOfPage;
			
			if ($groupPage != 0 && $noOfPage>$groupPageLimit)
			{
				$startPage = ($groupPage*$groupPageLimit)+1;
				$endPage = (($groupPage*$groupPageLimit)+$groupPageLimit) > $noOfPage ? $noOfPage : ($groupPage*$groupPageLimit)+$groupPageLimit;
		?>
		<a href = "javascript: localSubmitForm( new Array('pageNumber','groupPage') , new Array('1','0') )"> First </a>
		&nbsp;&nbsp;<a href = "javascript: localSubmitForm( new Array('groupPage','pageNumber') , new Array('<?=$groupPage-1?>','<?=(($groupPage-1)*$groupPageLimit)+1?>'))"> &lt;&lt; </a>&nbsp;&nbsp;
		<?php
			}
		?>
		<?php
		//Paging
		for ($ii=$startPage;$ii<=$endPage;$ii++)
		{
			if ($pageNumber != $ii)
			{
				echo "&nbsp;<a href = \"javascript: localSubmitForm( new Array('pageNumber') , new Array('".$ii."'))\">".$ii."</a>&nbsp;"; 
			}
			else
			{
				echo "&nbsp;".$ii."&nbsp;"; 
			}
		}
		?>
		<?php
			if ($groupPage < floor($noOfPage/$groupPageLimit) && $noOfPage>$groupPageLimit)
			{
		?>
		&nbsp;&nbsp;<a href = "javascript: localSubmitForm( new Array('groupPage','pageNumber') , new Array('<?=$groupPage+1?>','<?=(($groupPage+1)*$groupPageLimit)+1?>'))"> &gt;&gt; </a>
		&nbsp;&nbsp;<a href = "javascript: localSubmitForm( new Array('pageNumber','groupPage') , new Array('<?=$noOfPage?>','<?=floor($noOfPage/$groupPageLimit)?>'))"> Last </a>
		<?php
			}
		?>
		
	</td> 
</tr> 
<input type = "hidden" name = "recordPerPage" id = "recordPerPage" value = "<?=$recordPerPage?>">
<input type = "hidden" name = "pageNumber" id = "pageNumber" value = "<?=$pageNumber?>">
<input type = "hidden" name = "groupPage" id = "groupPage" value = "<?=$groupPage?>"> 