<?
require_once('engine/init.php');
require_once('header.php');

if (strpos($data['������������'], '����������� ����������'))
	trigger_error('��� ������� ����� �� ������������ ������������ �� ��������� ��� � ����� ����� ��������� �� ���������� ����', E_USER_ERROR);

$a = $data['����������������'] == '�������� �����������';
$b = $data['����������������'] != '����� ����������';
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134

<?
echo preOrder(!$draft || isset($data['�����������']) ? $data['�����������'] : null, array(man_ext($data['���������'], 2), '���� ���������'), array(null), $draft);
echo '\pard\plain\par\par\par';
echo subjectOrder('������� ��������', array($data['�����������']));
?>
\pard\plain\fs24\tx567\tx1134\tx1701\tx2268\qj
\tab\b 1.\b0\tab ������� ��' ���� �� �������� ������� ���� ��� ������ ���������� ��� ������ <?=euro2str($data['����'])?> (<?=euro($data['����'])?>), ��� �<?=chk($data['������'])?>�\par\par
\qc{\b � � �  � � � � �}\par\qj\par
�������� ���� ����� ��� ��� �������� ��� �������� �������� ��� �� ������� ��� ��������������� ��� ������� ������� �� ���� ��������� ������ ��� ��������.\par\par
\tab\b 2.\b0\tab �������� ����������� ��� �������� ���������:\par\par
<? $count = 0;
if ($b) { ?>
\tab\tab <?=countGreek(++$count)?>.\tab\ul ����������� <?$a ? '��������' : '���������'?> �����������\ul0  <?=$data['������'] == $data['���������������'] ? '' : '��� �' . chk($data['���������������']) .'�, '?>������������ ��� ����:\par
\tab\tab\tab (1)\tab <?=man_ext($data['�������������������'], 2)?> �� �������\par
\tab\tab\tab (2)\tab <?=man_ext($data['�����������������'], 2)?> ���\par
\tab\tab\tab (3)\tab <?=man_ext($data['�����������������'], 2)?> �� ����.\par\par
<? } else { ?>
\tab\tab <?=countGreek(++$count)?>.\tab\ul A����� ��� ��������\ul0  ������������ ��� ����:\par
\tab\tab\tab (1)\tab <?=man_ext($data['����������������������'], 2)?> �� �������\par
\tab\tab\tab (2)\tab <?=man_ext($data['��������������������'], 2)?> ���\par
\tab\tab\tab (3)\tab <?=man_ext($data['��������������������'], 2)?> �� ����.\par\par
<? }
if ($a || !$b) { ?>
\tab\tab <?=countGreek(++$count)?>.\tab\ul ��������� ������� ��� ��������� ���������\ul0  ������������ ��� ����:\par
\tab\tab\tab (1)\tab <?=man_ext($data['�����������������������������������'], 2)?> �� �������\par
\tab\tab\tab (2)\tab <?=man_ext($data['���������������������������������'], 2)?> ���\par
\tab\tab\tab (3)\tab <?=man_ext($data['���������������������������������'], 2)?> �� ����.\par\par
<? }
if ($data['������������'] != '��������� - ��������� - ��������') { ?>
\tab\tab <?=countGreek(++$count)?>.\tab\ul ������ ��������\ul0  ������������ ��� ����:\par
\tab\tab\tab (1)\tab <?=man_ext($data['����������������������'], 2)?> �� �������\par
\tab\tab\tab (2)\tab <?=man_ext($data['�������������������'], 2)?> �� �����.\par\par
\tab\tab <?=countGreek(++$count)?>.\tab\ul ���������� ��� ��������� ���������\ul0  ������������ ��� ����:\par
\tab\tab\tab (1)\tab <?=man_ext($data['������������������������������������'], 2)?> �� �������\par
\tab\tab\tab (2)\tab <?=man_ext($data['����������������������������������'], 2)?> ���\par
\tab\tab\tab (3)\tab <?=man_ext($data['����������������������������������'], 2)?> �� ����.\par\par
'<? }
$count = 3;
if (isset($data['������������������'])) {?>\tab\b <?=$count++?>.\b0\tab ������� ��������� ������� ���� �� �� �������� �������������� �� ���������� ����� <?=chk_date($data['������������������'])?>.\par\par<? }
if ($b) {?>\tab\b <?=$count++?>.\b0\tab � ����������� �� ����� <?=$a || isset($data['��������������'], $data['����������������']) ? '��� ' . chk_datetime($data['��������������']) . ', ' . chk($data['����������������']) : '�� ��������'?>.\par\par<? } ?>

<? if ($draft) draftOrder(); else bottomOrder(); ?>

\sect

