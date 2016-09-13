<?php
	$username= $_REQUEST["username"];
	$password= $_REQUEST["password"];
	$expiredate= $_REQUEST["expiredate"];
?>
<table width = "100%" align = "left"   >
<tr>
	<td>
		<table width = "100%">
			<tr>
				<td><font size="2">Username : <?=$username?></font></td>
			</tr>
			<tr>
				<td><font size="2">Password : <?=$password?></font></td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td colspan = "2"><font size="2">Expire in <?=$expiredate?></font></td>
</tr>
</table>
<script>
	/*function printMe() {
		alert("1");
	  window.print();
	}*/
	window.print();
</script>