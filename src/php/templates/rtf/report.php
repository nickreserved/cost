<?
require_once('engine/init.php');
require_once('header.php');

if (!$bills_hold_all) trigger_error('��� �������� ���������', E_USER_ERROR);

?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b\fs24\ul\qc ������\par

\pard\plain\trowd\fs21\trqr\trautofit1
\clftsWidth1\clNoWrap\cellx2948
\b ����. \ul <?=chk(getBrigate($data['������������������']))?>\ul0\line
������ \ul <?=chk($data['���������������'])?>\ul0\b0\line
<? $a = explode(' ', ($prereport ? now() : $data['������������������������������'])); ?>
����� \ul <?=$a[1]?>\ul0\line
����� \ul <?=$a[2]?>\ul0\line
������ \ul <?=chk($data['��'])?>\ul0\line
�� \ul <? if (isset($data['��'])) echo chk($data['��']); ?>\ul0\cell\row

\pard\plain\qj\ul <?=$prereport ? '������������' : '���������'?> ������� ��� �<?=chk($data['������'])?>�.\par\par

\pard\plain\fs21
\trowd\trhdr<?require('report$1.php');?>
\qc\b A/A\cell �����\cell ������\cell ��������\cell<? if (count($bills_info['�������������']) > 2) echo ' ���\cell'; ?> ������\cell ������\b0\cell\row

<?
$count = 0;
foreach($bills as $v) {
	if (count($bills) > 1 && !$prereport) {
		require('report$2.php');
		echo '\qc\b ���������: ' . chk_bill($v['���������']) . '\b0  (���������: ' . percent($v['�������������������������']['������']) .
			' - ��: ' . percent($v['���������']) . ')\cell\row\trowd';
		require('report$1.php');
	}
	foreach($v['����'] as $i) {
		?>\qr <?=++$count?>\cell\qj <?=chk($i['�����'])?>\cell\qc <?=chk_measure($i['������M�������'])?>\cell <?=num($i['��������'])?>\cell\qr <? if (count($bills_info['�������������']) > 2) echo percent($i['���']) . '\cell'; ?> <?=euro($i['�����������'])?>\cell <?=euro($i['������������'])?>\cell\row<?
	}
} ?>

\pard\tx1\tqdec\tx9667<?require('report$2.php');?>
\line\b ������ ����:\tab <?=euro($bills_info['����������'])?>\b0\cell\row<?
if ($bills_warrant) {
	$b = bills_by_hold($bills_warrant);
	if ($b) {
		foreach($b as $k => $v) {
			$a = calc_bills($v);
			?> ������������ ��������� <?=percent($k)?>:\tab <?=euro($a['����������������������']['������'])?>\b0\cell\row<?
		}
	}
}
foreach($bills_info['�������������'] as $k => $v) {
	if ($k != '������') {
		?> ����������� ��� <?=percent($k)?>:\tab <?=euro($v)?>\cell\row<?
	}
}
?>\b ������������:\tab <?=euro($bills_info['������������'])?>\b0\cell\row<?
if ($bills_hold) {
	foreach($bills_hold as $k => $v) {
		$a = calc_bills($v);
		?> ����������� ��������� <?=percent($k)?>:\tab <?=euro($a['����������������������']['������'])?>\b0\cell\row<?
	}
}
?>\b ��������:\tab <?=euro($bills_info['��������'])?>\b0\cell\row<?
if (!$prereport && $bills_fe) {
	foreach($bills_fe as $k => $v) {
		$a = calc_bills($v);
		?> ������������� �� <?=percent($k)?>:\tab <?=euro($a['��������'])?>\b0\cell\row<?
	}
	?>\b �������� ��������:\tab <?=euro($bills_info['����������������'])?>\b0\cell\row<?
}
?>\pard\plain\qr <?=chk($data['����']) . ', ' . ($prereport ? now() : $data['������������������������������'])?>\par


\pard\plain\fs23
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx3402\clftsWidth1\clNoWrap\cellx6804\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ���\line\line\line <?=chk($data['���']['�������������'])?>\line <?=chk($data['���']['������'])?>\cell
<? if ($prereport) { ?>
\line - � -\line <?=chk(toUppercase($data['�������������']))?>\line\line\line <?=chk($data['�������������']['�������������'])?>\line <?=chk($data['�������������']['������'])?>\cell
<? } else { ?>
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell
<? } ?>
\row

\sect

