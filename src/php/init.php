<?php
require_once('basic.php');
require_once('unserialize.php');
require_once('functions.php');

/** ����������� ��� ��������, ����� �� �� ������� ���� ��� ��������� ���������, ���� ��� ����������.
 * ��� ����� �� �� ������� ���� ��� ��������� ��������� ���� ��� ���������� ������������ ��� �����
 * $data['���������']. */
function init_deduction_names() {
	global $data;
	$a = array();
	foreach($data['���������'] as $invoice) {
		$deduction = $invoice['���������'];
		if ($deduction)
			foreach(array_keys($deduction) as $v)
				if (!in_array($v, $a)) $a[] = $v;
	}
	$data['���������'] = $a;
}

/** ������������ ��� ���������.
 * �� ������������, � ������� �������� �� index ��� ����� ��������������. ���� ������� �����������. */
function init_contracts() {
	global $data;
	foreach($data['���������'] as & $contract) {
		// �� ���� ����� ��� ��������� ��������������
		if (!isset($contract['������'])) $contract['������'] = $data['������'];
		if ($contract['����� �����������'] != '��������� �������') {
			if ($contract['����� �����������'] != '���������� �����������')
				trigger_error('�������������� ���� ���������� ����������� (���� �� �����)', E_USER_ERROR);
			// �� �������������� ����������� 3
			if (!isset($contract['��������������']) || count($contract['��������������']) < 3)
				trigger_error('�� ��������������' . (isset($contract['�������']) ? " ��� ������� {$contract['�������']}" : null) . ' ��� ����� ����������� 3');
			// To timestamp ��� �����������
			$m = parse_datetime($contract['������ �����������']);
			$contract['Timestamp �����������'] = mktime($m[1], $m[2], 0, $m[3], $m[0], $m[4]);
		}
		// �� ����������, � ���������� ������������ ��� index, ���� � ���������
		// ���� ������ �� ���������� ���������� ��� �� ��������� �������
		if (is_int($contract['��������']))
			$contract['��������'] = $contract['��������������'][$contract['��������']];
	}
}

/** ����������� ��� ��������� ��� ����� ��� ����������.
 * �� ���� ���������, ��� ����� '�����', ������������ ��� array �� �������� ��� ����� �������
 * '������ ����', '���', '������������', '���������', '��������', '������ ���� ��� ��', '��',
 * '�������� ��������', �� ��� ���������� ���� ��� �� ������.
 * <p>�� ���� ����� ����������, ��� ����� '�������� ����', ������������ �� �������� ��������� ������
 * ��� ��� ������� ����� ��� ����.
 * <p>�� ���� ������� ����������, ��� ����� '������', ������������ �� ������ ��� ��������� ���������
 * ��� ��������.
 * <p>������ �� ������ ���� ��� ��� init_deduction_names() ��� ��� init_contracts(). */
