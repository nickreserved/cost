<?
$fp = fopen('men.ini', 'r');
while(!feof($fp)) {
	list($rank, $name) = split("\t", fgets($fp));
	$name = trim($name);
	echo "cost.Man {\r\n";
	if ($rank != '') echo "\tjava.lang.String ������ = \"$rank\";\r\n";
	if ($name != '') echo "\tjava.lang.String ������������� = \"$name\";\r\n";
	echo "};\r\n";
}
fclose($fp);
?>