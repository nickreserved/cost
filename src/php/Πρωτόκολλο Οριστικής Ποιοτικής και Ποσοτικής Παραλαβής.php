<?php
require_once('init.php');
require_once('header.php');

foreach($data['��������� ��� ���������'] as $per_contractor) {
	// ������ ��� �� ����� ��� ���������� �� ��������� �������
	if ($per_contractor['�����']['������ ����'] <= 2500) continue;
	$invoices = $per_contractor['���������'];
	$contract = get_contract($invoices[0]);
	$contract = $contract['�������'];
	foreach(get_invoices_by_category($invoices) as $category => $invoices) {
		// ������� �� �� ���������, ��� ������ '1/31-12-19, 9/1-12-19 ��� 5/31-1-19'
		$invoice_list = get_names($invoices, '���������');
		// � ���������� ��� �������� ���������� ��� �� ����������
		$newer_invoice_date = get_newer_invoice_date($invoices);
		// ������� �������� ��� �������� ���� ��� ���������� ������� �� �� ����� ����������
		if ($category == '��������� ������')
			$a = array(
				'����������', '����������', '����������', '��� ����������', '��� ����', '��� �����',
				'\tab 3.\tab �� ����� ����� ��������������� ������ ����� ����� ��� �������� ��� ����������� ��� ����������� ������.\par',
				'� �����������');
		else {
			$c = $invoices[0]['����������']['�����'] == 'PRIVATE_SECTOR'
					? array('��� ��������', '� ���������')
					: array('��� ��������', '� ��������');
			$a = array('���������', '���������', '���������', $c[0], '���� ����������� ���������',
				'��� ����������� ���������', null, $c[1]);
		}
		// �������� ����������� - ������ ������� �� ��� ������ ����������
		$c = count($invoices) > 1 ? '�' : '�';
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr <?=rtf($data['������'])?>\par\par
\fs24\qc\b ���������� ��������� ��������� ��� ��������� ��������� <?=$a[2]?>\par\par
\pard\plain\sb120\sa120\tx567\tx1134\tx1701\qj
\tab 1.\tab ������ ��� <?=$newer_invoice_date?> ������� � �������� �������������� ��� ��������� <?=$a[1]?>, ��� ������������ �� ��� <?=order($data['��� ����������� ���������'])?> ��� �� ������ ���� �������� ��� <?=$a[0]?> ��� ����������� ��� <?=$a[3]?> �<?=$invoices[0]['����������']['��������']?>�. �������� ���� ��:\par
\tab\tab �.\tab <?=person_ext($data["�������� ��������� $a[1]"], 0)?>, �������� ��� ���������.\par
\tab\tab �.\tab <?=person_ext($data["� ����� ��������� $a[1]"], 0)?>, ���\par
\tab\tab �.\tab <?=person_ext($data["� ����� ��������� $a[1]"], 0)?>, ���� ��� ���������.\par
\tab 2.\tab � �������� ���� ����� �����:\par
\tab\tab �.\tab ���� ����� ��� <?=$contract?> ��������.\par
\tab\tab �.\tab ��� �������� ��� �������� ������ ��� ���������� <?=$a[4]?> ��� ����������� ���� �������� �������.\par
\tab\tab �.\tab �<?=$c?> ��' ������� <?=$invoice_list?> ��������<?=$c?>.\par
\qc{\b � � � � � � � � �}\par
\qj ��� �������� <?=$a[5]?>, ���� ������������ ��<?=$c?> �������� ��������<?=$c?>.\par
<?=$a[6]?>

\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\cellx3402\clftsWidth1\cellx6804\clftsWidth1\cellx10206\qc
- � -\line ��������\line\line\line <?=rtf($data["�������� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["�������� ��������� $a[1]"]['������'])?>\cell
- �� -\line ����\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>
\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>\cell
- � -\line <?=$a[7]?>\line\line\line <?=rtf($invoices[0]['����������']['��������'])?>\cell\row

\sect

<? } }

unset($per_contractor, $category, $invoices, $newer_invoice_date, $invoice_list, $contract, $a, $c);

rtf_close(__FILE__); ?>