<?php
require_once('init.php');
require_once('header.php');

$c = count($data['���������']) + 3.6;	// 1.2 ��� ������ ����, ������������, ��������
if ($data['�����']['��'] > 0) $c++;
$c = floor(8901 / $c);
$d = 6236;
?>

\sectd\sbkodd\lndscpsxn\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr <?=rtf($data['������'])?>\line <?=$data['���������� ���������� ����������']?>\par\par
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

<?php foreach($data['���������'] as $v) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>

<?php }
if ($data['�����']['��'] > 0) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=$c?>

<?php } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=round(1.2 * $c)?>

\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\clvertalc\cellx<?=$d+=round(1.2 * $c)?>

<? $c2 = ob_get_flush(); ?>
\qc\b ����������\cell ���������\cell e-mail\cell ���\cell ������\line ����\cell <?php
foreach($data['���������'] as $v)
	echo "$v\cell ";
if ($data['�����']['��'] > 0) echo '��\cell ';
echo '������������\cell ��������\line ��������\b0\cell\row' . PHP_EOL;
echo '\trowd' . $c2 . PHP_EOL;



/* ���� ��� �� ������� ����� ������, ��� $a ������� ��� array �� ��� ��������. �� ����� ��������,
����� ��� array ��� ���� ���������, �� �� �������� ��� ���������� ��� �� ���������� ��� ����� ����
��� ���������� ��� ���������� ��� ������ ������������������� ������� �����, �������������,
���������, �� ��� ���� ��� ��������� ���������. �� ������� �������� ����� ��� array �� �� ����������
��� ��������� ��������� ���� ��� ���������� ���� ��� �����������. */
// ����������� ��� ���� ���������
$b = array();
$keys = array('������ ����', '������������', '��', '�������� ��������');
foreach(get_invoices_by_contractor($data['���������']) as $invoices) {
	$c = calc_sum_of_invoices_prices($invoices, $keys);
	$c['���������'] = calc_partial_deductions($invoices);
	$b[] = array_merge($invoices[0]['����������'], $c);
}
// ����������� ������� ��������� ��������� ��� ����� ���� �����������
// �� �������� ���������� ��� ������������� ����� �������� ��� ������
$c = array_fill_keys($data['���������'], 0);	// ������������ ��� ����������� �� ���� 0
foreach($b as $v) {
	$deductions = $v['���������'];
	foreach($data['���������'] as $key)
		if (isset($deductions[$key])) $c[$key] += $deductions[$key];
}
$a = array ($b, $c);

foreach($a[0] as $v) {
	echo '\ql ' . rtf($v['��������']) . '\cell ' . rtf(ifexist($v, '���������')) . '\cell '
			. str_replace('@', '\zwbo @', rtf(ifexist($v, 'e-mail'))) . '\cell '
			. rtf($v['���']) . '\cell\qr ' . euro($v['������ ����']) . '\cell ';
	$i = $v['���������'];
	foreach($data['���������'] as $t)
		echo euro(ifexist($i, $t)) . '\cell ';
	if ($data['�����']['��'] > 0)
		echo euro(ifexist($v, '��')) . '\cell ';
	echo euro($v['������������']) . '\cell ';
	echo euro($v['�������� ��������']) . '\cell\row' . PHP_EOL;
}

echo '\qr\b\cell\cell\cell ������\cell ';
echo euro($data['�����']['������ ����']) . '\cell ';
foreach($data['���������'] as $t)
	echo euro(ifexist($a[1], $t)) . '\cell ';
if ($data['�����']['��'] > 0) echo euro($data['�����']['��']) . '\cell ';
echo euro($data['�����']['������������']) . '\cell ';
echo euro($data['�����']['�������� ��������']) . '\b0\cell\row' . PHP_EOL . PHP_EOL;
?>
\pard\plain\li10204\qc\par
���������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\par

\sect

<?php
unset($a, $b, $c, $d, $v, $i, $t, $c2, $keys, $deductions, $invoices, $key);

rtf_close(__FILE__);