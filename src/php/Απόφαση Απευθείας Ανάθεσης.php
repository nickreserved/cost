<?php
require_once('init.php');
require_once('order.php');
require_once('header.php');

startOrder();
if ($data['��������� ��� ���������']) { ?>

\pard\plain\qr ���: <?=orelse2(!$draft, $data, '��� �������� ��������� ��������', '........')?>\par
\pard\plain\qc{\ul{\b ��������� ��� ���������}}\par\par

<?php } else { ?>

\pard\plain\qc{\ul{\b �� ��������� ��� ���������}}\par\par

<?php
}
preOrderN(ifexist2(!$draft, $data, '������� ��������� ��������'), $draft, null,
		'������� ��������� �������� ��� ' . rtf(ucwords($data['������'])),
		array(
			'��.721/70 (��� �\' 251) ���� ������������ �������� ��� ���������� ��� ������� ��������',
			'N.2292/95 (��� �\' 35) ��������� ��� ���������� ���������� ������� ������, �������� ��� ������� ������� �������� ��� ����� ���������',
			'�.3861/10 (��� �\' 112) ��������� ��� ���������� �� ��� ����������� �������� ����� ��� ������� ��� ������������, ����������� ��� ��������������� ������� ��� ��������� "��������� ��������" ��� ����� ���������',
			'�.4270/14 ������ �������������� ����������� ��� ��������� (���������� ��� ������� 2011/85/��) - ������� ��������� ��� ����� ���������',
			'�.4412/16 (��� �\' 147) ��������� ��������� �����, ���������� ��� ��������� (���������� ���� ������� 2014/24/�� ��� 2014/25/��)�',
			'�.032/8/66625/�.15516/05 ��� 17/������� ������ (��� �\' 3495)',
			$data['������� �������� ����������']
		));
