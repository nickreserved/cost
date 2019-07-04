<?php
require_once('init.php');
require_once('order.php');
require_once('report.php');
require_once('header.php');

if (has_direct_assignment()) {

start_35_20();
order_publish('��� �������� ��������� ��������', $draft);
order_header_recipients(ifexist2(!$draft, $data, '������� ��������� ��������'), $draft, null,
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
��� ������� ��� �������� ��� �<?=rtf($data['������'])?>�, ���� ��������:\par
<?php
$count = count($data['��������� ��� ���������']) > 1 ? 1 : 0;
$contracts = 0;
foreach($data['��������� ��� ���������'] as $per_contractor) {
	if (isset($per_contractor['�������'])) {
		if ($per_contractor['�������']['����� �����������'] != '��������� �������') continue;
		++$contracts;
	}
	$invoices = $per_contractor['���������'];
	$contractor = $per_contractor['����������'];
	echo '\tab ' . ($count ? greeknum($count++) . '.\tab ' : null);
	echo isset($per_contractor['�������']) && $per_contractor['�������']['������'] != $data['������']
		? "��� �{$per_contractor['�������']['������']}� " . get_contractor_title($invoices, 2, true)
		: ucfirst(get_contractor_title($invoices, 2, true));
	echo " �{$contractor['��������']}�, ��� {$contractor['���']}";
	if (isset($contractor['��������'])) echo ', ��������: ' . $contractor['��������'];
	if (isset($contractor['���������'])) echo ', ���������: ' . $contractor['���������'];
	if (isset($contractor['e-mail'])) echo ', e-mail: ' . $contractor['e-mail'];
	?>, �� �� �������� ��������� ���������� ��������.\par
<?php report($invoices, $per_contractor['�����']); ?>
\pard\plain\sb120\sa120\fi567\tx1134\tx1701\tx2268\qj
<?php } ?>

2.\tab � �� ��� ������ ���� �������� �� �� �������� ��������:\par
\tab �.\tab ���: <?=$data['���']?>.\par
\tab �.\tab ��� �����: <?=$data['����� ��������������']?><?php
if ($data['����� ��������������'] != '����� �����')
	echo " ����� " . date('Y', orelse($data, 'Timestamp ���������� ����������', time()));
?>.\par
\tab �.\tab ������������: �.�. <?=$data['��']?>.\par
3.\tab ���� �� ����� �������<?=$contracts ? ' �� ���� ' . ($contracts == 1 ? '��� ��������' : '��� ���������') . ' ���' : null?> �� ��������� ��� (�) �������� �����.\par
4.\tab �������� ����������� �����: <?=get_unit_address()?>.\par
<?php
if ($data['��������� ��� ���������']) { ?>
5.\tab � ������� ������� ��������� ��� ������ ��� ��� ��������.\par

<?php
}

order_footer($draft);

$to = array();
foreach($data['��������� ��� ���������'] as $per_contractor)
	if (get_invoice_tender_type($per_contractor) == '��������� �������')
		$to[] = get_contractor_recipient($per_contractor['����������']);
order_recipient_table($to, array($data['������']));
?>

\sect

<?php
unset($a, $pre, $pre2, $to, $c2, $categories, $contractor, $contracts, $count, $count_items, $invoice, $invoices, $item, $k, $per_contractor);

}	// if

rtf_close(__FILE__);