<?php

/** ������� �� RTF ������, �� ����������, �� ������� ��� ���������� ��������.
 * �� RTF ������ ������� �� �� ��������� '}', ���� ��� script ������ �� ����������� ������ ������
 * ��������������� �� ����� ��� ������ �� �������� �� RTF ����� ��� ��������� ��� ���������� ��� ����
 * ��������������.
 * <p>�.�. � ������ ������ ��� �������������� ��������, ���� � ������� �������� ��� ���� ���. �����
 * ���� �� ����������� ��� PHP script ��� ������� (��� ��� �� ������ ��� ��������� �� require) �������
 * �� RTF ������.
 * @param string $file �� ����� ������� ��� script ��� �������� �������� ��� RTF ������� */
function rtf_close($file) {
	$a = get_required_files();
	if ($file == $a[0]) echo "\n\n\n}";
}

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
	$a = get_newer_invoice_date($data['���������']);
	if ($a) $data['���������� ���������� ����������'] = $a;
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


/** ���������� �� ���������� ��� ����� ������ ����������.
 * @param array $invoices � ����� ����������. ������ �� �������� ����������� ��� ���������.
 * @param array $keys �� ������� ��� ����� ��� ��� ������ �� ������������ �� ���������� ����, �.�.
 * '������ ����'. �� ����� null, ������������� �� ���������� ���� ��� �����.
 * @return array �� ���������� ��� �����, ���� ��� ���������� ��� �������� ������ */
function calc_sum_of_invoices_prices($invoices, $keys = null) {
	if (!$keys) $keys = array_keys($invoices[0]['�����']);	// ���� ���� ��� �������� ��� ����� ��� �� ����� ���������
	$b = array_fill_keys($keys, 0);		// ������������ ��� ����������� �� ���� 0
	foreach($invoices as $invoice) {
		$price = $invoice['�����'];
		foreach($keys as $key)
			$b[$key] += $price[$key];
	}
	return $b;
}

/** ���������� ����������, ��� ��������� ���������, ���� ������ ����������.
 * @param array $invoices ��� ����� ����������
 * @return array ���� ������� �� ������� ��� ��������� ��������� ��� �� '������' ��� ����� ���
 * ����������� ����� �� ����, �������� �� ������ ������� ��� �� ��� �������� �������� ��������� ���
 * �������� */
function calc_partial_deductions($invoices) {
	$a = array();
	$priceSum = 0;
	// ���������� ��������� ���������
	foreach ($invoices as $invoice) {
		$deduction = $invoice['���������'];
		$sum = $deduction['������'];
		$price = $invoice['�����']['���������'];	// ��� ��� ��� ������� ����� ����� �� ��������� ����� ����������������
		$priceSum += $price;
		foreach($deduction as $name => $term) {
			if ($name != '������') {
				$val = $price * $term / $sum;
				if (!isset($a[$name])) $a[$name] = $val; else $a[$name] += $val;
			}
		}
	}
	// �������� ����������������
	$a = adjust_partials($a, $priceSum);
	$a['������'] = $priceSum;
	return $a;
}

/** �������� ��� ����� ����� ���� �� ����� ��� ������������ ��������.
 * �� ��� ������� ������������ �� ��� ���� ��� ����������������� �� 2 �������� �����, ��� ����������
 * ���� �� ������� ��������� �� ��������� �������, ���� �� �� ����������� ����� ��� ��������� ��������
 * ����������������� ��� 2 �������� ����� ��� ����������, � �������� ���� ����, ��������� ����
 * ��������� ���������������� �� ��� ����� ���� �� ��� ���� ��� ������������� ��� ������ �������.
 * ��� �� ���� ����, �� ��������� ����� �������������� ������� ���� 0.01 ����������� �� �������� ����
 * �� ����� ���� �� ��� ���� ��� ������� ��������.
 * @param array $in �� ����� ��� ��������� �������� ����� ���������������
 * @param float $desirableSum �� ��������� �������� ��� �������� �����, ���� �� ���������������
 * @return array �� ����� ��� ��������� �������� ���� �� ��������������� */
function adjust_partials($in, $desirableSum) {
	$sum = 0;
	$remainders = array(); $out = array();
	foreach($in as $key => $term) {
		$term_new = round($term, 2);
		$remainders[] = array($key, $term_new - $term);
		$out[$key] = $term_new;
		$sum += $term;
	}
	$remainder = round(($sum - $desirableSum) * 100);
	if ($remainder) {
		$comparator = function($v1, $v2) {
			if ($v1[1] < $v2[1]) return -1;
			if ($v1[1] > $v2[1]) return 1;
			return 0;
		};
		usort($remainders, $comparator);
		if ($remainder > 0)
			for ($z = 0; $z < $remainder; ++$z)
				$out[$remainders[count($remainders) - 1 - $z][0]] -= 0.01;
		else
			for ($z = 0; $z < -$remainder; ++$z)
				$out[$remainders[$z][0]] += 0.01;
	}
	return $out;
}

