<?
require_once('basic.php');

// ������������
$bills = $data['���������'];
$bills_info = calc_bills($bills);
$bills_buy = getBillsCategory($bills, '������ ���������', false);
$bills_contract = getBillsCategory($bills, '������ ���������');
$bills_warrant = getBillsType($bills, '*��/���*�������*');
$bills_hold = bills_by_hold($bills);
$bills_hold_all = bills_by_hold($bills, true);
$bills_fe = bills_by_fe($bills);


// ����������� ��� ����� �������� ����
if (!isset($data['����']) && isset($bills_info['������������'])) $data['����'] = $bills_info['������������'];
if (!isset($data['����']) && isset($data['������'])) $data['����'] = $data['������'];
if (!isset($data['������޸����'])) $data['������޸����'] = $data['����'];
if (!isset($data['�������������������']) && isset($data['���������'])) $data['�������������������'] = $data['���������'];

// �������� ��� ������� ��� ���������� ��� ��� ���� ����������
$a = null;
foreach($bills as $v) {
	if (isset($v['���������']) && preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $v['���������'], $b)) {
		$b = mktime(0, 0, 0, $b[2], $b[1], $b[3], -1);
		if ($a < $b) $a = $b;
	}
}
if ($a) $a = $data['������������������������������'] = strftime('%d %b %Y', $a);

// ����������� ���� ����������� �������� �����
$b = array('������������������������', '������������������������������', '��������������������������������������', '������������������������������');
foreach($b as $v)
	if (isset($data[$v])) $a = chk_date($data[$v]);
	elseif ($a) $data[$v] = $a;

// ����������� ��� ���������� ���� �� ��� ������ ���������
if (isset($data['������������'], $data['�����������']) && !strpos($data['������������'], '����������� ����������'))
	$data['�������������������������������'] = $data['������������������������������'] =
		$data['�����������������'] = $data['�����������������'] = $data['�������������'] = $data['�����������'];

// ����������� �� ���� ��� ����� �����������
if (isset($data['����������������'])) {
	foreach($data['����������������'] as & $v) {
		$a = get_contents($v['��������������']);
		if ($a) $v = array_merge($v, $a);
	}
	unset($v);
}

?>