?>1.\tab ������� ����� �� �������:\par
\qc{\b � � � � � � � � � � � �}\par\qj
2.\tab ��� ������� ��� �������� ��� �<?=rtf($data['������'])?>�, ���� ��������:\par
<?php
$count = count($data['��������� ��� ���������']) > 1 ? 1 : 0;
$contracts = 0;
foreach($data['��������� ��� ���������'] as $per_contractor) {
	$invoices = $per_contractor['���������'];
	$prices = $per_contractor['�����'];
	$categories = calc_per_deduction_incometax_vat($invoices);
	$contractor = $invoices[0]['����������'];
	//TODO: ��� ���� ���������� �� ���������� ������ �� ��� ������������������
	$contract = get_contract($invoices[0]);
	if (isset($contract)) ++$contracts;
	echo '\tab ' . ($count ? greeknum($count++) . '.\tab ' : null);
	if (isset($contract['������'])) echo "��� �{$contract['������']}� ";
	echo ucfirst(get_contractor_title($invoices, 2, 2)) . " �{$contractor['��������']}�, ��� {$contractor['���']}";
	if (isset($contractor['��������'])) echo ', ��������: ' . $contractor['��������'];
	if (isset($contractor['���������'])) echo ', ���������: ' . $contractor['���������'];
	if (isset($contractor['��'])) echo ', �.�.: ' . $contractor['��'];
	if (isset($contractor['e-mail'])) echo ', e-mail: ' . $contractor['e-mail'];
	?>, �� �� �������� ��������� ���������� ��������.\par
<?php ob_start();	// Buffer �� ������������ ������ ?>
\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx454
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx3799
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx4819
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx6066
<? if (count($categories['���']) > 1) { ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx6633
<? } ?>
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx7654
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx8788
<? $c2 = ob_get_clean(); ?>

\pard\plain\fs21
\trowd\trhdr<?=$c2?>

\qc\b A/A\cell ���������\cell ������\cell ��������\cell<? if (count($categories['���']) > 1) echo ' ���\cell'; ?> ������\cell ������\b0\cell\row

\trowd<?=$c2?>

<?
$count_items = 0;
foreach($invoices as $invoice)
	foreach($invoice['����'] as $item) {
		?>\qr <?=++$count_items?>\cell\qj <?=rtf($item['�����'])?>\cell\qc <?=rtf($item['������ M�������'])?>\cell <?=num($item['��������'])?>\cell\qr <? if (count($categories['���']) > 1) echo percent($item['���']) . '\cell'; ?> <?=euro($item['���� �������'])?>\cell <?=euro($item['�������� ����'])?>\cell\row
<?
	}
?>

\pard\tx1\tqdec\tx8760\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx8788
\b ������ ����:\tab <?=euro($prices['������ ����'])?>\b0\cell\row<?
if ($contractor['�����'] != 'PRIVATE_SECTOR')
	foreach($categories['���������'] as $k => $v)
		echo '+ ��������� ' . $k . '%:\tab ' . euro($v) . '\cell\row' . PHP_EOL;
foreach($categories['���'] as $k => $v)
	echo '+ ��� ' . percent($k) . ':\tab ' . euro($v) . '\cell\row' . PHP_EOL;
echo '\b ������������:\tab ' . euro($prices['������������']) . '\b0\cell\row' . PHP_EOL;
foreach($categories['���������'] as $k => $v)
	echo '- ��������� ' . $k . '%:\tab ' . euro($v) . '\cell\row' . PHP_EOL;
echo '\b ��������:\tab ' . euro($prices['��������']) . '\b0\cell\row' . PHP_EOL;
foreach($categories['��'] as $k => $v)
	echo '- �� ' . percent($k) . ':\tab ' . euro($v) . '\cell\row' . PHP_EOL;
if (count($categories['��']))
	echo '\b �������� ��������:\tab ' . euro($prices['�������� ��������']) . '\b0\cell\row' . PHP_EOL;
echo '\pard\plain\sb120\sa120\fi567\tx1134\tx1701\tx2268\qj';
}
?> 3.\tab � �� ��� ������ ���� �������� �� �� �������� ��������:\par
\tab �.\tab ���: <?=$data['���']?>.\par
\tab �.\tab ��� �����: <?=$data['����� ��������������']?><?php
if ($data['����� ��������������'] != '����� �����')
	echo " ����� " . date('Y', $data['Timestamp ���������� ����������']);
?>.\par
\tab �.\tab ������������: �.�. <?=$data['��']?>.\par
4.\tab ���� �� ����� �������<?=$contracts ? ' �� ���� ' . ($contracts == 1 ? '��� ��������' : '��� ���������') . ' ���' : null?> �� ��������� ��� (�) �������� �����.\par
5.\tab �������� ����������� �����: <?=$data['������ ������']?>, ���������: <?=$data['����']?><?=isset($data['���������']) ? ", {$data['���������']}" : null?><?=isset($data['��������']) ? ", ��������: {$data['��������']}" : null?><?=isset($data['��']) ? ", �.�. {$data['��']}" : null?>.\par
<?php
if ($data['��������� ��� ���������']) { ?>
6.\tab � ������� ������� ��������� ��� ������ ��� ��� ��������.\par

<?php
}

postOrder($draft);

$to = array();
foreach($data['��������� ��� ���������'] as $per_contractor) {
	$contractor = $per_contractor['���������'][0]['����������'];
	//TODO: ��� ���� ���������� �� ���������� ������ �� ��� ������������������
	$a = $contractor['��������'];
	$pre = ' ('; $pre2 = ', ';
	if (isset($contractor['���������'])) { $a .= $pre . $contractor['���������']; $pre = $pre2; }
	if (isset($contractor['��'])) { $a .= $pre . $contractor['��']; $pre = $pre2; }
	if ($pre == $pre2) $a .= ')';
	$to[] = $a;
}
recipientTableOrder($to, array($data['������']));
?>

\sect

<?php
unset($a, $pre, $pre2, $to, $c2, $categories, $contract, $contractor, $contracts, $count, $count_items, $invoice, $invoices, $item, $k, $per_contractor);

rtf_close(__FILE__);