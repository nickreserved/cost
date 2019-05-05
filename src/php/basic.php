<?php
/** ��������� ��������� ��� ��������������� ��� �� ������ PHP.
 * ����� callback ��� ��� ������ set_error_handler(). �� ����������, � ��������� ��� ���������
 * ���������������� ��� ��� �������������� �������� ��������� ��� PHP.
 * <p>� ����� ������� ��� ��������, ����� ����������� �� ����������� ����� �������� ��� PHP ��
 * ��������, ��� ������������� �������, ����� �� ������� ���� �� �� ��� � ������� ��� �� ������ ��
 * ��������� �� ����� ����� � �� ���������.
 * @param int $errno � ����� ��� ���������
 * @param string $str �� ������ ��� ���������
 * @param string $file �� ������ ��� ����� ������ �� ������
 * @param int $line � ������ ��� ������ ��� ����� ������ �� ������ */
function errorHandler($errno, $str, $file, $line) {
	if ($errno == E_STRICT) return;

	// �������� ��� ��������� ������ ��� ������� ��� ���������
	$str = str_replace('Undefined index:', '��� �������� �� ����� <b>', $str);
	$file = basename($file, '.php');
	fwrite(STDERR, "<html><b><font color=green>$file</font>(<font color=red>$line</font>):</b> <font color=orange>$str</font>\n");

	if ($errno == E_USER_ERROR) die();
}

set_error_handler('errorHandler');
set_time_limit(10);
date_default_timezone_set('Europe/Athens');
setlocale(LC_ALL, 'el_GR', 'ell_grc');

// ��������� ��� �������� ��� STDIN ���� ����� ���� ���������
$data = unserialize(stream_get_contents(STDIN));
if (!$data) trigger_error('�� ����������� �������� ����� �����', E_USER_ERROR);

require_once('functions.php');
require_once('order.php');