<?
require_once('engine/init.php');
require_once('header.php');
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\fs24\ul\qc �����\line ����������� ��������\par\par

\pard\plain\tx397\tqr\tx10050
\trowd\fs23\trpaddfl3\trpaddl57\trpaddfr3\trpaddr57
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206

<?
$count = $count1 = 0;
foreach($data['����������������'] as $v)
	if (!isset($v['�����������'])) {
		$d = $v['��������������'];
		if ($d == '����������') {
			?>\qc{\line\b ���������� �<?=strtoupper(countGreek(++$count1))?>�\b0}\cell\row\ql<?
		}
		elseif ($d == '���������')
			foreach($bills as $i) {
				echo ' ' . ++$count; ?>.\tab ��������� �� ������� <?=chk_bill($i['���������'])?>\tab (<?=chk($i['���������'])?>)\cell\row<?
			}
		elseif ($d == '���������� ��� ����������� �����������') {
			$bills_provider = bills_by_provider(getBillsType($bills, '*�������*'));
			$b = null;
			foreach($bills_provider as $k => $i)
				$b[$k] = calc_bills($i);
			foreach($b as $k => $i) {
				if ($i['����������'] >= 1500) echo ' ' . ++$count . '.\tab ���������� �����������: �' . $k . '�\cell\row';
				if ($i['����������'] >= 3000) echo ' ' . ++$count . '.\tab ����������� �����������: �' . $k . '�\cell\row';
			}
		}
		elseif ($d == '���������� ������������� ��������' && !count($data['��������']));
		elseif ($d == '�������� �������� ��' && !$bills_info['��������']);
		elseif ($d == '���������� ������������� ��������' && (!$bills_buy || empty($data['��������'])));
		elseif (!$bills_buy && (
						$d == '���������� ������ ��� ��������' ||
						$d == '���������� ��������� ��� ��������� ���������' && $data['������������'] != '��������� - ��������� - ��������' ||
						$d == '�������� �������������� �������' ||
						$d == '�������� �� ������� ������'));
		elseif (!$bills_contract && (
						$d == '���������� ��������� ��������� ��������' ||
						$d == '�������� �������������� �������'));
		elseif ($d == '�������' && !isset($bills_info['����������������������']['�������']));
		else {
			$a = isset($v['���']) ? '\line\tab (\i ' . chk_order($data[$v['���']]) . '\i0 )' : '';
			$c = $v['������'] > 1 ? "\\tab (x{$v['������']})" : '';
			echo ' ' . ++$count . '.\tab ' . $d . $a . $c . '\cell\row';
		}
	}

?>

\sect