function calc_per_deduction_incometax_vat($invoices) {
	$deductions = array(); $vat = array(); $incometax = array();
	foreach($invoices as $invoice) {
		if ($invoice['��']) {			// ������� ��� �� ��� ���� ���������
			$key = $invoice['��']; $value = $invoice['�����']['��'];
			if (isset($incometax[$key])) $incometax[$key] += $value; else $incometax[$key] = $value;
		}
		if ($invoice['�����']['���������']) {	// ������� ��� ��������� ��� ���� ���������
			$key = (string) $invoice['���������']['������']; $value = $invoice['�����']['���������'];
			if (isset($deductions[$key])) $deductions[$key] += $value; else $deductions[$key] = $value;
		}
		foreach($invoice['���������� ���'] as $key => $value)	// ������� ��� ����� ��� ��� ���� ���������
			if (isset($vat[$key])) $vat[$key] += $value; else $vat[$key] = $value;
	}
	return array('���������' => $deductions, '��' => $incometax, '���' => $vat);
}

/** ������� ��� ���������� �� ������� ��� ���������� array �� ��� ����������.
 * @param string $a ���������� ��� ������ '31 ��� 19'
 * @return array ���������� ��� ������ (31, '���', 19) */
function get_date_components($a) {
	$m = null; // �� �� ������������� �� netbeans
	if (!preg_match('/(\d{1,2}) (���|���|���|���|���|����|����|���|���|���|���|���) (\d{2})/', $a, $m))
		trigger_error(($a ? "�� '<b>$a</b>' ��� ����� ����� ����������" : '�� ����������� ������ �� ��������') . " ��� ����� �.�. '20 ��� 19'");
	else {
		array_shift($m);
		return $m;
	}
}

/** ������� ��� ���������� �� array ��� ���������� ��� ���������� �� array �������.
 * @param array $a ���������� ��� ������ (31, '���', 19)
 * @return array ���������� ��� ������ (31, 12, 2019) */
function get_date_components_int($a) {
	$a[1] = get_month($a[1]);
	$a[2] += 2000;
	return $a;
}

/** ������� ��� ���������� �� ������� ��� ���������� ���� ��� ����.
 * @param string $a ���������� ��� ������ '26 ��� 19'
 * @return string ���������� ��� ������ '��������� 2019' */
function get_full_month_year($a) {
	$a = get_date_components_int(get_date_components($a));
	return strftime('%B %Y', mktime(0, 0, 0, $a[1], $a[0], $a[2]));
}

/** ������� ��� ���������� �� ������� ��� ���������� ����.
 * @param string $a ���������� ��� ������ '26 ��� 19'
 * @return int �� ���� ��� ����� 2019 */
function get_year($a) {
	$a = get_date_components_int(get_date_components($a));
	return $a[2];
}

/** ���������� ��� ������ ��� ���� ��� �� ������� ����� ��� ����.
 * @param string $month �������� ��� ���� �.�. '���'
 * @return int � ������� ��� ����, �.�. 11 */
function get_month($month) {
	$months = array(
		'���' => 1, '���' => 2, '���' => 3, '���' => 4, '���' => 5, '����' => 6,
		'����' => 7, '���' => 8, '���' => 9, '���' => 10, '���' => 11, '���' => 12);
	return $months[$month];
}

/** ���������� ��� array �� ��� ������ ���������� ��� ���� ����������.
 * @param array $invoices ����� �� ���������
 * @return array ��� �������� ��� ���� ���������, ��� �������� ��� array �� ��� ��� �� ��������� */
function get_invoices_by_contractor($invoices) {
	$b = array();
	foreach($invoices as $invoice)
		$b[$invoice['����������']['��������']][] = $invoice;
	return array_values($b);
}

/** ���������� ��� array �� ������ ���������� ������� ��� ���������� ��� ��� ���������.
 * @param array $invoices ����� �� ���������
 * @return array �� �������� �� ������ '����������' ����� array �� ��� �� ��������� ��� �������
 *  ����������. �� �������� �� ������ '���������' ����� array �� ��� �� ��������� ��� �������
 *  ���������. �� ��� �������� ���������� ���������, ��� ������� ��� �� ���������� ��������. */
function get_invoices_by_category($invoices) {
	$b = array();
	foreach($invoices as $invoice)
		$b[get_invoice_category($invoice['���������'])][] = $invoice;
	return $b;
}

/** ���������� �� ������ ����� ���� ���������� ����������.
 * @param string $category � ��������� ��� ���������� �� �� ������ �����
 * @return string � ��������� ��� ���������� �� ������ ��� ������ ����� */
function get_invoice_category($category) {
	return is_supply($category) ? '��������� ������' : '������ ���������';
}

/** ���������� true �� � ��������� ��� ���������� ����� ����������.
 * @param string $category � ��������� ��� ����������
 * @return boolean � ��������� ��� ���������� ����� ��������� */
function is_supply($category) { return $category == 'SUPPLIES' || $category == 'LIQUID_FUEL'; }

