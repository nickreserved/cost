<?

// ��� �� ���� � ������ "���������" ��� ��� "������������" �������
$prereport = false;

// ��� �� ���� ������� ��������� ��� �������� ��� ��� ������
$draft = false;

require_once('engine/functions.php');
require_once('engine/order.php');
require_once('header.php');


foreach($data['����������������'] as $cost_item)
	if (isset($cost_item['������'])) {
		// �� ���� ������� ��� �� ��� ��������� ���� ��� 1, ���.
		// �� ���� �� include_once ����� ������ �� �������� ��������� �� ������.
		ob_start();
		require("{$cost_item['������']}.php");
		$a = ob_get_clean();
		for($z = 0; $z < $cost_item['������']; $z++) echo $a;
	}
?>