<?
function list_array( $array ) {
   $str="<br>";
   while ( list( $key, $value ) = each( $array ) ) {
          $str .= "<b>$key:</b> $value<br>\n";
   }
   return $str;
}
function br(){
        echo "<br>";
}

function dnsdown() {
	echo "<p>Pentru rezolvarea numelor prin DNS am nevoie ca mdk-ul sa fie pornit:";
	flush();
	//passthru("/usr/local/sbin/fping -A 172.27.32.1 >/dev/null",$mdk_down);
	passthru("/usr/sbin/arping -q -c1 -I eth0 172.27.32.1",$mdk_down);
	if($mdk_down)print(" <b>nu</b> ");
	echo "este pornit.\n";
	$DNS_down=0;
	if(!$mdk_down){
		echo "Si, de asemenea, sa mearga DNS-ul pe mdk:";
		passthru("nmap -p 53 172.27.32.1|grep -q :",$DNS_down);
		if($DNS_down)print(" <b>nu</b>");
		echo " merge.\n";
	}
	echo "</p>\n";
	return $DNS_down;
}

?>