/** ���������� ������������� �� ��������� �� ������������ ����.
 * @param array $invoices ����� ����������
 * @param string $type � ����� ��� ���������� (�.�. '��������� ������')
 * @param bool $invert ���������� �� ��������� ��� ��� ����� �� ������������ ���� (����������)
 * @return array ����� ���������� �� �� ������� ���� */
function get_invoices_with_category($invoices, $type, $invert = false) {
	$b = array();
	foreach($invoices as $invoice)
		if (($invoice['���������'] == $type) != $invert) $b[] = $invoice;
	return $b;
}

/** ���������� ������������� �� ��������� �� ������������ ���� ����������.
 * @param array $invoices ����� ����������
 * @param string $type � ����� ��� ����������, ���� ������� ��� ��������� (�.�. 'PRIVATE_SECTOR')
 * @return array ����� ���������� �� �� ������� ���� ���������� */
function get_invoices_with_contractor_type($invoices, $type) {
	$b = array();
	foreach($invoices as $invoice)
		if ($invoice['�����������']['�����'] == $type) $b[] = $invoice;
	return $b;
}

/** ���������� ��� ��� �������� ���������� ����������.
 * @param array $invoices ����� ����������
 * @return string|null � ���������� ��� ��� ��������� ���������� ��� ����� '31 ��� 2019' � null ��
 * ��� �������� ��������� */
function get_newer_invoice_date($invoices) {
	$a = null;
	foreach($invoices as $invoice)
		if (isset($invoice['���������'])) {
			$b = null;
			invoice($invoice['���������'], $b);
			$b = mktime(0, 0, 0, $b[1], $b[0], $b[2]);
			if ($a < $b) $a = $b;
		}
	if ($a) return strftime('%d %b %y', $a);
}

/** ���������� �� �������, ��� �� ������� ���� array �� ��������.
 * @param array $a � ����� �� �� ��������. ��� ������ �� ����� �����.
 * @param string $key �� ������, ��� ���� ��������, �� �� ����� ��� ���������
 * @return string �� ������� ��� ��������� ��� array ��������� �� ',' ����� ��� �� ��������� 2 ���
 * ����� ��������� �� '���' */
function get_names($a, $key) {
	$n = count($a);
	$r = '';
	for ($z = 0; $z < $n - 2; ++$z)
		$r .= $a[$z][$key] . ', ';
	if ($n > 1) $r .= $a[$n - 2][$key] . ' ��� ';
	$r .= $a[$n - 1][$key];
	return $r;
}

/** ���������� ��� ��������� ��� ����������.
 * @param array $invoices ����� ����������
 * @return array ����� ��������� ��� �������� ���������� */
function get_contracts($invoices) {
	global $data;
	$b = array();
	foreach($invoices as $invoice)
		if (isset($invoice['�������'])) $b[] = $data['���������'][$invoice['�������']];
	return array_unique($b);
}

/** ���������� ��� ��������� ��� ����������.
 * @param array $invoice ���������
 * @return array ������� ��� �������� ���������� � ���� array */
function get_contract($invoice) {
	global $data;
	return isset($invoice['�������']) ? $data['���������'][$invoice['�������']] : array();
}

// ���������� ��� array �� ��������� ��� ����� ��.
function bills_with_fe($a) {
	$b = array();
	foreach($a as $v)
		if ($v['���������']) $b[] = $v;
	return $b;
}

// ���������� ��� array �� keys ��� ��������� �� ������� ���
// values array �� ��� �� ��������� ��� ����� ������ �������.
// �� $zero == false ��� ���������� �� ��������� ��� �����
// ��������� 0 (������ �� ����� 0 ���� ��� �������)
function bills_by_hold($a, $zero = false) {
	$b = array();
	foreach($a as $v) {
		$n = $v['�������������������������']['������'];
		if ($n || $zero) $b[str_replace(',', '.', $n)][] = $v;
	}
	return $b;
}

// ���������� ��� array �� keys �� �� �� ������� ���
// values array �� ��� �� ��������� ��� ����� ������ ��.
// ��� ���������� ��������� ����� ��.
function bills_by_fe($a) {
	$b = array();
	foreach($a as $v) {
		$n = $v['���������'];
		if ($n) $b[str_replace(',', '.', $n)][] = $v;
	}
	return $b;
}

// ���������� ��� array �� keys ��� "���� ����" �.�. "��� 2005" ���
// values array �� ��� �� ��������� ��� �����.
function bills_by_month($a) {
	$b = array();
	foreach($a as $v)
		if (preg_match('/\d{1,2}-(\d{1,2})-(\d{4})/', $v['���������'], $m)) {
			$b[mktime(0, 0, 0, $m[1], 1, $m[2])][] = $v;
		} else chk_bill($v['���������']);
	return $b;
}

/** ������� ��� �������� ��� ���������� ���� ������������ ��������.
 * �� � ��������� ��� �������� ��� ����� ����, �� ��������� ���������� �� ��� ������ ���������.
 * @param string $order � ��������� ��� ��������
 * @param array $parts ���������� 6 string �������� �� ����� ����� � ������� �������, � �������
 * ����������, � ������� �����������, � ������� �������, � ���������� ��� �������� ��� � �������
 * @return string � ��������� ��� �������� �� ����� ���� */
