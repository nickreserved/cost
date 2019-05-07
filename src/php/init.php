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

/** ����������� ��� ��������� ��� ����� ��� ����������.
 * �� ���� ���������, ��� ����� '�����', ������������ ��� array �� �������� ��� ����� �������
 * '������ ����', '���', '������������', '���������', '��������', '������ ���� ��� ��', '��',
 * '�������� ��������', �� ��� ���������� ���� ��� �� ������.
 * <p>�� ���� ����� ����������, ��� ����� '�������� ����', ������������ �� �������� ��������� ������
 * ��� ��� ������� ����� ��� ����.
 * <p>�� ���� ������� ����������, ��� ����� '������', ������������ �� ������ ��� ��������� ���������
 * ��� ��������.
 * <p>������ �� ������ ���� ��� ��� init_deduction_names(). */
function init_invoices() {
	global $data;
	foreach($data['���������'] as & $invoice) {
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
		$wePayDeductions = $contractor_type == 'PUBLIC_SERVICES' || $contractor_type == 'ARMY';
		if ($wePayDeductions) $mixed += $deductions;
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
 * <p>������ �� ������ ���� ��� ��� init_invoices(). */
function init_invoices_by_contractor() {
	global $data;
	$data['��������� ��� ���������'] = get_invoices_by_contractor($data['���������']);
	foreach($data['��������� ��� ���������'] as & $v)
		$v = array('���������' => $v, '�����' => calc_sum_of_invoices_prices($v));
}

/** ����������� ��� ����� ��� ������� �������� ���� ��� ������� �� ������ ���� ��� �� ������������.
 * ������ �� ������ ���� ��� init_invoices() ��� init_newer_invoice_date(). */
function init_empty_fields() {}//TODO: implement or erase


/** ������� �� �� ��������� ��� ����� ���������� ������� ���� ���� �������.
 * �� ���� ���������� ���� ��������� ������� ���� ���, ��� �� ��������� ��� ���� ������� ������ ��
 * ������� �� ���� �� �������. �� ��� ���� ���������, ��� ������ ������ ��������� �� ������ �� ����
 * �� �������.
 * <p>������ �� ������ ���� ��� ��� init_invoices_by_contractor(). */
function check_invoices_contracts_contractors() {
	global $data;
	foreach($data['��������� ��� ���������'] as $v) {
		$invoices = $v['���������'];
		$index = -1;
		foreach($invoices as $invoice) {
			$a = get_contract($invoice);
			if ($index == -1) $index = $a;
			else if ($a != $index)
				trigger_error("��� ������� ��� �� ��������� ��� �{$invoice['����������']['��������']}� ���� ���� �������", E_USER_ERROR);
		}
	}
}


init_deduction_names();
init_invoices();
init_newer_invoice_date();
init_invoices_by_contractor();
check_invoices_contracts_contractors();
init_empty_fields();

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