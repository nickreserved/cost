<?
require_once('engine/init.php');
require_once('header.php');

// ��� �� ���� � ������ "���������" ��� ��� "������������" �������
$prereport = false;

// ��� �� ���� ������� ��������� ��� �������� ��� ��� ������
$draft = false;

// �� � ������� "���� ��� ����" ����� ������
$onlyone = getEnvironment('one', 'true');

if (!isset($data['����������������']))
	trigger_error('������ <b>���� �������</b> ��� <b>���� �����������</b> ��� �� ������������ �� ����� �����������', E_USER_ERROR);

foreach($data['����������������'] as $cost_v)
	if (isset($cost_v['������'])) {
		ob_start();
		require("{$cost_v['��������������']}.php");
		$a = ob_get_clean();
		$b = $onlyone ? 1 : $cost_v['������'];
		for($z = 0; $z < $b; $z++) echo $a;
	}

?>