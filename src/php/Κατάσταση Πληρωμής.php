<?php
require_once('init.php');
require_once('header.php');

$c = count($data['���������']) + 3.6;	// 1.2 ��� ������ ����, ������������, ��������
if ($data['�����']['��'] > 0) $c++;
$c = floor(8901 / $c);
$d = 6236;
?>

\sectd\lndscpsxn\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr\b <?=rtf($data['������'])?>\line <?=$data['���������� ���������� ����������']?>\par\par
\ul\qc ��������� ��������\par\par

\pard\plain\fs20
\trowd\trhdr\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28\trqc
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx1701
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx3402
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx4819
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d?>

\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=round(1.2 * $c)?>

<?php foreach($data['���������'] as $v) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>

<?php }
if ($data['�����']['��'] > 0) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>

<?php } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=round(1.2 * $c)?>

\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=round(1.2 * $c)?>

\qc\b ����������\cell ���������\cell e-mail\cell ���\cell ������ ����\cell <?php
foreach($data['���������'] as $v)
	echo "$v\cell ";
if ($data['�����']['��'] > 0) echo '��\cell ';
echo '������������\cell ��������\b0\cell\row' . PHP_EOL;

$a = calc_pay_report();

foreach($a[0] as $v) {
	echo '\ql ' . rtf($v['��������']) . '\cell ';
	if (isset($v['����'])) {
		echo rtf($v['����']);
		if (isset($v['���������'])) echo ', ' . rtf($v['���������']);
	} ?>\cell <?
	echo rtf(ifexist($v, 'e-mail')) . '\cell ' . rtf($v['���']) . '\cell\qr ' . euro($v['������ ����']) . '\cell ';
	$i = $v['���������'];
	foreach($data['���������'] as $t)
		echo euro(ifexist($i, $t)) . '\cell ';
	if ($data['�����']['��'] > 0)
		echo euro(ifexist($v, '��')) . '\cell ';
	echo euro($v['������������']) . '\cell ';
	echo euro($v['��������']) . '\cell\row' . PHP_EOL;
}

echo '\qr\b\cell\cell\cell ������\cell ';
echo euro($data['�����']['������ ����']) . '\cell ';
foreach($data['���������'] as $t)
	echo euro(ifexist($a[1], $t)) . '\cell ';
if ($data['�����']['��'] > 0) echo euro($data['�����']['��']) . '\cell ';
echo euro($data['�����']['������������']) . '\cell ';
echo euro($data['�����']['��������']) . '\b0\cell\row' . PHP_EOL . PHP_EOL;
?>
\pard\plain\li10204\qc\par
���������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\par

\sect

<?php rtf_close(__FILE__); ?>