function order($order, & $parts = null) {
	if (preg_match('/(�\.?\d{3}(\.\d+)?)\/(\d+)\/(\d+)\/(�\.?\d+)\/(\d{1,2} (���|���|���|���|���|����|����|���|���|���|���|���) (\d{2}))\/(.+)/', $order, $parts)) {
		$parts = array($parts[1], $parts[3], $parts[4], $parts[5], $parts[6], $parts[9]);
		return $order;
	}
	trigger_error(($order ? "�� '<b>$order</b>' ��� ����� ��������� ������������ ��������"
		: '� ��������� ������������ �������� ������ �� �������')
		. ' ��� ����� �.800.12/23/1234/�.123/31 ��� 19/3 ���/4� ��.', E_USER_ERROR);
}

/** ������� ��� ��������� ���� ����������
 * @param string $invoice_name � ��������� ��� ���������� ��� ������ �� ���� �� ����� 1234/31-12-2019
 * @param array $date �� � ��������� ��� ���������� ����� ������, ���������� ��� array �� 3 ��������:
 * ��� �����, �� ���� ��� �� ���� ������� ��� ����������, ��� ����������. �.�. 31, 12, 2019.
 * @return string � ��������� ��� ����������, ���� ������ */
function invoice($invoice_name, & $date = null) {
	if (preg_match('/\d+\/(\d{1,2})-(\d{1,2})-(\d{4})/', $invoice_name, $date)) {
		array_shift($date);
		return $invoice_name;
	}
	trigger_error(($invoice_name ? "�� '<b>$invoice_name</b>' ��� ����� ��������� ����������"
		: '� ��������� ���������� ������ �� �������') . ' ��� ����� 1324/31-12-2006', E_USER_ERROR);
}

/** �������� �������� ����������.
 * ����� ���������� ��� ������� ��� ������� ������ ���� ��� ������� (specification) ��� RTF ����
 * ���� ����� escape �� �� ��������� backslash.
 * @param type $a ��� �������
 * @return type ������� ��� $a ��� ���������� ������� ��� RTF Spec ��� ������������� ���� */
function rtf($a) { return preg_replace('/([\\\{\}])/', '$0$0', $a); }

/** ������� �� � ���������� ������ ����� ��� ��� ����������, ������ ��������� ������.
 * @param string $a ���������� ��� ����� '31 ��� 19'
 * @return string �� $a �� � ���������� ����� ��� ����� ����� */
function chk_date($a) {
	if (preg_match('/\d{1,2} (���|���|���|���|���|����|����|���|���|���|���|���) (\d{2})/', $a))
		return $a;
	trigger_error(($a ? "�� '<b>$a</b>' ��� ����� ����������" : '�� ����������� ������ �� ��������') . " ��� ����� �.�. '20 ��� 19'");
}

// ������� ��� string ��� ������ "26 21:10 ��� 2006"
function chk_datetime($a) {
	if (preg_match('/\d{1,2} \d{1,2}\:\d{2} (���|���|���|���|���|����|����|���|���|���|���|���) \d{4}/', $a))
		return rtf($a);
	trigger_error(($a ? "�� '<b>$a</b>' ��� ����� ������� ������" : '�� �������� ������� ������ �� ��������') . " ��� ����� �.�. '20 21:34 ��� 2005'");
}

// ������� ��� string ��� ������ "21:10 26 ��� 2006" ��� ���������� ��� ��� ��� ��� ����������
function get_datetime($a) {
	if (!preg_match('/(\d{1,2}) (\d{1,2}\:\d{2}) (���|���|���|���|���|����|����|���|���|���|���|���) (\d{4})/', $a, $m))
		trigger_error(($a ? "�� '<b>$a</b>' ��� ����� ������� ������" : '�� �������� ������� ������ �� ��������') . " ��� ����� �.�. '20 21:34 ��� 2005'");
	else {
		$b[] = $m[2]; $b[] = "{$m[1]} {$m[3]} {$m[4]}";
		return $b;
	}
}

/** ���������� ��� string �� �� ������������� ���� ������������.
 * @param a To array �� �� �������� ��� ������������
 * @return String �� �� �������� ��� ������ ��� �� ������������� ��� ������������ */
function person($a) { return rtf($a['������'] . ' ' . $a['�������������']); }

/** ���������� ��� string �� �� ������������� ���� ������������.
 * @param a To array �� �� �������� ��� ������������
 * @param c �� ����� 0, � ������������ ����� ���� ���������� �����. �� ����� 1 ����� ��� ������. ��
 * ����� 2 ����� ���� ���������. �� ����� 3 ����� ���� �������.
 * @return String �� �� �������� ��� ������, �� ������������� ��� -�� �������- �� ������ ���
 * ������������ */
function person_ext($a, $c) {
	return inflection(person($a), $c) . (isset($a['������']) ? " {$a['������']}" : null);
}

