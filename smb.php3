<?
$tim=time();
header("Expires: " . gmdate("D, d M Y H:i:s",$tim+3600) . " GMT");
header("Cache-Control: cache");
header("Pragma: cache");

require("functions.php3");
?>
<html>
 <head>
  <title>Index al share-urilor active</title>
 </head>
 <body>
<?include("ruler.php")?>
<!--
Sursele sunt sunt sub licenta GNU GPL. :)  ... la sfatul lui Jack.
-->
<center><h1>Index al ftp-urilor si share-urilor active</h1></center>
<?
//die;
?>



<p>Aveti de asteptat cateva minute (2-10) pentru a scana reteaua.</p>
<p>
Pentru rezolvarea numelor prin DNS am nevoie ca mdk-ul sa fie UP: 
<?flush();
passthru("/usr/local/sbin/fping -A 172.27.32.1 >/dev/null",$mdk_down);if($mdk_down)print(" <b>nu</b> ");
?>
este UP. </p>
<?
flush();
$data1=time();
?>
<p><font size=-1>Link-urile de SMB mergeau doar in win in MSIE 4 sau mai mare. Acum ma chinui
sa fac sa mearga din orice SO si din orice browser
(adica fac un gateway SMB==&gt;HTTP).
</font></p>
<p>
O perioada nu a mers aceasta pagina. Scosesem dreptul de executie pe smbclient... masura era special dedicata
lui Stefan@hagi stie el pentru ce :-) Sau nu?!!
</p>
<?
flush();
//Vezi ca-ti baga un enter in plus!!
$SMB_hosts=explode("\n",`nmap -p 139 172.27.32-33.1-254|grep -v closed|grep :|cut -d\\( -f2|cut -d\\) -f1`);
echo "<p><font size=+1><b>Am gasit ".(sizeof($SMB_hosts)-1)." calculatoare cu SMB.</b></font></p>\n";
print("<ol>\n");
for($a=0;$a<sizeof($SMB_hosts)-1;$a++)
{
	$name=`nmblookup -A $SMB_hosts[$a]|grep '<00> - [^<]'|awk '{print $1}'`;
	if(!(trim($name)||$mdk_down)){
		$name=`nslookup $SMB_hosts[$a]|grep Name:|awk '{print $2}'|cut -d. -f1`;
	}
	echo " <li><font size=+1>".trim($name)." &nbsp;&nbsp;&nbsp; ($SMB_hosts[$a])</font><br>\n";
	flush();
	if(trim($name)){
		$SMB_sh=`smbclient -L $name -N|grep Disk|awk 'BEGIN{FS="Disk"}{print $1}'`;
		$SMB_sh=str_replace("\t","",$SMB_sh);
		$SMB_shares=split("\n",$SMB_sh);
		list_array($SMB_shares);
		for($b=0;$b<sizeof($SMB_shares);$b++) {
			if(ereg("[ ]*Disk.*$",$SMB_shares[$b])) {
				$share=ereg_replace("[ ]*Disk.*$","",$SMB_shares[$b]);
				$comment=ereg_replace("^.*Disk[ ]*","",$SMB_shares[$b]);
				$name=trim($name);
				$share=trim($share);
				$URL_smb=rawurlencode("\\\\".$name."\\".$share."\\");
				echo "  <a href=\"SMB.php3?SMB_URL=$URL_smb\">\\\\$name\\$share\\</a>  $comment<br>\n";
				flush();
			}
		}
	}
	echo "</li>\n";
	$name="";
}
print "</ol>";
$data2=time();
$delta=$data2-$data1;
$arra=getdate($delta);
echo "<p>Scanarea a durat $arra[minutes] minute si $arra[seconds] secunde.</p>\n"
?>
<?include("data.php3")?>
 </body>
</html>
