<?
require_once('engine/functions.php');
require_once('header.php');

if (!isset($bills)) $bills = $data['���������'];
if (!isset($bills_info)) $bills_info = calc_bills($bills);
if (!isset($bills_contract)) $bills_contract = getBillsCategory($bills, '������ ���������');
if (!isset($bills_buy)) $bills_buy = getBillsCategory($bills, '������ ���������', false);
?>

{

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\fs28\ul\qc �����\line ����������� ��������\par\par

\pard\plain\tx397\tx9638
\trowd\fs23\trpaddfl3\trpaddl57\trpaddfr3\trpaddr57
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206

<?
$f = $c = 0;
foreach($data['����������������'] as $v)
	if (!isset($v['�����������'])) {
		if ($v['��������������'] == '����������') {
			?>\qc{\line\b ���������� �<?=strtoupper(countGreek(++$f))?>�\b0}\cell\row\ql<?
		}
		elseif ($v['��������������'] == '���������') {
			foreach($bills as $b) {
				echo ' ' . ++$c; ?>.\tab ��������� ��' ������� <?=chk_bill($b['���������'])?>\cell\row<?
			}
		}
		else {
			if ($v['��������������'] == '�������� �������� ��' && !$bills_info['��������'] ||
			($v['��������������'] == '���������� ������ ��� ��������' || $v['��������������'] == '�������� �������������� �������') && !$bills_buy ||
			($v['��������������'] == '���������� ��������� ��������� ��������' || $v['��������������'] == '�������� �������������� �������') && !$bills_contract) continue;
			$a = isset($v['���']) ? ' ' . chk($data[$v['���']]) : '';
			$d = $v['������'] > 1 ? "\\tab (x{$v['������']})" : '';
			echo ' ' . ++$c . '.\tab ' . $v['��������������'] . $a . $d . '\cell\row';
		}
	}
?>

\sect

}

