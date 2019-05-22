<?php
require_once('init.php');
require_once('header.php');
?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\fs24\ul\qc �����\line ����������� ��������\par\par

\pard\plain\tx397\tqr\tx10050
\trowd\fs23\trpaddfl3\trpaddl57\trpaddfr3\trpaddr57
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206

<?
$count = 0;		// �������� ���������������
$count1 = 0;	// �������� ����������

foreach($data['����� �����������'] as $content_item) {
	if (!$content_item['����������']) continue;
	switch($content_item['��������������']) {
		case '����������':
			echo '\qc{\line\b ���������� �' . strtoupper(greeknum(++$count1)) . '�\b0}\cell\row' . PHP_EOL . '\ql ';
			break;
		case '���������':
			foreach($data['���������'] as $a)
				echo ++$count . '.\tab ��������� ��\' ������� ' . invoice($a['���������']) . '\cell\row' . PHP_EOL;
			break;
		case '���������� ��������� ��������� ��� ��������� ���������':
			foreach($data['��������� ��� ���������'] as $per_contractor)
				if (isset($per_contractor['�������'])) {
					$c = 0;	// FLAGS: 1: ��������� ������, 2: ������ ���������
					foreach($per_contractor['���������'] as $a) {
						$c |= is_supply($a['���������']) ? 1 : 2;
						if ($c == 3) break;
					}
					if ($c & 1) echo ++$count . '.\tab ���������� ��������� ��������� ��� ��������� ��������� ���������� �' . $per_contractor['����������']['��������'] . '�\cell\row' . PHP_EOL;
					if ($c & 2) echo ++$count . '.\tab ���������� ��������� ��������� ��� ��������� ��������� ��������� �' . $per_contractor['����������']['��������'] . '�\cell\row' . PHP_EOL;
				}
			break;
		case '�������� ���������':
			$c = 0;	// FLAGS: 1: ��������� ������, 2: ������ ���������
			foreach($data['��������� ��� ���������'] as $per_contractor)
				if (!isset($per_contractor['�������']))
					foreach($per_contractor['���������'] as $a) {
						$c |= is_supply($a['���������']) ? 1 : 2;
						if ($c == 3) break 2;
					}
			if ($c & 1) echo ++$count . '.\tab �������� ��������� ����������\cell\row' . PHP_EOL;
			if ($c & 2) echo ++$count . '.\tab �������� ��������� ���������\cell\row' . PHP_EOL;
			break;
		case '����':
		case '�������� �� ������� ������':
			foreach($data['���������'] as $a)
				if (is_supply($a['���������'])) goto def;
			break;
		case '��������� �������� �������':
			foreach($data['��������� ��� ���������'] as $per_contractor) {
				$contractor = $per_contractor['����������'];
				if ($contractor['�����'] == '��������� ������' && isset($per_contractor['�������']))
						echo ++$count . '.\tab ��������� �������� ������� �' . $contractor['��������'] . '�\cell\row' . PHP_EOL;
			}
			break;
		case '�������� ������, ������������� ���������� �����������':
		case '�������� ������, �� �������������� ������������ ��������, ����� ��� ��':
			foreach($data['��������� ��� ���������'] as $per_contractor) {
				$contractor = $per_contractor['����������'];
				if ($contractor['�����'] == '��������� ������')
					echo ++$count . '.\tab ' . $content_item['��������������'] . ': �' . $contractor['��������'] . '�\cell\row' . PHP_EOL;
			}
			break;
		case '���������� ��� ����������� �����������':
			foreach($data['��������� ��� ���������'] as $per_contractor) {
				$contractor = $per_contractor['����������'];
				if ($contractor['�����'] == '��������� ������') {
					$mixed = $per_contractor['�����']['������������'];
					$a = $contractor['��������'];
					if ($mixed > 1500) echo ++$count . '.\tab ���������� �����������: �' . $a . '�\cell\row' . PHP_EOL;
					if ($mixed > 3000 || $per_contractor['�����']['������ ����'] > 2500)
						echo ++$count . '.\tab ����������� �����������: �' . $a . '�\cell\row' . PHP_EOL;
				}
			}
			break;
		case '�������� �������� ��':
			if ($data['�����']['��']) goto def;
			break;
		case '�������':
			if (isset($data['���������']))
				foreach($data['���������'] as $contract)
					echo ++$count . '.\tab ������� ' . contract($contract['�������']) . '\cell\row' . PHP_EOL;
			break;
		case '������� ��������� ��������': if (!has_direct_assignment()) break; // else continue
		case '������� �������� ����������':
		case '��� ����������� ���������':
			$content_item['���'] = $data[$content_item['��������������']];
			goto def;
def:	default:
			$a = isset($content_item['���']) ? '\line\tab (\i ' . order($content_item['���']) . '\i0 )' : '';
			$c = $content_item['������'] > 1 ? "\\tab (x{$content_item['������']})" : '';
			echo ++$count . '.\tab ' . $content_item['��������������'] . $a . $c . '\cell\row' . PHP_EOL;
	}
}

/*	/*elseif ($d == '���������� ������������� ��������' && !count($data['��������']));
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

unset($a, $c, $content_item, $contract, $contractor, $count, $count1, $mixed, $per_contractor);
?>

\sect

<?php rtf_close(__FILE__);