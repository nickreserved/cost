<?php
require_once('init.php');
require_once('header.php');

// ������ ������ ������
$c = count($data['���������']) + 3.6;	// 1.2 ��� ������ ����, ������������, ��������
if ($data['�����']['��'] > 0) $c++;
$c = floor(8901 / $c);
$d = 6236;
?>

\sectd\sbkodd\lndscpsxn\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr <?=rtf($data['������'])?>\line <?=strftime('%d %b %y', $data['���������� ���������� ����������'])?>\par\par
\qc\b\ul ��������� ��������\par\par

\pard\plain\fs20
\trowd\trhdr
<?php ob_start();	// Buffer �� ������������ ������ ?>
\trqc\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clvertalc\cellx1701
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clvertalc\cellx3402
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clvertalc\cellx4819
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d?>

\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=round(1.2 * $c)?>

<?php foreach($data['���������'] as $deduction_name) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>

<?php }
if ($data['�����']['��'] > 0) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>

<?php } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=round(1.2 * $c)?>

\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=round(1.2 * $c)?>

<? $c = ob_get_flush(); ?>
\qc\b ����������\cell ���������\cell e-mail\cell ���\cell ������\line ����\cell <?php
foreach($data['���������'] as $deduction_name)
	echo "$deduction_name\cell ";
if ($data['�����']['��'] > 0) echo '��\cell ';
echo '������������\cell ��������\line ��������\b0\cell\row' . PHP_EOL;
echo '\trowd' . $c . PHP_EOL;

foreach($data['����������'] as $per_contractor) {
	$contractor = $per_contractor['����������'];
	$prices = $per_contractor['�����'];
	echo '\ql ' . rtf($contractor['��������']) . '\cell ' . rtf(ifexist($contractor, '���������'))
			. '\cell ' . str_replace('@', '\zwbo @', rtf(ifexist($contractor, 'e-mail'))) . '\cell '
			. rtf($contractor['���']) . '\cell\qr ' . euro($prices['������ ����']) . '\cell ';
	$deductions = calc_partial_deductions($per_contractor['���������']);
	foreach($data['���������'] as $deduction_name)
		echo euro(ifexist($deductions, $deduction_name)) . '\cell ';
	if ($data['�����']['��'] > 0)
		echo euro(ifexist($prices, '��')) . '\cell ';
	echo euro($prices['������������']) . '\cell ';
	echo euro($prices['�������� ��������']) . '\cell\row' . PHP_EOL;
}

$prices = $data['�����'];
$deductions = calc_partial_deductions($data['���������']);
echo '\qr\b\cell\cell\cell ������\cell ';
echo euro($prices['������ ����']) . '\cell ';
foreach($data['���������'] as $deduction_name)
	echo euro(ifexist($deductions, $deduction_name)) . '\cell ';
if ($prices['��'] > 0) echo euro($prices['��']) . '\cell ';
echo euro($prices['������������']) . '\cell ';
echo euro($prices['�������� ��������']) . '\b0\cell\row' . PHP_EOL . PHP_EOL;
?>
\pard\plain\li10204\qc\par
���������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\par

\sect

<?php
unset($c, $contractor, $d, $deduction_name, $deductions, $per_contractor, $prices);

rtf_close(__FILE__);