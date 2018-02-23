<?

set_time_limit(10);
date_default_timezone_set('Europe/Athens');
require_once('unserialize.php');
require_once('contents.php');

function errorHandler($errno, $str, $file, $line)
{
	if ($errno == E_STRICT) return;

	// �������� ��� ������� ��� ������� ��� ���������
	$file = preg_split("/[\\/]/", $file);
	$a = count($file) - 2;
	$path = $file[$a];
	$file = $file[++$a];
	$a = get_contents($file);
	$file = $a ? "<i>$a</i>" : "$path/$file";
	// �������� ��� ��������� ������ ��� ������� ��� ���������
	$str = str_replace('Undefined index:', '��� �������� �� ����� <b>', $str);

	fwrite(STDERR, "<html><b><font color=green>$file</font>(<font color=red>$line</font>):</b> <font color=blue>$str</font>\n");
  if ($errno == E_USER_ERROR) die();
}

set_error_handler('errorHandler');
setlocale(LC_ALL, 'el_GR', 'ell_grc');
require_once('functions.php');
require_once('order.php');

?>