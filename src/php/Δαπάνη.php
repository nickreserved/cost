<?php
require_once('init.php');
require_once('header.php');

// ��� �� ���� ������� ��������� ��� �������� ��� ��� ������
$draft = false;
// �� � ������� "���� ��� ����" ����� ������
$onlyone = isset($_ENV['one']) && $_ENV['one'] == 'true';

foreach($data['����� �����������'] as $paper_v)
	if (isset($paper_v['������'])) {
		ob_start();
		require($paper_v['������']);
		echo str_repeat(ob_get_clean(), $onlyone ? 1 : $paper_v['������']);
	}

unset($draft, $onlyone, $paper_v);

rtf_close(__FILE__);