// ���������� array �� ��� ����������
function getNewspapers($a) {
	$a = preg_split("/([ ]*,[ ]*)/", $a);
	foreach($a as & $v)
		$v = '��������� �' . toUppercase($v) . '�';
	return $a;
}

function getDates($a) {
	$a = preg_split("/([ ]*,[ ]*)/", $a);
	if (count($a) == 1) return chk_date($a[0]);
	$b = null;
	for ($z = 0; $z < count($a) - 1; $z++)
		$b .= ', ' . chk_date($a[$z]);
	$b .= ' ��� ' . chk_date($a[count($a) - 1]);
	return substr($b, 2);
}

/** ���������� ��� ��������� �� ����, �� ����� �������, �������� ��������� ������.
 * @param int|float $a � �������
 * @param bool $zero �� ����� true, � ������� 0 ���������� '0,00 �', �������� ���������� null
 * @return string � ������� ��� ����� '1.234,10 �' */
function euro($a, $zero = false) {
	$a = num($a);
	if (!$a) return $zero ? '0,00 �' : null;
	else return sprintf('%01.2f �', $a);
}

/** ���������� ��� ��������� �� �������, �� ����� �������, �������� ��������� ������.
 * @param int|float $a � �������
 * @return float � ������� �������������� ��� �� '%', � �� ����� 0, �� 0 */
function percent($a) {
	$a = num($a);
	return !$a ? '0' : "$a%";
}

/** ���������� ��� ��������� �� ����� �������, �������� ��������� ������.
 * @param int|float $a � �������
 * @return float � ������� */
function num($a) {
	if (is_numeric($a)) return (float) $a;
	if ($a) trigger_error("� ���� '<b>$a</b>' �� ������ �� ����� �������");
}

/** ������� �� ���� ���������� ����������� ���� ����� �������.
 * �������������� ���� ��������� �����������.
 * <p>���� ����������� IBAN �����������:
 * <ul><li>��� 2 �������� �������� �������� (�-�) ��� �����. ���� ������ GR.
 * <li>��� 2 �������� (0-9) ������� �����������.
 * <li>����� 30 ����������, �������� � �������� �������� �������� (0-9 �-�) ��� ������������
 * ����������� �� ���� ���� ��� ��������� ��� Basic Bank Account Number (BBAN). ���� ������
 *  ������������ ����� 23 ������� (0-9):
 * <ul><li>��� 3 �������� (0-9) ��� �������� ��� �������.
 * <li>��� 4 �������� (0-9) ��� �������� �� ������������ ��� ��������.
 * <li>��� 16 �������� (0-9) ��� �������� �� ���������� ���� �������.</ul></ul>
 * <p>� ������� ������� ����������� ��������� �� ����:
 * <ul><li>������������ ���� ������� ��� ����������� ��� ��� BBAN, ��� ������ ��� ����� ��� �� '00'
 * ��� ����������� ���� �������� ������� ����������� ��� ��� ������ ���������� �����. ������ ����
 * ���� ������� 4 ���������� ��� ���� ��� ����� ��� ��� �������� ������� ����������� ������� '00'.
 * <li>������������ ���� ������ ��� �������� �� ������� ������, ���������� ��� ��� ASCII ���������
 * �� 55. ���� ���� ���������� �������� ��� �� 10.
 * <li>������������ �� �������� ��� ��������� ��� �������� ��������, ��� ����� ����� �������, ��� ��
 * 97.
 * <li>��������� �� �������� ��� ��������� ��� ������� �������� ��� �� 98.
 * <li>�� ���������� ����� � ������� ������� �����������.</ul>
 * <p>� ������� ����������� ���������������� �� ����:
 * <ul><li>������������ ���� ������� ��� ����������� ��� ��� BBAN, ��� ������ ��� ����� ��� ����
 * �������� ������� �����������. ������ ���� ���� ������� 4 ���������� ��� ���� ��� �����.
 * <li>������������ ���� ������ ��� �������� �� ������� ������, ���������� ��� ��� ASCII ���������
 * �� 55. ���� ���� ���������� �������� ��� �� 10.
 * <li>������������ �� �������� ��� ��������� ��� �������� ��������, ��� ����� ����� �������, ��� ��
 * 97.
 * <li>�� �� ���������� ����� 1, � ���� ����� �������.</ul>
 * @param string $iban � ����������� ����
 * @param array $m ������ �� ��������� �������� ��� ���� �����������
 * @return string � ����������� IBAN �� ����� �������, ������ ��������� ������ */
function iban($iban, $m = null) {
	$iban = str_replace(' ', '', $iban);
	if (preg_match('/(GR)(\d{2})(\d{3})(\d{4})(\d{16})/', $iban, $m)) {
		array_shift($m);
		$trg = '';
		foreach(str_split(substr($iban, 4) . substr($iban, 0, 4)) as $c)
			if (ord($c) > 64) $trg .= ord($c) - 55; else $trg .= $c;
		if (bcmod($trg, 97) == 1) return $iban;
	}
	trigger_error($iban ? "�� IBAN '<b>$iban</b>' ��� ����� ������" : '��� ������ ������ ����', E_USER_ERROR);
}

