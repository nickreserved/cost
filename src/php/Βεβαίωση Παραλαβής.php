<?php
require_once('init.php');
require_once('header.php');

$invoices = array();
foreach($data['��������� ��� ���������'] as $per_contractor) {
	if (isset($per_contractor['�������'])) continue;
	$invoices = array_merge($invoices, $per_contractor['���������']);
}
foreach(get_invoices_by_category($invoices) as $category => $invoices) {
	// ������� �������� ��� �������� ���� ��� ���������� ������� �� �� ����� ����������
	$a = $category == '��������� ������'
			? array('����������', '����������', '����������')
			: array('���������', '���������', '���������');
	// �������� ����������� - ������ ������� �� ��� ������ ����������
	$c = count($invoices) > 1 ? '�' : '�';
?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr <?=rtf($data['�����������'])?>\line <?=rtf($data['������'])?>\par\par
\fs24\qc{\b �������� ��������� <?=$a[2]?>}\par\par

\qj ����������� � �����, �������� ��� ������� ��� ����������� ������ ������� ��� �������, ��� ������������� ��<?=$c?> ��' ������� <?=get_names_key($invoices, '���������')?> ��������<?=$c?> <?=$a[0]?> ������� �� ��� �.092/235631/9 ��� 1982 ������� ����� ��� �.600.9/12/601600/�.129/13 ��� 2005/���/���/3�.\par
\pard\plain\qr\par <?=rtf($data['����']) . ', ' . strftime('%d %b %y', get_newer_invoice_timestamp($invoices))?>\par

\pard\plain\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx3402\clftsWidth1\clNoWrap\cellx6804\clftsWidth1\clNoWrap\cellx10206\qc
���������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ��������\line\line\line <?=rtf($data["�������� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["�������� ��������� $a[1]"]['������'])?>\cell
\line - �� -\line ����\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>
\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>\cell\row

\sect

<? }

unset($a, $c, $category, $invoices, $per_contractor);

rtf_close(__FILE__); ?>