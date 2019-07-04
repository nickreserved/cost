<?php
require_once('init.php');
require_once('header.php');

if (!function_exists('contents_subfolder')) {

/** ������ ��� ������� ���� ����������.
 * @param array $content_item � ���������� ������������
 * @return � ������� ���������� ��� ����� '�2' */
function contents_subfolder($content_item) {
	$name = $content_item['��������������'];
	$pos = strpos($name, '�', 13);
	$countA = substr($name, 12, $pos - 12);
	$name = substr($name, $pos + 3);
	echo '\cell\cell\b\line ' . $countA . '\cell\line ' . $name . '\b0\cell\cell\row' . PHP_EOL;
	return $countA;
}

/** ������ ��� �������� ��� ����������. */
function contents_invoices() {
	global $data, $count, $countA;
	foreach($data['���������'] as $invoice)
		echo ++$count . '\cell ' . rtf($invoice['����������']['��������']) . '\cell ' . $countA
				. '\cell ��������� ' . invoice($invoice['���������']) . '\cell\cell\row' . PHP_EOL;
}

/** ������ ��� �������� ��� ����������� ��������� ��������� ��� ��������� ���������. */
function contents_acceptance_protocol() {
	global $data;
	foreach($data['��������� ��� ���������'] as $per_contractor)
		if (isset($per_contractor['�������'])) {
			$flags = 0;	// FLAGS: 1: ��������� ������, 2: ������ ���������
			foreach($per_contractor['���������'] as $invoice) {
				$flags |= is_supply($invoice['���������']) ? 1 : 2;
				if ($flags == 3) break;
			}
			if ($flags) {
				$f = function($a) use($per_contractor) {
					global $count, $unit, $countA;
					echo ++$count . '\cell ' . $unit . '\cell ' . $countA
							. '\cell ���������� ��������� ��������� ��� ��������� ��������� '
							. $a . ' �' . rtf($per_contractor['����������']['��������'])
							. '�\cell\cell\row' . PHP_EOL;
				};
				if ($flags & 1) $f('����������');
				if ($flags & 2) $f('���������');
			}
		}
}

/** ������ ��� �������� ��� ���������� ���������. */
function contents_acceptance_affirmation() {
	global $data;
	$flags = 0;	// FLAGS: 1: ��������� ������, 2: ������ ���������
	foreach($data['��������� ��� ���������'] as $per_contractor)
		if (!isset($per_contractor['�������']))
			foreach($per_contractor['���������'] as $invoice) {
				$flags |= is_supply($invoice['���������']) ? 1 : 2;
				if ($flags == 3) break 2;
			}
	if ($flags) {
		$f = function($a) {
			global $count, $unit, $countA;
			echo ++$count . '\cell ' . $unit . '\cell ' . $countA . '\cell �������� ��������� '
					. $a . '\cell\cell\row' . PHP_EOL;
		};
		if ($flags & 1) $f('����������');
		if ($flags & 2) $f('���������');
	}
}

/** ������ ��� �������� ��� ������������ �������� �������. */
function contents_criminal_record() {
	global $data, $count, $countA;
	foreach($data['��������� ��� ���������'] as $per_contractor) {
		$contractor = $per_contractor['����������'];
		if ($contractor['�����'] == '��������� ������' && isset($per_contractor['�������']))
			echo ++$count . '\cell ' . rtf($contractor['��������']) . '\cell ' . $countA
				. '\cell ��������� �������� �������\cell\cell\row' . PHP_EOL;
	}
}

/** ������ ��� �������� ��� ��������� ��������.
 * @param array $content_item � ���������� ������������ */
function contents_statement($content_item) {
	global $data, $count, $countA;
	foreach($data['��������� ��� ���������'] as $per_contractor) {
		$contractor = $per_contractor['����������'];
		if ($contractor['�����'] == '��������� ������')
			echo ++$count . '\cell ' . rtf($contractor['��������']) . '\cell ' . $countA
				. '\cell ' . rtf($content_item['��������������']) . '\cell\cell\row' . PHP_EOL;
	}
}

/** ������ ��� �������� ��� ����������� ��� ������������ ������������. */
function contents_tax_insurrance_currency() {
	global $data, $count, $countA;
	foreach($data['��������� ��� ���������'] as $per_contractor) {
		$contractor = $per_contractor['����������'];
		if ($contractor['�����'] == '��������� ������') {
			$mixed = $per_contractor['�����']['������������'];
			if ($mixed > 1500)
				echo ++$count . '\cell ' . rtf($contractor['��������']) . '\cell ' . $countA
					. '\cell ���������� �����������\cell\cell\row' . PHP_EOL;
			if ($mixed > 3000 || $per_contractor['�����']['������ ����'] > 2500)
				echo ++$count . '\cell ' . rtf($contractor['��������']) . '\cell ' . $countA
					. '\cell ����������� �����������\cell\cell\row' . PHP_EOL;
		}
	}
}

/** ������ ��� �������� ��� ���������. */
function contents_contract() {
	global $data, $count, $countA, $unit;
	if (isset($data['���������']))
		foreach($data['���������'] as $contract)
			echo ++$count . '\cell ' . $unit . '\cell ' . $countA . '\cell ������� '
					. contract($contract['�������']) . ' �� �' . rtf($contract['��������']['��������'])
					. '�\cell\cell\row' . PHP_EOL;
}

/** ������ ��� �������� ��������.
 * @param array $content_item � ���������� ������������
 * @param string $order � ��������� ��� �������� */
function contents_order($content_item, $order) {
	$b = null;
	$line2 = '\par ' . order($order, $b);
	contents_default_low($content_item, $b[5], $line2);
}

/** ������ ��� ������ �������.
 * @param array $content_item � ���������� ������������ */
function contents_default($content_item) {
	global $unit;
	$issuer = orelse($content_item, '�������', $unit);
	contents_default_low($content_item, $issuer, null);
}

/** ������ ��� ������ �������.
 * @param array $content_item � ���������� ������������
 * @param string $issuer � ������� ��� ��������
 * @param string $line2 ��� ������� ������ ���� ��� ��� ������ ��������� ��� ����������� */
function contents_default_low($content_item, $issuer, $line2) {
	global $count, $countA;
	$c = $content_item['������'] > 1 ? " (x{$content_item['������']})" : '';
	echo ++$count . '\cell ' . $issuer . '\cell ' . $countA . '\cell ' . $content_item['��������������']
			. $c . $line2 . '\cell\cell\row' . PHP_EOL;
}

/** ������ ��� �������� �� �������, � ��� ����.
 * @param array $content_item � ���������� ������������ */
function contents_debit_affirmation($content_item) {
	global $data;
	foreach($data['���������'] as $invoice)
		if (is_supply($invoice['���������'])) {
			contents_default($content_item);
			break;
		}
}

}



