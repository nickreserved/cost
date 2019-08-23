<?php
require_once('functions.php');

init(6);
$invoices = array();
foreach($data['����������'] as $per_contractor) {
	if (isset($per_contractor['�������'])) continue;
	$invoices = array_merge($invoices, $per_contractor['���������']);
}
foreach(get_invoices_by_category($invoices) as $a => $invoices) {
	// ������� �������� ��� �������� ���� ��� ���������� ������� �� �� ����� ����������
	$a = $a ? array('����������', '����������', '����������')
			: array('���������',  '���������',  '���������');
	// �������� ����������� - ������ ������� �� ��� ������ ����������
	$c = count($invoices) > 1 ? '�' : '�';
?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134\facingp\margmirror

\pard\plain\qr <?=rtf($data['�����������'])?>\line <?=rtf($data['������'])?>\par\par
\fs24\qc{\b �������� ��������� <?=$a[2]?>}\par\par

\qj ����������� � �����, �������� ��� ������� ��� ����������� ������ ������� <?=rtf(article(gender($data['������ ������']), 1) . ' ' . inflectPhrase($data['������ ������'], 1))?>, ��� ������������� ��<?=$c?> ��' ������� <?=get_names_key($invoices, '���������')?> ��������<?=$c?> <?=$a[0]?> ������� �� ��� �.092/235631/9 ��� 1982 ������� ����� ��� �.600.9/12/601600/�.129/13 ��� 2005/���/���/3�.\par
\pard\plain\qr\par <?=rtf($data['����']) . ', ' . strftime('%d %b %y', get_newer_timestamp($invoices))?>\par

\pard\plain\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx2929\clftsWidth1\clNoWrap\cellx5859\clftsWidth1\clNoWrap\cellx8788\qc
���������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ��������\line\line\line <?=rtf($data["�������� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["�������� ��������� $a[1]"]['������'])?>\cell
\line - �� -\line ����\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>
\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>\cell\row

\sect

<?php }

unset($a, $c, $invoices, $per_contractor);

rtf_close(__FILE__);