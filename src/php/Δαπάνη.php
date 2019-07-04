<?php
require_once('init.php');
require_once('contract.php');
require_once('statement.php');
require_once('header.php');

/* ������ ��������� �������.
 * @param string $name �� ������� ��� ���������� ���� �� ��� ������ ���, ��� ����� ��� ������� ���
 * �� ������� ���������� */
function export_subfolder($name) {
	$pos = strpos($name, ':', 13);
	$num = substr($name, 0, $pos);
	$name = substr($name, $pos + 2);
?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1133\margtsxn6850\margbsxn5669

\pard\plain\sa283\qc\fs72 <?=rtf($num)?>\par\hyphpar0\fs46 <?=rtf($name)?>\par

\sect

<?php

}

/** ������ ��� �������������� ��� �������.
 * @param string $name �� ����� ��� ��������������� ���� ������� ��� �� ������� ���������� */
function export($name) {
	switch($name) {
		case '�������� ������, ������������� ���������� �����������':
			statement_common('statement_IBAN'); break;
		case '�������� ������, �� �������������� ������������ ��������, ����� ��� ��':
			statement_common('statement_representative'); break;
		case '�������': export_contracts(); break;
		default:
			if (substr($name, 0, 12) == '���������� �') export_subfolder($name);
			else {
				global $data, $draft;
				require($name . '.php');
			}
	}
}


// ��� �� ���� ������� ��������� ��� �������� ��� ��� ������
$draft = false;
// �� � ������� "���� ��� ����" ����� ������
$onlyone = isset($_ENV['one']) && $_ENV['one'] == 'true';

foreach($data['����� �����������'] as $paper_v)
	if ($paper_v['�������']) {
		ob_start();
		export($paper_v['��������������']);
		echo str_repeat(ob_get_clean(), $onlyone ? 1 : $paper_v['������']);
	}

unset($draft, $onlyone, $paper_v, $name);

rtf_close(__FILE__);