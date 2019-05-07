<?php
require_once('statement.php');

statement_common(
	/** ������ ��� �������� ������ ���������� ��� ����������� �� IBAN.
	 * @param array $data �� �������� ��� ��������� ������� */
	function($data) {
		$data['����'] = '���';
		$data['������'] = '�� ��������� ���� ��� ���������� �� �������� ��� �{\b ' . rtf($data['��������']) . '}�, ���: ' . rtf($data['���']) . ', ��������: ' . rtf($data['��������']) . ', �� ��������� ��� ���������� IBAN {\b ' . iban($data['����']) . '} ({\b ' . bank($data['����']) . '}).\par ������������� ��������� ��� ���������� ����������.';
		statement_contractor($data);
	});

rtf_close(__FILE__);