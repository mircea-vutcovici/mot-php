<?
$tim=time();
header("Expires: " . gmdate("D, d M Y H:i:s",$tim+3600) . " GMT");
header("Cache-Control: cache");
header("Pragma: cache");

require("functions.php3");
?>
<html>
 <head>
  <title>Index al paginilor de web active</title>
 </head>
 <body>
<?include("ruler.php")?>
<!--
Sursele sunt sunt sub licenta GNU GPL. :)  ... la sfatul lui Jack.
-->
<center><h1>Paginile de Web active</h1></center>
<p>Aveti de asteptat cateva minute (1-3) pentru a scana reteaua.</p>
<?
$DNS_down=dnsdown();
flush();
$data1=time();

$HTTP_hosts=explode("\n",`nmap -p 80 172.27.32,33.1-254|grep -v closed|grep :|cut -d\\( -f2|cut -d\\) -f1`);
?>
<p><font size=+1><b>Am gasit <?print (sizeof($HTTP_hosts)-1)?> servere de HTTP.</b> </font></p>
<ol> 
<?
flush();
for($a=0;$a<sizeof($HTTP_hosts)-1;$a++){
	if(!$DNS_down){
		$name=`nslookup $HTTP_hosts[$a]|grep Name:|awk '{print $2}'`;
	}
	if(!trim($name)){
		$name=`nmblookup -A $HTTP_hosts[$a]|grep '<00> - [^<]'|awk '{print $1}'`;
	}
	$name=trim($name);
	if(!$name){
		$name=$HTTP_hosts[$a];
	}
	echo " <li><a href=\"http://$HTTP_hosts[$a]/\">http://$name/</a><br></li>\n";
	flush();
	$name="";
}
?>
</ol>
<?
$data2=time();
$delta=$data2-$data1;
$arra=getdate($delta);
echo "<p>Scanarea a durat $arra[minutes] minute si $arra[seconds] secunde.</p>";
include("data.php3")?>
 </body>
</html>
