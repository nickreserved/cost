<?
require_once('engine/init.php');
require_once('header.php');
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

<? foreach ($bills as $v) { ?>

\pard\plain
�����������:\b  <?=chk($v['�����������']['��������'])?>\b0\line
��� �������: �. �������\line
�.�.�. �������: 090153025\line\par

\pard\plain\fs21
\trowd\trhdr\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx567
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx5839
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx7086
<? if (count($v['�������������']) > 2) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx7653
<? } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx8787
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx10206
\qc\b A/A\cell �����\cell ��������\cell<? if (count($v['�������������']) > 2) echo ' ���\cell'; ?> ������\cell ������\b0\cell\row
<?
$count = 0;
foreach($v['����'] as $i) { ?>
\qr <?=++$count?>\cell\qj <?=chk($i['�����'])?>\cell\qc <?=num($i['��������'])?>\cell\qr <? if (count($v['�������������']) > 2) echo percent($i['���']) . '\cell'; ?> <?=euro($i['�����������'])?>\cell <?=euro($i['������������'])?>\cell\row
<? } ?>

\pard\tx1\tqdec\tx9667<?require('report$2.php');?>
\line\b ������ ����:\tab <?=euro($v['����������'])?>\b0\cell\row
<? if ($v['�����'] == '��/���') { ?>
������������ ��������� <?=percent($v['�������������������������']['������'])?>:\tab <?=euro($v['����������������������']['������'])?>\b0\cell\row
<? }
foreach($v['�������������'] as $k => $i) {
	if ($k != '������') { ?>
����������� ��� <?=percent($k)?>:\tab <?=euro($i)?>\cell\row
<? } } ?>
\b ������������:\tab <?=euro($v['������������'])?>\b0\cell\row
����������� ��������� <?=percent($v['�������������������������']['������'])?>:\tab <?=euro($v['����������������������']['������'])?>\b0\cell\row
\b ��������:\tab <?=euro($v['��������'])?>\b0\cell\row
<? if ($v['��������']) { ?>
������������� �� <?=percent($v['���������'])?>:\tab <?=euro($v['��������'])?>\b0\cell\row
\b �������� ��������:\tab <?=euro($v['����������������'])?>\b0\cell\row
<? } ?>

\pard\par\par\par\par

<? } ?>