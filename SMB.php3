<?
//error_reporting(7);
setcookie("UltimaVizita",time(),time()+3600*24*365);
setcookie("NumarulDeVizite",$NumarulDeVizite+1,time()+3600*24*365);

include("functions.php3");

?>
<html><head>
<meta name="author" content="Mircea Vutcovici">
<?$SMB_URL=stripslashes(rawurldecode($SMB_URL));?>
<title>SMB: <?echo "$SMB_URL"?></title>
</head><body>

<?
print date("d/M/Y h:i",$UltimaVizita);
echo "<br>";
print "<pre>SMB_URL=$SMB_URL</pre>";
print "NumarulDeVizite=$NumarulDeVizite<br>";
print "In SUPER constructie!!!!!<br>";
$x=!$SMB_URL;
//print ("Tipul pentru x=$x este:" . gettype($x) . "<br>");
// TODO: Vezi ce face isset() eregi()....reg-ex
?>

<form method="GET" action="SMB.php3">
Scrieti SMB URL in forma <code>\\host\share\dir</code> <br>(unde doar
<code>host</code> este necesar):<br>
<input type="text" name="SMB_URL" value="<?echo $SMB_URL?>" size=100>
<!--  <input type="submit" value="Arata smb-ul"> -->
</form>

<?if(!$SMB_URL): ?>
<?else:
$arra=explode("\\",$SMB_URL);
if($arra[0]||$arra[1]){
	echo ('<B>EROARE:</B> Formatul nu este <B>\\\\</b>host\\share<br>');
	die;
} else {
	if (sizeof($arra)<4){
		echo "<pre>";
		System("smbclient -L " . EscapeShellCmd("$arra[2]") . "|grep Disk");
		echo "</pre>";
	}else{
		//print list_array($arra);
		$deex=EscapeShellCmd($arra[2]);
		$nmb=explode("\n",`nmblookup $deex`);
		$hostlin=$nmb[1];
		$hostarr=explode(" ",$hostlin);
		$host=$hostarr[0];
		if ($host=="name_query") {
			print "<b>Nu pot sa rezolv numele!!!</b>";
			die;
		}else{
			echo "<p>";
			echo "Host=$host";
		}
		br();
		echo "<pre>";
		for($a=4;$a<sizeof($arra);$a++){
			$dir=$dir . "/" . $arra[$a];
		}
		System("smbclient //\"" . EscapeShellCmd("$arra[2]/$arra[3]") . "\" -c 'cd \"". EscapeShellCmd($dir) . "\"; dir '|grep '^  '" );
		echo "</pre><hr>";
		exec("smbclient //\"" . EscapeShellCmd("$arra[2]/$arra[3]") . "\" -c 'cd \"". EscapeShellCmd($dir) . "\"; dir ' 2>/dev/null|grep '^  '|sed 's/^  //'|sed 's/ [0-9]\{1,\}  [MTWFS][ouehra][nsitued] .*//'",$SMB_dir,$ret );
		//exec("smbclient //\"" . EscapeShellCmd("$arra[2]/$arra[3]") . "\" -c 'cd \"". EscapeShellCmd($dir) . "\"; dir ' |grep '^  '",$SMB_dir,$ret );
		list_array($SMB_dir);
// Trebuie folosit split-ul.
		br();
		echo $SMB_dir;br();
		echo (sizeof($arra));
	}
}
endif;
?>

<?include("data.php3")?>
</body></html>
