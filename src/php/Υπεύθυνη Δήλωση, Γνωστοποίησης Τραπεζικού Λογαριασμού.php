<?
require_once('init.php');
require_once('header.php');
require_once('statement.php');

foreach($data['��������� ��� ���������'] as $per_contractor) {
	$v = $per_contractor['���������'][0]['����������'];
	if ($v['�����'] != 'PRIVATE_SECTOR') continue;
	$v['����'] = '���';
	if (!isset($v['�������������'])) $v['�������������'] = $v['��������'];
	if (!isset($v['����� ���������'])) $v['����� ���������'] = $v['���������'];
	if (!isset($v['e-mail'])) $v['e-mail'] = '';
	$v['������'] = '�� ��������� ���� ��� ���������� �� �������� ��� �{\b ' . rtf($v['��������']) . '}�, ���: ' . rtf($v['���']) . ', ��������: ' . rtf($v['��������']) . ', �� ��������� ��� ���������� IBAN {\b ' . iban($v['����']) . '} ({\b ' . bank($v['����']) . '}).\par ������������� ��������� ��� ���������� ����������.';
	$v['���������� �������'] = get_newer_invoice_date($per_contractor['���������']);
	statement($v);
}

rtf_close(__FILE__); ?>