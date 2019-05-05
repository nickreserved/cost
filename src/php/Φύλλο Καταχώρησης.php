<?php
require_once('init.php');
require_once('header.php');
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

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
			echo '\qc{\line\b ���������� �' . strtoupper(countGreek(++$count1)) . '�\b0}\cell\row' . PHP_EOL . '\ql ';
			break;
		case '���������':
			foreach($data['���������'] as $i)
				echo ++$count . '.\tab ��������� ��\' ������� ' . invoice($i['���������']) . '\cell\row' . PHP_EOL;
			break;
		case '���������� ��������� ��������� ��� ��������� ���������':
			foreach($data['��������� ��� ���������'] as $per_contractor)
				if ($per_contractor['�����']['������ ����'] > 2500) {
					$c = 0;	// FLAGS: 1: ��������� ������, 2: ������ ���������
					foreach($per_contractor['���������'] as $i) {
						$c |= is_supply($i['���������']) ? 1 : 2;
						if ($c == 3) break;
					}
					if ($c & 1) echo ++$count . '.\tab ���������� ��������� ��������� ��� ��������� ��������� ���������� �' . $i['����������']['��������'] . '�\cell\row' . PHP_EOL;
					if ($c & 2) echo ++$count . '.\tab ���������� ��������� ��������� ��� ��������� ��������� ��������� �' . $i['����������']['��������'] . '�\cell\row' . PHP_EOL;
				}
			break;
		case '�������� ���������':
			$c = 0;	// FLAGS: 1: ��������� ������, 2: ������ ���������
			foreach($data['��������� ��� ���������'] as $per_contractor)
				if ($per_contractor['�����']['������ ����'] <= 2500)
					foreach($per_contractor['���������'] as $i) {
						$c |= is_supply($i['���������']) ? 1 : 2;
						if ($c == 3) break 2;
					}
			if ($c & 1) echo ++$count . '.\tab �������� ��������� ����������\cell\row' . PHP_EOL;
			if ($c & 2) echo ++$count . '.\tab �������� ��������� ���������\cell\row' . PHP_EOL;
			break;
		case '����':
		case '�������� �� ������� ������':
			foreach($data['���������'] as $i)
				if (is_supply($i['���������'])) goto def;
			break;
		case '��������� �������� �������':
			foreach($data['��������� ��� ���������'] as $per_contractor) {
				$contractor = $per_contractor['���������'][0]['����������'];
				if ($contractor['�����'] == 'PRIVATE_SECTOR')
					if ($per_contractor['�����']['������ ����'] > 2500)
						echo ++$count . '.\tab ��������� �������� ������� �' . $contractor['��������'] . '�\cell\row' . PHP_EOL;
			}
			break;
		case '���������� ��� ����������� �����������':
			foreach($data['��������� ��� ���������'] as $per_contractor) {
				$contractor = $per_contractor['���������'][0]['����������'];
				if ($contractor['�����'] == 'PRIVATE_SECTOR') {
					$mixed = $per_contractor['�����']['������������'];
					$name = $contractor['��������'];
					if ($mixed > 1500) echo ++$count . '.\tab ���������� �����������: �' . $name . '�\cell\row' . PHP_EOL;
					if ($mixed > 3000) echo ++$count . '.\tab ����������� �����������: �' . $name . '�\cell\row' . PHP_EOL;
				}
			}
			break;
		case '�������� �������� ��':
			if ($data['�����']['��']) goto def;
			break;
		case '������� �������� ����������':
		case '��� ����������� ���������':
		case '������� ��������� ��������':
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

unset($count, $count1, $content_item, $i, $contractor, $per_contractor, $a, $c, $mixed, $net);
?>

\sect

<?php rtf_close(__FILE__); ?>