/** ���������� ��� ������� ���� ����� ������ ���� ����������� IBAN.
 * � ������� ������ �� ����������������� ���� ������.
 * @param string $iban � ����������� ����, � ������ ������ �� ����� �������
 * @return string � �������� ��� �������� ���� ����� ������ � ����������� */
function bank($iban) {
	$iban = (int) substr($iban, 4, 3);
	switch($iban) {
		case  10: return '������� ��� ������� �.�.';
		case  11: return '������ ������� ��� ������� �.�.';
		case  14: return 'ALPHA BANK';
		case  16: return 'ATTICA BANK ������� ��������� ��������';
		case  17: return '������� �������� �.�.';
		case  26: return '������� EUROBANK ERGASIAS A.E.';
		case  34: return '���������� ������� ������� �.�.';
		case  39: return '��� �� �� ������� ����������� ��������';
		case  40: return 'FCA BANK GmbH';
		case  50: return '������� �������� ����';
		case  56: return 'AEGEAN BALTIC BANK �.�.�.';
		case  57: return 'CREDICOM CONSUMER FINANCE ������� �.�.';
		case  58: return 'UNION DE CREDITOS INMOBILIARIOS S.A. ESTABLECIMIENTO FINANCIER';
		case  59: return 'OPEL BANK GmbH';
		case  61: return 'FCE BANK PLC';
		case  64: return 'THE ROYAL BANK OF SCOTLAND PLC';
		case  69: return '�������������� ������� ������ ���. �.�.';
		case  71: return 'HSBC BANK PLC';
		case  72: return 'UNICREDIT BANK AG';
		case  73: return '������� ������ ������� �������� ���';
		case  75: return '�������������� ������� ������� ���. �.�.';
		case  81: return '����� �� ������� ��';
		case  84: return 'CITIBANK EUROPE PLC';
		case  87: return '��������� �������������� ������� ���. �.�.';
		case  88: return '�������������� ������� �. ����� ���. �.�.';
		case  89: return '�������������� ������� ��������� ���. �.�.';
		case  91: return '�������������� ������� ��������� ���. �.�.';
		case  92: return '�������������� ������� ������������ ���. �.�.';
		case  94: return '�������������� ������� ������� "��������� �����" ���. �.�.';
		case  95: return '�������������� ������� ������ ���. �.�.';
		case  97: return '������ ������������� & �������';
		case  99: return '�������������� ������� �. ������ ���. �.�.';
		case 102: return 'VOLKSWAGEN BANK GMBH';
		case 105: return 'BMW AUSTRIA BANK GmbH';
		case 106: return 'MERCEDES-BENZ BANK POLSKA S.A.';
		case 107: return 'GREEK BRANCH OF KEDR OPEN JOINTSTOCK COMPANY COMMERCIAL B';
		case 109: return 'T.C ZIRAAT BANKASI A.S';
		case 111: return 'DEUTSCHE BANK AG';
		case 113: return 'CREDIT SUISSE (LUXEMBOURG) S.A.';
		case 114: return 'FIMBANK PLC.';
		case 115: return 'HSH NORDBANK AG';
		case 116: return 'PROCREDIT BANK (BULGARIA) EAD';
		default: trigger_error("� IBAN '<b>$iban</b>' ����������� �� �� ������������ �������. ������������� �� ��� ��������������.", E_USER_ERROR);
	}
}

/** ���������� ���� ����� ��� ���� ��������� ��� ������ '�����������'.
 * @param array $invoices ��� ����� ���������� ��� ��� ����� �� ����������� �� ����� �����������,
 * ��������� � ��������
 * @param int $inflection 0 ��� ����������, 1 ��� ������, 2 ��� ��������� ��� 3 ��� �������
 * @param int $article 0 ����� �����, 1 ��� ����� ��� 2 ��� '����', '����', '����', '����'
 * @return string � ������ ��� ����������, �� �� ����� ��� �������� */
function get_contractor_title($invoices, $inflection, $article) {
	$c = 0;
	foreach($invoices as $invoice)
		if (!is_supply($invoice['���������'])) {
			$c = $invoice['����������']['�����'] == 'PRIVATE_SECTOR' ? 1 : 2;
			break;
		}
	switch($article) {
		case 1:
			switch($inflection) {
				case 0: $article = array('� ', '� '); break;
				case 1: $article = array('��� ', '��� '); break;
				case 2: $article = array('��� ', '��� '); break;
				default: goto def;
			}
			break;
		case 2:
			switch($inflection) {
				case 1: $article = array('���� ', '���� '); break;
				case 2: $article = array('���� ', '���� '); break;
				default: goto def;
			}
			break;
		default:
def:		$article = array(null, null);
	}
	switch($c) {
		case 0: return $article[0] . wordInflection('�����������', $inflection);
		case 1: return $article[0] . wordInflection('��������', $inflection);
		case 2: return $article[1] . wordInflection('��������', $inflection);
	}
}

