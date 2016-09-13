<?php
include "config/config.php";
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>จัดซื้อด้วยเงินจากการจำหน่ายอุปกรณ์เครื่องแต่งกายนักศึกษาปี ๒๕๕๓ - ๒๕๕๖</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.poptrox.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
			<link rel="stylesheet" href="css/style-normal.css" />
            <link href="fonts/thsarabunnew.css" rel="stylesheet" type="text/css" />
		</noscript>
        <script src="js/jquery-latest.pack.js" type="text/javascript"></script>
		<script src="js/jcarousellite_1.0.1c4.js" type="text/javascript"></script>
        <script type="text/javascript">
        $(function() {
            $(".newsticker-jcarousellite").jCarouselLite({
                vertical: true,
                hoverPause:true,
                visible: 3,
                auto:10000,
                speed:1000
            });
        });
        </script>

</head>
<body class="postnews" style="background-color:#FFF;">
			  <script type="text/javascript">
                
                /***********************************************
                * Memory Ticker script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
                * This notice MUST stay intact for legal use
                * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
                ***********************************************/
                
                //configure tickercontents[] to set the messges you wish be displayed (HTML codes accepted)
                //Backslash any apostrophes within your text (ie: I\'m the king of the world!)
                var tickercontents=new Array()
				<?php
				$sql = "select * from tb_b_news where status = 'Y' and show_date is not null order by show_date desc limit 0,4";
				$db->send_cmd($sql);
				$ii=0;
				while ($row=$db->get_result())
				{
				?>
                tickercontents[<?=$ii++?>]='<img src="backend/attachfiles/<?=$row["image"]?>"><span><?=$row["title_".$curLang]?></span>';
				<?php
				}
				?>

                var persistlastviewedmsg=1 //should messages' order persist after users navigate away (1=yes, 0=no)?
                var persistmsgbehavior="onload" //set to "onload" or "onclick".
                
                //configure the below variable to determine the delay between ticking of messages (in miliseconds):
                var tickdelay=10000
                
                ////Do not edit pass this line////////////////
                
                var divonclick=(persistlastviewedmsg && persistmsgbehavior=="onclick")? 'onClick="savelastmsg()" ' : ''
                var currentmessage=0
                
                function changetickercontent(){
                if (crosstick.filters && crosstick.filters.length>0)
                crosstick.filters[0].Apply()
                crosstick.innerHTML=tickercontents[currentmessage]
                if (crosstick.filters && crosstick.filters.length>0)
                crosstick.filters[0].Play()
                currentmessage=(currentmessage==tickercontents.length-1)? currentmessage=0 : currentmessage+1
                var filterduration=(crosstick.filters&&crosstick.filters.length>0)? crosstick.filters[0].duration*1000 : 0
                setTimeout("changetickercontent()",tickdelay+filterduration)
                }
                
                function beginticker(){
                if (persistlastviewedmsg && get_cookie("lastmsgnum")!="")
                revivelastmsg()
                crosstick=document.getElementById? document.getElementById("memoryticker") : document.all.memoryticker
                changetickercontent()
                }
                
                function get_cookie(Name) {
                var search = Name + "="
                var returnvalue = ""
                if (document.cookie.length > 0) {
                offset = document.cookie.indexOf(search)
                if (offset != -1) {
                offset += search.length
                end = document.cookie.indexOf(";", offset)
                if (end == -1)
                end = document.cookie.length;
                returnvalue=unescape(document.cookie.substring(offset, end))
                }
                }
                return returnvalue;
                }
                
                function savelastmsg(){
                document.cookie="lastmsgnum="+currentmessage
                }
                
                function revivelastmsg(){
                currentmessage=parseInt(get_cookie("lastmsgnum"))
                currentmessage=(currentmessage==0)? tickercontents.length-1 : currentmessage-1
                }
                
                if (persistlastviewedmsg && persistmsgbehavior=="onload")
                window.onunload=savelastmsg
                
                if (document.all||document.getElementById)
                document.write('<div id="memoryticker" '+divonclick+'></div>')
                if (window.addEventListener)
                window.addEventListener("load", beginticker, false)
                else if (window.attachEvent)
                window.attachEvent("onload", beginticker)
                else if (document.all || document.getElementById)
                window.onload=beginticker
                
                </script>
			</div>
            <!-- news -->
</body>
</html>