<?
require_once('engine/init.php');
require_once('header.php');

if (!$bills_hold_all) trigger_error('��� �������� ���������', E_USER_ERROR);

$c = count($bills_info['����������������������']) - 1;
if (($bills_info['�������������']['������']) > 0) $c++;
if (($bills_info['��������']) > 0) $c++;
$c = floor(8335 / $c);
$d = 3188;
?>

\sectd\lndscpsxn\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b <?=chk(toUppercase($data['������']))?>\par
\ul\qc ������������� ��������� ��������� ���� ������\par\par

\pard\plain\fs20
\trowd\trhdr\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28\trqc
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx436
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx2042
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx3188
<? if (($bills_info['�������������']['������']) > 0) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>
<? } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=1436?>
<? if ($bills_fe) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>
<? }
for($z = 1; $z < count($bills_info['����������������������']); $z++) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>
<? } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx14030
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx15136

\qc\b A/A\cell ���������\cell ������ ����\cell<? if (($bills_info ['�������������']['������']) > 0) echo ' ���\cell' ?> ������������\cell
<?
if ($bills_fe) echo '��' . (count($bills_fe) == 1 ? '\line ' . percent(key($bills_fe)) : '') . '\cell';
foreach($bills_info['����������������������'] as $k => $v)
	if ($k != '������')
		echo " $k" . (count($bills_hold_all) == 1 ? '\line ' . percent($bills[0]['�������������������������'][$k]): '') . '\cell';
?>
 ���������<? if (count($bills_hold_all) == 1) echo '\line ' . percent($bills[0]['�������������������������']['������'])?>\cell ��������\b0\cell\row

<? $count = 0;
foreach($bills_hold_all as $v) {
	if (count($bills_hold_all) > 1) {
		?>\qc\b\cell\cell\cell<?
		if (($bills_info['�������������']['������']) > 0) echo '\cell';
		?>\cell<?
		if ($bills_fe) echo '\cell ';
		foreach($bills_info['����������������������'] as $k => $i)
			if ($k != '������') echo (isset($v[0]['�������������������������'][$k]) ? percent($v[0]['�������������������������'][$k]) : '') . '\cell ';
		echo percent($v[0]['�������������������������']['������']) . '\cell\cell\row\b0';
	}

	foreach($v as $i) {
		?>\qr <?=++$count?>\cell\qc <?=chk_bill($i['���������'])?>\cell\qr <?=euro($i['����������'])?>\cell <?
		if (($bills_info['�������������']['������']) > 0) echo euro($i['�������������']['������']) . '\cell ';
		echo euro($i['������������']) . '\cell ';
		if ($bills_fe) echo euro($i['��������']) . '\cell ';
		foreach($bills_info['����������������������'] as $k => $t)
			if ($k != '������') echo (isset($i['����������������������'][$k]) ? euro($i['����������������������'][$k]) : '') . '\cell ';
		echo euro($i['����������������������']['������']) . '\cell ' . euro($i['��������']) . '\cell\row';
	}
} ?>

\qr\b\cell ������\cell <?=euro($bills_info['����������'])?>\cell
<? if (($bills_info['�������������']['������']) > 0) echo euro($bills_info['�������������']['������']) . '\cell ' ?>
<?=euro($bills_info['������������'])?>\b0\cell<?
if ($bills_fe) echo ' ' . euro($bills_info['��������']) . '\cell';
foreach($bills_info['����������������������'] as $k => $v)
	if ($k != '������') echo ' ' . euro($bills_info['����������������������'][$k]) . '\cell';
?>\b <?=euro($bills_info['����������������������']['������'])?>\cell
<?=euro($bills_info['��������'])?>\cell\row

\pard\plain\qr <?=chk($data['����']) . ', ' . $data['������������������������������']?>\par


\pard\plain\fs23
\trowd\trkeep\cellx7568\cellx15136\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

