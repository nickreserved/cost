<?php

/** ����� �� �������� ��������� ��� ��������������� ��� �� ������ PHP.
 * �� ���������� �� callback, � ��������� ��� ��������� ���������������� ��� ��� ��������������
 * �������� ��������� ��� PHP.
 * <p>� ����� ������� ��� ��������, ����� ����������� �� ����������� ����� �������� ��� PHP ��
 * ��������, ��� ������������� �������, ����� �� ������� ���� �� �� ��� � ������� ��� �� ������ ��
 * ��������� �� ����� ����� � �� ���������.
 * @param int $errno � ����� ��� ���������
 * @param string $str �� ������ ��� ���������
 * @param string $file �� ������ ��� ����� ������ �� ������
 * @param int $line � ������ ��� ������ ��� ����� ������ �� ������ */
set_error_handler(function($errno, $str, $file, $line) {
	if ($errno == E_STRICT) return;

	// �������� ��� ��������� ������ ��� ������� ��� ���������
	$str = str_replace('Undefined index:', '��� �������� �� ����� <b>', $str);
	$file = basename($file, '.php');
	fwrite(STDERR, "<html><b>$file($line):</b> $str\n");

	if ($errno == E_USER_ERROR) die();
});
set_time_limit(10);
date_default_timezone_set('Europe/Athens');
setlocale(LC_ALL, 'el_GR', 'ell_grc');