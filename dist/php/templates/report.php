<?
require_once('engine/functions.php');
require_once('header.php');

if (!isset($bills)) $bills = $data['���������'];
if (!isset($bills_info)) $bills_info = calc_bills($bills);
if (!isset($bills_warrant)) $bills_warrant = getBillsType($bills, '��/���');
if (!isset($bills_hold)) $bills_hold = bills_by_hold($bills);
if (!isset($bills_fe)) $bills_fe = bills_by_fe($bills);
if (!isset($bills_buy)) $bills_buy = getBillsCategory($data['���������'], '������ ���������', false);
?>

{

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b\fs28\ul\qc ������\par

\pard\plain\trowd\fs21\trqr\trautofit1
\clftsWidth1\clNoWrap\cellx2948
\b ����. \ul <?=chk(getBrigate($data['������������������']))?>\ul0\line
������ \ul <?=chk($data['���������������'])?>\ul0\b0\line
����� \ul <?=strftime('%b')?>\ul0\line
����� \ul <?=strftime('%Y')?>\ul0\line
������ \ul <?=chk($data['��'])?>\ul0\line
�� \ul <? if (isset($data['��'])) echo chk($data['��']); ?>\ul0\cell\row

\pard\plain\qj\ul <?=$prereport ? '������������' : '���������'?> ������� ��� �<?=chk($data['������'])?>�.\par\par

\pard\plain\fs21
\trowd\trhdr<?require('report$1.php');?>
\qc\b A/A\cell �����\cell ��������\cell<? if (count($bills_info['�������������']) > 2) echo ' ���\cell'; ?> ������\cell ������\b0\cell\row

<?
$count = 0;
foreach($bills as $v) {
	if (count($bills) > 1 && !$prereport) {
		require('report$2.php');
		echo '\qc\b ���������: ' . chk_bill($v['���������']) . '\b0  (���������: ' . percent($v['�������������������������']['������']) .
			' - ��: ' . percent($v['���������']) . ')\cell\row\trowd';
		require('report$1.php');
	}
	$items = $v['����'];
	foreach($items as $i) { ?>
\qr <?=++$count?>\cell\qj <?=chk($i['�����'])?>\cell\qc <?=num($i['��������'])?>\cell\qr <? if (count($bills_info['�������������']) > 2) echo percent($i['���']) . '\cell'; ?> <?=euro($i['�����������'])?>\cell <?=euro($i['������������'])?>\cell\row
<? } } ?>

\pard\tx1\tqdec\tx9667<?require('report$2.php');?>
\line\b ������ ����:\tab <?=euro($bills_info['����������'])?>\b0\cell\row
<?
$bwh = array();
if ($bills_warrant) $bwh = bills_by_hold($bills_warrant);
foreach($bwh as $k => $v) {
	$a = calc_bills($v); ?>
������������ ��������� <?=percent($k)?>:\tab <?=euro($a['����������������������']['������'])?>\b0\cell\row
<? }
foreach($bills_info['�������������'] as $k => $v) {
	if ($k != '������') { ?>
����������� ��� <?=percent($k)?>:\tab <?=euro($v)?>\cell\row
<? } } ?>
\b ������������:\tab <?=euro($bills_info['������������'])?>\b0\cell\row
<?
foreach($bills_hold as $k => $v) {
	$a = calc_bills($v); ?>
����������� ��������� <?=percent($k)?>:\tab <?=euro($a['����������������������']['������'])?>\b0\cell\row
<? } ?>
\b ��������:\tab <?=euro($bills_info['��������'])?>\b0\cell\row
<?
if (!$prereport) {
	foreach($bills_fe as $k => $v) {
		$a = calc_bills($v); ?>
������������� �� <?=percent($k)?>:\tab <?=euro($a['��������'])?>\b0\cell\row
<?
	}
	if (count($bills_fe)) { ?>
\b �������� ��������:\tab <?=euro($bills_info['����������������'])?>\b0\cell\row
<? } } ?>
\pard\plain\qr <?=chk($data['����']) . ', ' . now()?>\par


\pard\plain\fs23
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx<? if ($prereport) echo 5103; else echo '3402\clftsWidth1\clNoWrap\cellx6804'; ?>\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
<? if ($prereport) { ?>
\line - � -\line <?=chk(toUppercase($data['�������������']))?>\line\line\line <?=chk($data['�������������']['�������������'])?>\line <?=chk($data['�������������']['������'])?>\cell
<? } else { ?>
\line - � -\line ���\line\line\line <?=chk($data['���']['�������������'])?>\line <?=chk($data['���']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell
<? } ?>
\row


<? if (isset($bills_buy) && !$prereport) { ?>

\pard\page\plain <?=chk(getBrigate($data['������������������']))?>\par <?=chk($data['���������������'])?>\par
\qc{\fs28\b\ul ��������}\par\par
\qj ����������� � �����, ��������, ������ � �� ������ ��� ������� ��� ������ ��� ������������ ���� ������ ��������� ������� ������� �� ��� �.092.5/49/307251/02 ��� 85 ����. ���� (�� - ��� 35/86) ����� ��� ��� �.801/27/4144342414/24 ��� 83/���/���/1� ������ ���.\par\par

\pard\plain\fs23\par
\trowd\cellx5103\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ���\line\line\line <?=chk($data['���']['�������������'])?>\line <?=chk($data['���']['������'])?>\cell\row

\pard\plain\qj\par\par ����������� ��� ���� ������������� �� ������� ����������� ��� �� ������ �� �������� �������� ��� ���������� ���� ���� ���� ���������� ��� ��������� ��� ������ ��� ������������ ���� ������ ��������� �������.\par\par

\pard\plain\fs23\par
\trowd\cellx5103\cellx10206\qc
- � -\line ��������\line\line\line <?=chk($data['����������������������']['�������������'])?>\line <?=chk($data['����������������������']['������'])?>\cell
- �� -\line ����\line\line\line <?=chk($data['��������������������']['�������������'])?>\line <?=chk($data['��������������������']['������'])?>
\line\line\line <?=chk($data['��������������������']['�������������'])?>\line <?=chk($data['��������������������']['������'])?>\cell\row

<? } ?>

\sect

}