// convert a string to uppercase (in Greek capital letters has no tone)
// if we have e.g. "1�� �����" it returns "1�� �����"
function toUppercaseFull($s) {
	static $pre = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
	static $aft = array('�', '�', '�', '�', '�', '�', '�', '�');
	return preg_replace($pre, $aft, strtoupper($s));
}

// convert a string to uppercase (in Greek capital letters has no tone)
// if we have e.g. "1�� �����" it returns "1�� �����" and not "1�� ˼���"
function toUppercase($s) {
	return preg_replace_callback('/(\W|^)\D\w+/', create_function('$m', 'return toUppercaseFull($m[0]);'), $s);
}

// ���� � wordInflection ���� ������ ���� ��� ������ ��� ��������
// ����� �� ����� ����������� ��� 2 ��������
function inflection($a, $w) {
	return !$w ? $a : preg_replace_callback('/[�-��-��-��-�����]{3,}|\d+(��|�|�)/',
		create_function('$m', "return wordInflection(\$m[0], $w);"), $a);
}

// ���������� ��� ���������� ���� ��������� � ������� ��
// (1) ������, (2) ���������, (3) ������� ���� ��� ������
// ��� ����������� ����� �������
// � ���� ������ �� ����� �� ����� �������� (� ��������)
function wordInflection($o, $w) {
	$b = substr($o, -2);
	if ($b == '��' && $w == 1) return substr($o, 0, -1) . '�';
	elseif ($b == '��' && $w == 1) return substr($o, 0, -2) . '��';
	elseif ($w >= 2 && $w <= 3 && ($b == '��' || $b == '��') ||
					$w >= 1 && $w <= 3 && strpos('�� �� �� �� �� �� �� �� ', "$b ") !== false)
		return substr($o, 0, -1);
  elseif ($w == 1 && strpos('������', substr($o, -1)) !== false)
		return $o . '�';
	return $o;
}


// ���������� �� ����� �� ����� �.�. '05 ���� 19'
function now($a = null) { return strftime('%d %b %y', $a == null ? time() : $a); }


/** ���������� ��� �������� ������������ ���� �������� �������.
 * @param int $n �������� ������� ��� �� 1 ����� �� 999
 * @return string � �������� ������������ ��� ������� (�.�. �� ��� �� 6) */
function countGreek($n) {
	if ($n < 1 || $n > 999) trigger_error("��� �� ����������� �� '<b>$n</b>' �� �������� �������� ������ �� ����� �������� ��� �� ������ ��� [1, 999]");
	static $m = array(null, '�', '�', '�', '�', '�', '��', '�', '�', '�');
	static $d = array(null, '�', '�', '�', '�', '�', '�', '�', '�', '\u991  ');
	static $e = array(null, '�', '�', '�', '�', '�', '�', '�', '�', '\u993  ');
	return $e[floor($n / 100)] . $d[floor($n / 10) % 10] . $m[$n % 10];
}


// �� ������ 100.91 �� ������ "����� ���� ��� �������� ��� �����"
function euro2str($d) {
	$a = int2str((int) floor($d), 2);
	$b = int2str((int) (($d - floor($d)) * 100 + 0.4), 2);
	if ($b != '�����') $b .= ' �����'; else $b = null;
	if ($a == '�����')
		return ($b == null) ? '����� ����' : $b;
	else
		return $a . ' ����' . ($b == null ? '' : ' ��� ' . $b);
}

// ���������� �� string ��� ������� ������� $n
// ��� �������� ��� 0 �� 999.999.999.999.999.999.999.999.999.999.999
// �������� �� php ��� ����������� integers ������������ ��� 2^31-1 (��� 32 bit ����������)
// �� $genos ���������� ��� ����� (�������� = 0, ������ = 1, �������� = 2)
function int2str($n, $genos) {
	if (!is_int($n) || $n < 0) return;
	if (!$n) return '�����';
	static $xilia = array('������', '������', '�����');
	static $polla = array('', '���', '����', '�������� ', '�������� ', '������ ', '������� ', '������� ', '�������� ');

	$out = null;
	$b = $n % 1000;
	$n = floor($n / 1000);
	if ($b) $out = int2str_1_999($b, $genos);
	if (!$n) return $out;

	$b = $n % 1000;
	$n = floor($n / 1000);
	if ($b) {
		if ($out) $out = ' ' . $out;
		if ($b == 1) $out = $xilia[$genos] . $out;
		else $out = int2str_1_999($b, 1) . ' ��������' . $out;
	}

	$c = 0;
	while($n) {
		$b = $n % 1000;
		$a = floor($n / 1000);
		if ($b) {
			if ($out) $out = ' ' . $out;
			if ($b == 1) $out = '��� �����������' . $out;
			else $out = int2str_1_999($b, 2) . ' ' . $polla[$c] . '�����������' . $out;
		}
		if (!$n) return $out;
		$c++;
	}
	return $out;
}

