<?php
	if ($processResult != 9)
	{
?>
<tr> 
	<td colspan = "20" align = "left">
	<?php 
		$alert = new Alerts();
		if ($processResult == 1)
			echo $alert->success("Save successfully");
		else if ($processResult == 8)
		{
			$msg = "Process unsuccessful. Please try again.";
			if (!empty($errorMsg))
				$msg .= "[".$errorMsg."]";
			echo $alert->error($msg);
		}
		?>
	</td> 
</tr> 
<?php
	}
?>