<?php
require_once('init.php');
require_once('header.php');

// ��� �� ���� ������� ��������� ��� �������� ��� ��� ������
$draft = false;
// �� � ������� "���� ��� ����" ����� ������
$onlyone = isset($_ENV['one']) && $_ENV['one'] == 'true';

foreach($data['����� �����������'] as $cost_v) {
	if (isset($cost_v['������'])) {
		ob_start();
		require($cost_v['������']);
		$a = ob_get_clean();
		$b = $onlyone ? 1 : $cost_v['������'];
		for($z = 0; $z < $b; $z++) echo $a;
	}
}

unset($draft, $onlyone, $cost_v, $a, $b, $z);

rtf_close(__FILE__);