// ���������� �� string ��� ������� ������� $n ��� �������� ��� 1 �� 999.
// �� $genos ���������� ��� ����� (�������� = 0, ������ = 1, �������� = 2)
function int2str_1_999($n, $genos) {
	if (!is_int($n) || $n < 1 || $n > 999) return;

	static $ekatodades = array(
		array('�����', '������', '���������', '����������', '�����������', '�����������', '���������', '����������', '����������', '�����������'),
		array('�����', '������', '���������', '����������', '�����������', '�����������', '���������', '����������', '����������', '�����������'),
		array('�����', '������', '��������', '���������', '����������', '����������', '��������', '���������', '���������', '����������')
	);
  static $dekades = array('������', '�������', '�������', '�������', '������', '���������', '�������', '��������');
	static $monades = array(
		array('����', '���', '�����', '���������', '�����', '���', '����', '����', '�����', '����', '������', '������', '���������', '�������������', '���������', '�������', '��������', '��������', '���������'),
		array('���', '���', '����', '�������', '�����', '���', '����', '����', '�����', '����', '������', '������', '��������', '�����������', '���������', '�������', '��������', '��������', '���������')
	);

	$out = null;
	$a = floor($n / 100);
	$b = $n % 100;
	if ($a) {
		if (!$b && $a == 1) $a = 0;
		$out = $ekatodades[$genos][$a];
	}
	if (!$b) return $out;
	if ($out) $out .= ' ';
	if ($b < 20) {
		if ($genos == 1 && $b == 1) return $out . '���';
		return $out . $monades[$genos == 2 ? 1 : 0][$b - 1];
	}
	$out .= $dekades[floor($b / 10) - 2];
	$b = $n % 10;
	if (!$b) return $out;
	if ($genos == 1 && $b == 1) return $out . ' ���';
	return $out . ' ' . $monades[$genos == 2 ? 1 : 0][$b - 1];
}

/** ���������� �� �������� ���� array �� �������.
 * @param array $ar �� array
 * @param string|int $key �� ������ ��� ��������� ��� array
 * @return mixed|null � ���� ��� ��������� �� �� ������� ������ � null */
function ifexist($ar, $key) { if (isset($ar[$key])) return $ar[$key]; }
/** ���������� �� �������� ���� array �� ������� � �� ������ ��� ������������ �����.
 * @param bool $exp ��� ������������ ������ �����
 * @param array $ar �� array
 * @param string|int $key �� ������ ��� ��������� ��� array
 * @return mixed|null � ���� ��� ��������� �� �� ������� ������ � null */
function ifexist2($exp, $ar, $key) { if ($exp || isset($ar[$key])) return $ar[$key]; }
/** ���������� �� �������� ���� array �� �������, ������ ���������� ���� ����.
 * @param array $ar �� array
 * @param string|int $key �� ������ ��� ��������� ��� array
 * @param mixed $else ��� ����������� ���� �� ��� ����� �� ���������� � ��������
 * @return mixed|null � ���� ��� ��������� �� �� ������� ������ � null */
function orelse($ar, $key, $else) { return isset($ar[$key]) ? $ar[$key] : $else; }
/** ���������� �� �������� ���� array �� ������� � �� ������ ��� ������������ �����, ������ ���������� ���� ����.
 * @param bool $exp ��� ������������ ������ �����
 * @param array $ar �� array
 * @param string|int $key �� ������ ��� ��������� ��� array
 * @param mixed $else ��� ����������� ���� �� ��� ����� �� ���������� � ��������
 * @return mixed � ���� ��� ��������� �� �� ������� ������ � $else */
function orelse2($exp, $ar, $key, $else) { return $exp || isset($ar[$key]) ? $ar[$key] : $else; }


// -------------- ��������� �������� -----------------------

/** ���������� ��� ���������� �� �������� ��� ����������� ��� ��� ��������� ��������.
 * @return array ��� array �� ��� ��������. �� ����� ��������, ����� ��� array ��� ���� ���������,
 * �� �� �������� ��� ���������� ��� �� ���������� ��� ����� ���� ��� ���������� ��� ���������� ���
 * ������ ������������������� ������� �����, �������������, ���������, �� ��� ���� ��� ���������
 * ���������. �� ������� �������� ����� ��� array �� �� ���������� ��� ��������� ��������� ���� ���
 * ���������� ���� ��� �����������. */
function calc_pay_report() {
	// ����������� ��� ���� ���������
	global $data;
	$a = get_invoices_by_contractor($data['���������']);
	$b = array();
	$keys = array('������ ����', '������������', '��', '��������');
	foreach($a as $invoices) {
		$c = calc_sum_of_invoices_prices($invoices, $keys);
		$c['���������'] = calc_partial_deductions($invoices);
		$b[] = array_merge($invoices[0]['����������'], $c);
	}
	// ����������� ������� ��������� ��������� ��� ����� ���� �����������
	// �� �������� ���������� ��� ������������� ����� �������� ��� ������
	$c = array_fill_keys($data['���������'], 0);	// ������������ ��� ����������� �� ���� 0
	foreach($b as $v) {
		$deductions = $v['���������'];
		foreach($data['���������'] as $key)
			if (isset($deductions[$key])) $c[$key] += $deductions[$key];
	}
	return array ($b, $c);
}