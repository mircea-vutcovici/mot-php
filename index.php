<base href="http://sweet.c7.utcluj.ro/">
<html>
 <head>
  <title>Sweet FTP, HTTP, SMB scaner</title>
 </head>
 <body>
<?// bgcolor="white" text="black"?>
<?include("ruler.php")?>
<center><h1>FTP, HTTP, SMB scaner</h1>
</center>
<table BORDER CELLSPACING="2" CELLPADDING="2">
 <tr><th>Scopul scanarii</th><th>Observatii</th></tr>
 <tr><td align="center"><a href="ftp.php3">FTP</a></td><td>Servere de FTP.</td></tr>
 <tr><td align="center"><a href="http.php3">HTTP</a></td><td>Serverele de web.</td></tr>
 <tr><td align="center"><a href="smb.php3">SMB</a></td><td>Astea sunt share-urile de Windows.</td></tr>
</table>
<p> Pentru rezolvarea numelor la ftp folosesc mai intai DNS-ul si apoi nmb-ul.
Pentru SMB folosesc nmb-ul si apoi DNS-ul. Numele care apar cu litere mici sunt
rezolvate cu DNS-ul, cele cu litere mari cu SMB-ul. </p>
<h2>Surse. Comentarii la surse</h2>
<p>Pentru curiosi: <a href="surse">Sursele</a> in php. Extensia este <code>phps</code> adica "<cite>PHP source</cite>".
Pentru editare folosesc <code>vim</code> care stie <cite>syntax highlighting</cite> si <cite>text completition</cite>.</p>
<p>
<b>ATENTIE:</b> Programele care folosesc socket-raw tebuie sa fie suidate pe root!!! (fping,nmap,arping)
</p>
<p>
Scripturile sunt sub licenta GNU GPL. Adica le puteti copia, modifica si face orice cu ele atata timp cat sunt sub licenta GPL.
</p>
<p>O sa folosesc arping in loc de ping pentru ca:</p>
<ul>
<li>oricum daca nu am mai discutat de un minut cu mdk-ul se face un ARP REQUEST</li>
<li>daca merge ARP-ul atunci merge si IP-ul, deci hostu' este pornit si pot sa comunic cu el</li>
<li>nu trimite pe langa cererea ARP si un pachet ICMP, care este mai mare si care este si in plus</li>
<li>este mai pervers decat un simplu ping pentru ca chiar daca este pus firewall sa nu treaca nici tzantarul(ping-ul), dar
este pornita interfata de retea si are IP-ul pus pe ea, atunci nu poate sa imi reziste sa nu-mi raspunda</li>
<li>daca nu merge ARP-ul, nimic nu merge</li>
</ul>

<?php include("data.php3")?>
 </body>
</html>
