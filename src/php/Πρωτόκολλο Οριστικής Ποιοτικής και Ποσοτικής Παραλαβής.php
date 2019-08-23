<?php
require_once('functions.php');
init(7);

if (isset($data['���������']))
	foreach($data['���������'] as $per_contract) {
		$invoices = $per_contract['���������'];
		foreach(get_invoices_by_category($invoices) as $a => $invoices) {
			// ������� �������� ��� �������� ���� ��� ���������� ������� �� �� ����� ����������
			$a = $a ? array('����������', '����������', '����������', '��� ����', '��� �����',
						'\tab 3.\tab �� ����� ���� ��������������� ������ ����� ����� ��� �������� ��� ����������� ��� ����������� ������.\par')
					: array('���������', '���������', '���������', '���� ���������', '��� ���������', null);
			// �������� ����������� - ������ ������� �� ��� ������ ����������
			$c = count($invoices) > 1 ? '�' : '�';
?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr <?=rtf($data['������'])?>\par\par
\fs24\qc\b ���������� ��������� ��������� ��� ��������� ��������� <?=$a[2]?>\par\par
\pard\plain\sb120\sa120\tx567\tx1134\tx1701\qj
\tab 1.\tab ������ ��� <?=strftime('%d %b %y', get_newer_timestamp($invoices))?> ������� � �������� �������������� ��� ��������� <?=$a[1]?>, ��� ������������ �� ��� <?=$data['��� ����������� ���������']['���������']?> ��� �� ������ ���� �������� ��� <?=$a[0]?> ��� ����������� ��� ��� ���������� �<?=$per_contract['����������']['��������']?>�. ��� ���������� �������� ���� ��:\par
\tab\tab �.\tab <?=personi($data["�������� ��������� $a[1]"], 0)?>, �������� ��� ���������.\par
\tab\tab �.\tab <?=personi($data["� ����� ��������� $a[1]"], 0)?>, ���\par
\tab\tab �.\tab <?=personi($data["� ����� ��������� $a[1]"], 0)?>, ���� ��� ���������.\par
\tab 2.\tab � �������� ���� ����� �����:\par
\tab\tab �.\tab ���� ����� ��� <?=$per_contract['�������']['�������']?> ��������.\par
\tab\tab �.\tab ��� �������� ��� �������� ������ ��� ���������� <?=$a[3]?> ��� ����������� ���� �������� �������.\par
\tab\tab �.\tab �<?=$c?> ��' ������� <?=get_names_key($invoices, '���������');?> ��������<?=$c?>.\par
\qc{\b � � � � � � � � �}\par
\qj ��� �������� <?=$a[4]?>, ���� ������������ ��<?=$c?> �������� ��������<?=$c?>.\par
<?=$a[5]?>

\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\cellx3402\clftsWidth1\cellx6804\clftsWidth1\cellx10206\qc
- � -\line ��������\line\line\line <?=rtf($data["�������� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["�������� ��������� $a[1]"]['������'])?>\cell
- �� -\line ����\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>
\line\line\line <?=rtf($data["� ����� ��������� $a[1]"]['�������������'])?>\line <?=rtf($data["� ����� ��������� $a[1]"]['������'])?>\cell
- � -\line ����������\line\line\line <?php if (isset($per_contract['����������']['�������������'])) echo rtf($per_contract['����������']['�������������']) . '\line '; ?>���������� �����������\cell\row

\sect

<?
		}
	}

unset($a, $c, $invoices, $per_contract);

rtf_close(__FILE__); ?>