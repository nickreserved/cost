<?php
require_once('basic.php');
require_once('unserialize.php');
require_once('header.php');

// � ��������� ������������� ��������� �� �� �������
$name = $_ENV['export'];
switch($name) {
	case 'statement_IBAN':
	case 'statement_representative':
		require_once('statement.php');
		if (isset($data['����'])) {	// �� �������� ����� ������
			require_once('init.php');
			statement_common($name);
		} else $name($data);
		break;
	default:
		require_once('contract.php');
		require_once('tender.php');
		$name();
		break;
}

rtf_close(__FILE__);