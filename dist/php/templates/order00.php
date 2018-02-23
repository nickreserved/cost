<?
require_once('engine/functions.php');
require_once('header.php');
require_once('engine/order.php');

if (!isset($bills_info)) $bills_info = calc_bills($data['���������']);
if (!isset($data['����'])) $data['����'] = $bills_info['������������'];

if (!isset($draft)) $draft = getEnvironment('draft', 'true');
?>

{

\sectd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134

<?
echo preOrder(isset($data['�����������']) ? $data['�����������'] : null, array('���� �����', '���������'), array(null), $draft);
echo '\pard\plain\par\par\par';
echo subjectOrder('������� ��������', array($data['�����������']));
?>
\pard\plain\fs28\tx567\tx1134\tx1701\tx2268\qj
\tab\b 1.\b0\tab ������� ��' ���� ��� �������� �������, ��� ��� ������������� �� ��������� ��� ���� ��� ������ ���������� ��� ������ <?=euro2str($data['����'])?> (<?=euro($data['����'])?>), ��� �<?=chk($data['������'])?>�\par\par
\qc{\b � � �  � � � � �}\par\qj\par
�������� ���� ����� ��� ��� �������� ��� �������� �������� ��� �� ������� ��� ��������������� ��� ������� ������� �� ���� ��������� ������ ��� �������� ����� ��� ��� ��� 8-2/2002/�'��/4� ��.\par\par
\tab\b 2.\b0\tab �������� ����������� ��� �������� ���������:\par\par
\tab\tab �.\tab\ul A����� ��� ��������\ul0  ������������ ��� ����:\par
\tab\tab\tab (1)\tab <?=inflection(man($data['����������������������']), 2)?> �� �������\par
\tab\tab\tab (2)\tab <?=inflection(man($data['��������������������']), 2)?> ���\par
\tab\tab\tab (3)\tab <?=inflection(man($data['��������������������']), 2)?> �� ����\par\par
\tab\tab �.\tab\ul ��������� ������� ��� ��������� ���������\ul0  ������������ ��� ����:\par
\tab\tab\tab (1)\tab <?=inflection(man($data['�����������������������������������']), 2)?> �� �������\par
\tab\tab\tab (2)\tab <?=inflection(man($data['���������������������������������']), 2)?> ���\par
\tab\tab\tab (3)\tab <?=inflection(man($data['���������������������������������']), 2)?> �� ����\par
<? if (isset($data['������������������������������'], $data['���������������������������'])) { ?>
\tab\tab �.\tab\ul �������� ��������\ul0  ������������ ��� ����:\par
\tab\tab\tab (1)\tab <?=inflection(man($data['������������������������������']), 2)?> �� �������\par
\tab\tab\tab (2)\tab <?=inflection(man($data['���������������������������']), 2)?> �� �����\par
<? } ?>
\par
\tab\b 3.\b0\tab ����������� ��������� ������� ���� �� �� �������� �������������� �� ���������� ����� <?=chk_date($data['������������������'])?>.\par\par
\tab\b 4.\b0\tab � ������ ��������� ���� ������� ���������.\par\par


<? if ($draft) draftOrder(); else bottomOrder(); ?>

\sect

}

