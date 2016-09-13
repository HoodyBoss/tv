<?php
	$sql = "select short_msg_th from tb_b_shortmsg where status = 'Y' order by id desc limit 0,5";
	$db->send_cmd($sql);
	//echo $sql;
	$rnd=0;
	while($row = $db->get_result())
	{
		$short_msg_th .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$row["short_msg_th"];
		$rnd++;
	}
?>
<marquee id = "shortMsgTxt" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();"><?=$short_msg_th?></marquee>