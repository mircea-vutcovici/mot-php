<?
session_start();
$host="mdk";
$FTP_stream=ftp_connect($host);
if($FTP_stream){
	if(ftp_login($FTP_stream,"anonymous","apache@sweet.c7.utcluj.ro")){
		echo "M-am conectat la $host<br>\n";
		print_r(ftp_rawlist($FTP_stream,"/Desene animale/Tarzan"));
	}else{
		print_r(ftp_rawlist($FTP_stream,"/Desene animale/Tarzan"));
		echo "Login failed @$host<br>\n";
	}
	ftp_quit($FTP_stream);
}else{
	echo "$host nu are FTP";
}
?>
<hr>
<?
echo zend_logo_guid();
echo "<br>SID=".SID;
?>
