<?php
require_once('init.php');
require_once('header.php');

$invoices = array();
foreach($data['��������� ��� ���������'] as $per_contractor) {
	// ������ ��� �� ����� ���������� �� ��������� �������
	if ($per_contractor['�����']['������ ����'] > 2500) continue;
	$invoices = array_merge($invoices, $per_contractor['���������']);
}
foreach(get_invoices_by_category($invoices) as $category => $invoices) {
	// ������� �� �� ���������, ��� ������ '1/31-12-19, 9/1-12-19 ��� 5/31-1-19'
	$invoice_list = get_names($invoices, '���������');
	// � ���������� ��� �������� ���������� ��� �� ����������
	$newer_invoice_date = get_newer_invoice_date($invoices);
	// ������� �������� ��� �������� ���� ��� ���������� ������� �� �� ����� ����������
	$a = $category == '��������� ������'
			? array('����������', '����������', '����������')
			: array('���������', '���������', '���������');
	// �������� ����������� - ������ ������� �� ��� ������ ����������
	$c = count($invoices) > 1 ? '�' : '�';
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr <?=rtf($data['�����������'])?>\line <?=rtf($data['������'])?>\par\par
\fs24\qc{\b �������� ��������� <?=$a[2]?>}\par\par

\qj ����������� � �����, �������� ��� ������� ��� ����������� ������ ������� ��� �������, ��� ������������� ��<?=$c?> ��' ������� <?=$invoice_list?> ��������<?=$c?> <?=$a[0]?> ������� �� ��� �.092/235631/9 ��� 1982 ������� ����� ��� �.600.9/12/601600/�.129/13 ��� 2005/���/���/3�.\par
\pard\plain\qr\par <?=rtf($data['����']) . ', ' . $newer_invoice_date?>\par

\pard\plain\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx3402\clftsWidth1\clNoWrap\cellx6804\clftsWidth1\clNoWrap\cellx10206\qc
���������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ��������\line\line\line <?=rtf($data["�������� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["�������� ��������� $a[1]"]['������'])?>\cell
\line - �� -\line ����\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>
\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>\cell\row

\sect

<? }

unset($per_contractor, $category, $invoices, $newer_invoice_date, $invoice_list, $a, $c);

rtf_close(__FILE__); ?>