<?
error_reporting(5);
$tim=time();
header("Expires: " . gmdate("D, d M Y H:i:s",$tim+3600) . " GMT");
header("Cache-Control: cache");
header("Pragma: cache");

include("functions.php3");
?>
<html>
 <head>
  <title>Index al ftp-urilor active</title>
 </head>
 <body><?//background="#b0b0b0"?>
<?include("ruler.php")?>
<!--
Sursele sunt sunt sub licenta GNU GPL. :)  ... la sfatul lui Jack.
-->
<center><h2>Index al ftp-urilor active</h2></center>
<p>Aveti de asteptat cateva minute (2-5) pentru a scana reteaua.
<br>
Daca unele FTP-uri nu merg inseamna ca serverul respectiv de FTP nu accepta
<cite>anonymous login</cite> sau este depasit numarul de conexiuni sau de
useri <code>anonymous</code>.<br>
<?
$DNS_down=dnsdown();
flush();
$data1=time();
// Cei din caminul 5 filtreaza tot si nu pot sa vad nimic... :(
$FTP_hosts=explode("\n",`nmap -p 21 172.27.32.1-254 172.27.33.1-49,51-254|grep -v closed|grep :|cut -d\\( -f2|cut -d\\) -f1`);
?>
<table border> <caption><font size="+1"><b>Am gasit <?print (sizeof($FTP_hosts)-1)?> servere de FTP.</b></font></caption>
<tr><th>Nr.</th><th>Host</th><th>Suporta "<code>anonymous</code>" login?</th>
<?
flush();
for($a=0;$a<sizeof($FTP_hosts)-1;$a++){
	if(!$DNS_down){
		$name=`nslookup $FTP_hosts[$a]|grep Name:|awk '{print $2}'`;
	}
	if(!trim($name)){
		$name=`nmblookup -A $FTP_hosts[$a]|grep '<00> - [^<]'|awk '{print $1}'`;
	}
	$name=trim($name);
	if(!$name){
		$name=$FTP_hosts[$a];
	}
	$FTP_stream=ftp_connect($FTP_hosts[$a]);
	echo " <tr><td align=\"right\">".($a+1).".</td>";
	if($FTP_stream){
		if(ftp_login($FTP_stream,"anonymous","apache@sweet.c7.utcluj.ro")){
			echo "<td><a href=\"ftp://$FTP_hosts[$a]/\"><font size=\"+2\"><b>ftp://$name/</font></b></a></td><td align=\"center\"><font size=\"+3\"><b>DA</b></font></td>";
		}else{
			echo "<td><a href=\"ftp://$FTP_hosts[$a]/\">ftp://$name/</a></td><td align=\"center\">nu</td>";
		}
		ftp_quit($FTP_stream);
	}else{
		echo "<td><a href=\"ftp://$FTP_hosts[$a]/\">ftp://$name/</a></td><td align=\"center\">oprit/dezactivat</td>";
	}
	echo "</tr>\n";
	flush();
	$name="";
}
?>
</table>
<?
$data2=time();
$delta=$data2-$data1;
$arra=getdate($delta);
echo "<p>Scanarea a durat $arra[minutes] minute si $arra[seconds] secunde.</p>";
?>
<p>Php-ul interpreteaza cei "<cite>64Mb RAM</cite>" ai mdk-ului ca mesaj-eroare considera ca 
serverul nu-l lasa sa intre... de aceea mdk-ul apare cu "<code>nu</code>" la <code>anonymous</code>. <!-- Concluzie: daca
vreti sa nu va vad ca <code>anonymous</code> puneti serverul de ftp sa afiseze un fisier dupa logare care
sa contina o linie care sa inceapa cu un numar diferit de <code>2xx</code>. -->
</p>
<p>La cererea root-ului de pe matrix, acesta nu este cautat si, prin urmare, nu apare nici in lista.
</p>
<?
include("data.php3");
?>