function init_invoices() {
	global $data;
	foreach($data['���������'] as & $invoice) {
		// ����������� ������� ��� ���������
		if (isset($invoice['�������'])) {
			$invoice['�������'] = $data['���������'][$invoice['�������']];
			$invoice['����������'] = $invoice['�������']['��������'];
		}
		// ����������� ���� ��������� ��� ���������� �� �������� ��� ��������� ��������� ����.
		$deduction = & $invoice['���������'];
		if (!$deduction) $invoice['���������'] = array('������' => 0);
		else {
			$sum = 0;
			foreach($deduction as $v)
				$sum += $v;
			$deduction['������'] = round($sum, 5);
		}
		// ����������� �� ����� '�������� ����' �� ���� ����� ����������
		// ���������� ������ ���� ��� ��� ���������� ����� ��� ����� ���������� ���
		$net = $vat = 0;
		$vat_categories = array();
		foreach($invoice['����'] as & $item) {
			$a = round($item['���� �������'] * $item['��������'], 3);
			$item['�������� ����'] = $a;
			$net += $a;
			$vat_p = $item['���'];
			if ($vat_p) {
				$a *= $vat_p / 100;
				$vat += $a;
				if (isset($vat_categories[$vat_p])) $vat_categories[$vat_p] += $a;
				else $vat_categories[$vat_p] = $a;
			}
		}
		// ����������� ��� ����� ��� ���������� �� ���� ���������
		$net = round($net, 2);
		$vat = round($vat, 2);
		$vat_categories = adjust_partials($vat_categories, $vat);
		$mixed = $net + $vat;
		$deductions = round($net * $invoice['���������']['������'] / 100, 2);
		$contractor_type = $invoice['����������']['�����'];
		if ($contractor_type != '��������� ������') $mixed += $deductions;
		$mixed = round($mixed, 2);
		$payable = round($mixed - $deductions, 2);
		$netIncomeTax = $net;
		$incomeTax = $invoice['��'];
		if ($incomeTax != 3) $netIncomeTax -= $deductions;
		$netIncomeTax = round($netIncomeTax, 2);
		$incomeTax = round($netIncomeTax * $incomeTax / 100, 2);
		$payableMinusIncomeTax = round($payable - $incomeTax, 2);
		$invoice['�����'] = array(
			'������ ����'        => $net,
			'���'                => $vat,
			'������������'       => $mixed,
			'���������'          => $deductions,
			'��������'           => $payable,
			'������ ���� ��� ��' => $netIncomeTax,
			'��'                 => $incomeTax,
			'�������� ��������'  => $payableMinusIncomeTax
		);
		$invoice['���������� ���'] = $vat_categories;
	}
	// ����������� �������������, ���������, ��, ��� ��� �� ������ ��� �������
	$data['�����'] = calc_sum_of_invoices_prices($data['���������']);
}

/** ����������� ��� �������� ��� ��� �������� ���������� ����������.
 * ��� ����� $data['���������� ���������� ����������'], ������������ � ���������� ��� ��� ���������
 * ���������� ��� ����� '31 ��� 2019'. */
function init_newer_invoice_date() {
	global $data;
	$a = get_newer_invoice_timestamp($data['���������']);
	if ($a) {
		$data['Timestamp ���������� ����������'] = $a;
		$data['���������� ���������� ����������'] = strftime('%d %b %y', $a);
	}
}

/** ����������� ��� �������� ��� array �� ��� ������ ���������� ��� ���� ����������.
 * ��� ����� $data['��������� ��� ���������'], ������������� �������� ��� ���� ���������. ����
 * �������� ����������, �������� 2 ��������: �� ������ '���������' array �� �� ��������� ���
 * ����������. �� ������ '�����' �� ���������� ��� ����������� ����� ��� ���������� ��� ����������.
 * <p>������ ������� �� �� ��������� ��� ����� ���������� ������� ���� ���� �������. �� ����
 * ���������� ���� ��������� ������� ���� ���, ��� �� ��������� ��� ���� ������� ������ �� �������
 * �� ���� �� �������. �� ��� ���� ���������, ��� ������ ������ ��������� �� ������ �� ���� �� �������.
 * <p>������ �� ������ ���� ��� ��� init_invoices(). */
