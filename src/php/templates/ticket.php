<?
require_once('engine/functions.php');
require_once('header.php');

if (isset($data['����'])) $cost = $data['����'];
else {
	$a = calc_bills($data['���������']);
	$cost = $a['��������'];
	foreach($data['����������������'] as $v)
		if ($v['��������������'] == '�������� �������� ���������') {
			$cost = $a['������������'];
			break;
		}
}
?>


{

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\fs28\b\ul\qc �������� <?=euro($cost)?>\par\par
\pard\plain\qj � ������������� <?=man_ext($data['���������'], 0)?> ����� <?=euro2str($cost)?> (<?=euro($cost)?>), ��� �<?=chk($data['������'])?>� ������� ��� ���� <?=chk_order($data['�����������'])?> ��� <?=chk_order($data['�����������'])?>\par
\qr <?=now()?>\par

\pard\plain\fs23\par
\trowd\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx1587\clftsWidth1\clNoWrap\cellx2381\clftsWidth1\clNoWrap\cellx3515\clftsWidth1\clNoWrap\cellx6860\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\cell\line - � -\line ���\cell\line - � -\line ������\cell
\line - � -\line �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell
\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell\row



\pard\plain\par\par\par\par\brdrb\brdrs\par\pard\plain\par\par\par\par\par



\fs28\b\ul\qc �������������\par\par
\pard\plain\qj � ������������� <?=man_ext($data['���������'], 0)?>, ����������� ��� . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . �� ��������� <?=euro2str($cost)?> (<?=euro($cost)?>), ��� �<?=chk($data['������'])?>�.\par
\qr <?=now()?>\par

\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx3402\clftsWidth1\clNoWrap\cellx6804\clftsWidth1\clNoWrap\cellx10206\qc
��������\line ��� �� ������ ��� ���������\cell
- � -\line ������������\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell
- � -\line �����������������\cell\row


\sect

}


<?
// ��� �� ���� ������� ��������� ��� �������� ��� ��� ������
$draft = false;
require('order.php');
?>