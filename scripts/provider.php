<?
$fp = fopen('providers.ini', 'r');
while(!feof($fp)) {
	list($provider, $a, $afm, $doy, $phone, $tk, $city, $address) = split("\t", fgets($fp));
	$address = trim($address);
	echo "cost.Provider {\r\n";
	if ($provider != '') echo "\tjava.lang.String �������� = \"$provider}\";\r\n";
	if ($afm != '') echo "\tjava.lang.String ��� = \"$afm\";\r\n";
	if ($doy != '') echo "\tjava.lang.String ��� = \"$doy\";\r\n";
	if ($phone != '') echo "\tjava.lang.String �������� = \"$phone\";\r\n";
	if ($tk != '') echo "\tjava.lang.String �.�. = \"$tk\";\r\n";
	if ($city != '') echo "\tjava.lang.String ���� = \"$city\";\r\n";
	if ($address != '') echo "\tjava.lang.String ��������� = \"$address\";\r\n";
	echo "};\r\n";
}
fclose($fp);
?>