function init_invoices_by_contractor() {
	global $data;
	$contracts = array();
	// ��������� ���� ���������
	$data['��������� ��� ���������'] = get_invoices_by_contractor($data['���������']);
	foreach($data['��������� ��� ���������'] as & $per_contractor) {
		// ����������� ����� ��� ��� ��� ����� ���������� ��� ������ ������������
		$invoice = $per_contractor[0];
		$per_contractor = array(
			'���������' => $per_contractor,
			'�����' => calc_sum_of_invoices_prices($per_contractor),
			'����������' => $invoice['����������']);
		// ���������� ���������� ��������, �� ������� ��� ��������...
		// �� ��������� ��� ����� ���������� ������ �� ����� ��� ���� �������
		if (isset($invoice['�������'])) {
			$contract = $invoice['�������'];
			$contracts[] = $contract;
			$per_contractor['�������'] = $contract;
			foreach($per_contractor['���������'] as $invoice)
				if (!isset($invoice['�������']) || $contract !== $invoice['�������'])
					trigger_error("��� ������� ��� �� ��������� ��� �{$invoice['����������']['��������']}� ���� ���� �������", E_USER_ERROR);
		} else
			foreach($per_contractor['���������'] as $invoice)
				if (isset($invoice['�������']))
					trigger_error("��� ������� ��� �� ��������� ��� �{$invoice['����������']['��������']}� ���� ���� �������", E_USER_ERROR);
	}
	// ������ ���� �� ��������� �� ���������������� ��� ���������
	// ���������� ��� ����� ����������� �� ������� �� �������� ��� 0
	if (isset($data['���������'])) {
		$contracts = array_values(array_udiff($data['���������'], $contracts, 'ss'));
		$a = count($contracts);
		if ($a) {
			$err = get_names_key($contracts, '�������');
			$err = $a == 1 ? "� ������� $err ��� ���������������" : "�� ��������� $err ��� ����������������";
			trigger_error("$err ��� ���������");
		}
	}
}

init_deduction_names();
if (isset($data['���������'])) init_contracts();
init_invoices();
init_newer_invoice_date();
init_invoices_by_contractor();

/*var_dump($data);
die;
$bills_buy = getBillsCategory($bills, '������ ���������', false);
$bills_contract = getBillsCategory($bills, '������ ���������');
$bills_warrant = getBillsType($bills, '*�������*�������*');
$bills_hold = bills_by_hold($bills);
$bills_hold_all = bills_by_hold($bills, true);
$bills_fe = bills_by_fe($bills);


// ����������� ��� ����� �������� ����
//if (!isset($data['����']) && isset($data['������'])) $data['����'] = $data['������'];
//if (!isset($data['������޸����'])) $data['������޸����'] = $data['����'];
//if (!isset($data['�������������������']) && isset($data['���������'])) $data['�������������������'] = $data['���������'];
//if (!isset($data['����������������������������������']) && isset($data['���������'])) $data['����������������������������������'] = $data['���������'];
//if (!isset($data['���������������']) && isset($data['����'])) $data['���������������'] = $data['����'];

// �������� ��� ������� ��� ���������� ��� ��� ���� ����������
$a = null;
foreach($bills as $v)
	if (isset($v['���������']) && preg_match('/(\d{1,2})-(\d{1,2})-(\d{4})/', $v['���������'], $b)) {
		$b = mktime(0, 0, 0, $b[2], $b[1], $b[3]);
		if ($a < $b) $a = $b;
	}
if ($a) $a = $data['������������������������������'] = strftime('%d %b %Y', $a);

// ����������� ���� ����������� �������� �����
$b = array('������������������������', '������������������������������', '��������������������������������������', '������������������������������');
foreach($b as $v)
	if (isset($data[$v])) $a = chk_date($data[$v]);
	elseif ($a) $data[$v] = $a;

// ������ ��� ������ ���� �� ������� ����������
if (isset($data['������������'], $data['����������������']) && $data['������������'] != '��������� - ��������� - ��������' && $data['����������������'] == '�������� �����������')
	trigger_error('�� ���� �� ������� ���������� �������� �� ������� �� ������������ ������������ ��� �������� ��� ���', E_USER_ERROR);

// ����������� �� ���� ���� ������ ����������
if (isset($data['������������'], $data['����������������']) && $data['������������'] == '��������� - ��������� - ��������' && $data['����������������'] != '����� ����������') {
	if (isset($data['�������������������'])) $data['����������������������'] = $data['�������������������'];
	if (isset($data['�����������������'])) $data['��������������������'] = $data['�����������������'];
	if (isset($data['�����������������'])) $data['��������������������'] = $data['�����������������'];
}*/