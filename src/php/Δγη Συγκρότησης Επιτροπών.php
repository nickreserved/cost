<?php
require_once('functions.php');
require_once('order.php');

init(4);

start_35_20();
order_publish(ifexist($data, '��� ����������� ���������'));
order_header(ifexist2($output, $data, '��� ����������� ���������'), array('���� ���������'),
		array($data['������']), $output, null, '���������� ���������',
		array(
			'�.2690/1999 �������� ����������� ����������� (�\' 45)',
			'�.3213/2003 ������� ��� ������� ������������ ���������� ���������, �������� ���������� ��� ���������, ���������� ����� ������� ���������� ��� ����� ���������� ��������� (�\' 309)',
			'�.3861/2010 ��������� ��� ���������� �� ��� ����������� �������� ����� ��� ������� ��� ������������, ����������� ��� ��������������� ������� ��� ��������� "��������� ��������" ��� ����� ��������� (�\' 112)',
			'�.4412/2016 ��������� ��������� �����, ���������� ��� ��������� (�\' 147)'
		));
?>
1.\tab ��� ������� ��� ����������� ������� ��������� ���������� ��� ���������, ����� ��� ��������� ����� ��� ������� ����� �� ������� �������:\par
\qc{\b � � � � � � � � � � �}\par\qj
\tab �.\tab\b �������� �������������� ��� ��������� ����������\b0, ���� ��������:\par
\tab\tab (1)\tab <?=personi($data['�������� ��������� ����������'], 2)?> �� �������\par
\tab\tab (2)\tab <?=personi($data['� ����� ��������� ����������'], 2)?> ���\par
\tab\tab (3)\tab <?=personi($data['� ����� ��������� ����������'], 2)?> �� ����.\par
\tab �.\tab\b �������� ��������� ���������\b0, ���� ��������:\par
\tab\tab (1)\tab <?=personi($data['�������� ��������� ���������'], 2)?> �� �������\par
\tab\tab (2)\tab <?=personi($data['� ����� ��������� ���������'], 2)?> ���\par
\tab\tab (3)\tab <?=personi($data['� ����� ��������� ���������'], 2)?> �� ����.\par
\tab �.\tab\b �������� ����������� ����������� ��� ����������� ���������\b0, ���� ��������:\par
\tab\tab (1)\tab <?=personi($data['�������� �����������'], 2)?> �� �������\par
\tab\tab (2)\tab <?=personi($data['� ����� �����������'], 2)?> ���\par
\tab\tab (3)\tab <?=personi($data['� ����� �����������'], 2)?> �� ����.\par
\tab �.\tab\b �������� ����������� ���������\b0, ���� ��������:\par
\tab\tab (1)\tab <?=personi($data['�������� ���������'], 2)?> �� �������\par
\tab\tab (2)\tab <?=personi($data['� ����� ���������'], 2)?> ���\par
\tab\tab (3)\tab <?=personi($data['� ����� ���������'], 2)?> �� ����.\par
<?php if (is_expenditure() && $data['����']) { ?>
\tab �.\tab\b ���������� �����\b0, <?=article(gender($data['����� �����']['�������������']), 2)?> <?=personi($data['����� �����'], 2)?>.\par
\tab ��.\tab\b �������� ������ ��������\b0, ���� ��������:\par
\tab\tab (1)\tab <?=personi($data['�������� ������ ��������'], 2)?> �� ������� ���\par
\tab\tab (2)\tab <?=personi($data['����� ������ ��������'], 2)?> �� �����.\par
\tab �.\tab\b �������� ���������� ��� ��������� ���������\b0, ���� ��������:\par
\tab\tab (1)\tab <?=personi($data['�������� ���������� ��� ��������� ���������'], 2)?> �� �������\par
\tab\tab (2)\tab <?=personi($data['� ����� ���������� ��� ��������� ���������'], 2)?> ���\par
\tab\tab (3)\tab <?=personi($data['� ����� ���������� ��� ��������� ���������'], 2)?> �� ����.\par
<?php } ?>
2.\tab �� �������� ������ ����������� ����������� ������� �������� ��������� �� �������������� ��� ������� ��� ������������ ��� ������ 221 ��� (�) ��������. ����������:\par
\tab �.\tab\ul �������� �������������� ��� ��������� ���������� ��� �������� ��������� ���������\ul0:\par
\tab\tab (1)\tab ���������� ��� ��� �� ������ ��������� ��� ������� ������������ ��� ��������, ������������, �� ��������������, ������������� � ��� ��������������� �������� ��� ���� �������� ������������ ��� ��������, ������ ����������� ��� �� ������� � �������� ��������.\par
\tab\tab (2)\tab ��������� �� ������� ����������.\par
\tab\tab (3)\tab ������������ ��� ������� ��� ���������� �������� ���� ��� ���� ��� �������� ��� ��� ��������� ��� ����������� ��� �������� ��� ���������� �� ���� ��� ������������� ������ ���� �� ������� ��� �� ��� ����.\par
\tab\tab (4)\tab ���������� ��� �������� ������������ ��� ��������� ����������, ������� �� �� ����� 132 �� ��� ��������� ��� ������ 41 ��� �.4412/16.\par
\tab �.\tab\ul �������� ����������� ����������� ��� ����������� ���������\ul0:\par
\tab\tab (1)\tab ��������� ��� ��������� � �������� ���������� ��� ������������ � ���������.\par
\tab\tab (2)\tab ������� ��� ������������� ��� ������������ � ��������� ��� �� ��������� ���� ��� ���������� ������� �������� ��������.\par
\tab\tab (3)\tab ������� ��� ��������� ��� ���������.\par
\tab\tab (4)\tab ���������������� �� ���� ������������ � ����������, ��� ������� ������������� ����������� �� ��������������, �������������� �������� � ��������� �����������.\par
\tab\tab (5)\tab ���������� ��� ���������� ��� ������������ � ��������� ��� �� ����������, ��� �������� ��� ���������, ��� ���������� ��� �������������, ��� ����������� ��� ���������, �� �������� ��� �����������.\par
\tab\tab (6)\tab ���������� ��� ���� ���� ���� ��� ��������� ���� �� ���������� ��������.\par
\tab\tab (7)\tab ���������� ��� ���� ����, ��� ��������� ��� �� ������� ��� ������ ��� ���������, ��� ����� ��� ��� ��������� ��� ���������� ������, ���� ����� ������������ ��� �������� ��� ��� �������� ��� ��������.\par
\tab �.\tab\ul �������� ����������� ���������\ul0:\par
\tab\tab ���������� ��� ��� ������������� ���� ������� ���� ��������� ��� ��������� ��� ������������ ������� ��� ����������� ����� � ��� ������������ ����� ���� �� ������ ��� �������� ��� ���������.\par
3.\tab � ������ ��� ������������ ������� ����� 2 ��� ��� �� ����� ������ ��� ������������� ��� �� ��� ���� �������� ��������� ����.\par
4.\tab ����������� ����� ��� <?=rtf(article(gender($data['������ ������']), 0) . ' ' . $data['������'])?> ��� �� ������� ������� �� ������, ���� ��� 150.000,00� � 300.000,00� ��� ��������� �����, ������������� ���, ������� �� �� (�) �������, \ul ���\ul0  ��������� ��������� �������� ������� ������� ������ ����ӻ ����� 90 ������ ��� �������� ��� �������� ��������, ��� �� ������ ��� �������� ��� ��������� (�������� ��� �������������� ����).\par
5.\tab ��������� �������: <?=personi($data['����� ��������'], 0)?>, ���. <?=rtf($data['��������'])?>.\par

<?php order_footer($output); ?>

\sect

<?php

rtf_close(__FILE__);