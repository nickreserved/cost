<?
require_once('engine/functions.php');
require_once('header.php');

if (!isset($bills)) $bills = $data['���������'];
if (!isset($bills_info)) $bills_info = calc_bills($bills);
if (!isset($bills_hold_all)) $bills_hold_all = bills_by_hold($bills, true);
if (!isset($bills_fe)) $bills_fe = bills_by_fe($bills);
reset($bills_fe);

$width = count($bills_info['����������������������']) - 1;
if (($bills_info['�������������']['������']) > 0) $width++;
if (($bills_info['��������']) > 0) $width++;
$width = floor(8335 / $width);
$pos = 3188;
?>

{

\sectd\landscape\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b <?=chk(toUppercase($data['������']))?>\par
\ul\qc ������������� ��������� ��������� ���� ������\par\par

\pard\plain\fs20
\trowd\trhdr\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28\trqc
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx436
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx2042
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx3188
<? if (($bills_info['�������������']['������']) > 0) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$pos+=$width?>
<? } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$pos+=1436?>
<? if (count($bills_fe)) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$pos+=$width?>
<? }
for($z = 1; $z < count($bills_info['����������������������']); $z++) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$pos+=$width?>
<? } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx14030
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx15136

\qc\b A/A\cell ���������\cell ������ ����\cell<? if (($bills_info ['�������������']['������']) > 0) echo ' ���\cell' ?> ������������\cell
<?
if (count($bills_fe)) echo '��' . (count($bills_fe) == 1 ? '\line ' . percent(key($bills_fe)) : '') . '\cell';
foreach($bills_info['����������������������'] as $k => $v)
	if ($k != '������')
		echo " $k" . (count($bills_hold_all) == 1 ? '\line ' . percent($bills[0]['�������������������������'][$k]): '') . '\cell';
?>
 ���������<? if (count($bills_hold_all) == 1) echo '\line ' . percent($bills[0]['�������������������������']['������'])?>\cell ��������\b0\cell\row

<? $count = 0;
foreach($bills_hold_all as $l) {

	if (count($bills_hold_all) > 1) { ?>
\qc\b\cell\cell\cell
<? if (($bills_info['�������������']['������']) > 0) echo '\cell'; ?>
\cell
<?
		if (count($bills_fe)) echo '\cell ';
		foreach($bills_info['����������������������'] as $k => $t)
			if ($k != '������') echo (isset($l[0]['�������������������������'][$k]) ? percent($l[0]['�������������������������'][$k]) : '') . '\cell ';
		echo percent($l[0]['�������������������������']['������']) . '\cell\cell\row\b0';
	}

	foreach($l as $v) { ?>
\qr <?=++$count?>\cell\qc <?=chk_bill($v['���������'])?>\cell\qr <?=euro($v['����������'])?>\cell
<? if (($bills_info['�������������']['������']) > 0) echo euro($v['�������������']['������']) . '\cell ' ?>
<?=euro($v['������������'])?>\cell
<?	if (count($bills_fe)) echo euro($v['��������']) . '\cell ';
		foreach($bills_info['����������������������'] as $k => $t)
			if ($k != '������') echo (isset($v['����������������������'][$k]) ? euro($v['����������������������'][$k]) : '') . '\cell ';
		echo euro($v['����������������������']['������'])?>\cell
 <?=euro($v['��������'])?>\cell\row
<? } } ?>

\qr\b\cell ������\cell <?=euro($bills_info['����������'])?>\cell
<? if (($bills_info['�������������']['������']) > 0) echo euro($bills_info['�������������']['������']) . '\cell ' ?>
<?=euro($bills_info['������������'])?>\b0\cell
<?	if (count($bills_fe)) echo ' ' . euro($bills_info['��������']) . '\cell';
		foreach($bills_info['����������������������'] as $k => $v)
			if ($k != '������') echo ' ' . euro($bills_info['����������������������'][$k]) . '\cell';?>
\b <?=euro($bills_info['����������������������']['������'])?>\cell
 <?=euro($bills_info['��������'])?>\cell\row

\pard\plain\qr <?=chk($data['����']) . ', ' . now()?>\par


\pard\plain\fs23
\trowd\trkeep\cellx7568\cellx15136\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

}