// ������������
$unit = rtf($data['������']);
?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\sa113\qc\fs24\b ����� ����������� ��������\par
\qj ������ �������: \b0{\ul <?=rtf($data['������'])?>}\par

\pard\plain\fs22
\trowd\trhdr
<?php ob_start();	// Buffer �� ������������ ������ ?>
\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clvertalc\cellx453
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clvertalc\cellx3288
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clvertalc\cellx3741
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clvertalc\cellx9637
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clvertalc\cellx10205
<? $c2 = ob_get_flush(); ?>
\qc\b �/�\cell �������\cell �/�\cell �������� ��������\cell ���.\b0\cell\row
<?php
echo '\trowd' . $c2 . '\qj ' . PHP_EOL;
$count = 0;		// �������� ���������������
$countA = null;	// �������� ����������

foreach($data['����� �����������'] as $content_item) {
	if (!$content_item['����������']) continue;
	$name = $content_item['��������������'];
	if (substr($content_item['��������������'], 0, 12) == '���������� �') $countA = contents_subfolder($content_item);
	else
		switch($name) {
			case '���������': contents_invoices(); break;
			case '���������� ��������� ��������� ��� ��������� ���������': contents_acceptance_protocol(); break;
			case '�������� ���������': contents_acceptance_affirmation(); break;
			case '����':
			case '�������� �� ������� ������': contents_debit_affirmation($content_item); break;
			case '��������� �������� �������': contents_criminal_record(); break;
			case '�������� ������, ������������� ���������� �����������':
			case '�������� ������, �� �������������� ������������ ��������, ����� ��� ��': contents_statement($content_item); break;
			case '���������� ��� ����������� �����������': contents_tax_insurrance_currency(); break;
			case '�������': contents_contract(); break;
			case '������� ��������� ��������': if (!has_direct_assignment()) break; // else continue
			case '������� �������� ����������':
			case '��� ����������� ���������': contents_order($content_item, $data[$content_item['��������������']]); break;
			default: contents_default($content_item); break;
		}
}

/*			case '�������� �������� ��':
				if ($data['�����']['��']) goto def;
				break;
	/*elseif ($d == '���������� ������������� ��������' && !count($data['��������']));
	elseif ($d == '���������� ������������� ��������' && (!$bills_buy || empty($data['��������'])));
	elseif (!$bills_buy && (
					$d == '���������� ������ ��� ��������' ||
					$d == '���������� ��������� ��� ��������� ���������' && $data['������������'] != '��������� - ��������� - ��������' ||
					$d == '�������� �������������� �������' ||
					$d == '�������� �� ������� ������'));
	elseif (!$bills_contract && (
					$d == '���������� ��������� ��������� ��������' ||
					$d == '�������� �������������� �������'));
	elseif ($d == '�������' && !isset($bills_info['����������������������']['�������']));*/

unset($c2, $content_item, $count, $countA, $name, $unit);
?>

\sect

<?php

rtf_close(__FILE__);