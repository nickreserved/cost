<?
require_once('engine/init.php');
require_once('header.php');

if ($data['����������������'] != '�������� �����������')
	trigger_error('��� ��������� <b>������� ����������</b>', E_USER_ERROR);
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134

<?
echo preOrder(!$draft || isset($data['�������������']) ? $data['�������������'] : null, getNewspapers($data['����������']), array(null), $draft, '��� (-1-)');
echo '\pard\plain\par\par\par';
echo subjectOrder('��������� �����������', array($data['�����������']));
?>
\pard\plain\sb57\sa57\fs24\tx567\tx1134\tx1701\tx2268\qj
\tab 1.\tab ����������� ���� ������������ ���� ��������� ��� ��� ��������� ���������.\par
\tab 2.\tab � ���������� �� ����� ���� ��� ����������� <?=getDates($data['����������������������'])?>.\par
\tab 3.\tab �� ������ ��� ����������� ������ �� ������������� ���� ��� ������� ��� ���� (-10-) ���������, �� ��������� ��� ������� ��� ���� (-7-) ���������.\par
\tab 4.\tab � ������ ��� ������� ��� ����� ��� ���������� �� �� ���������� ��� ��� (-1-) ����� ��� ���� (-3-) ��������.\par

<? if ($draft) draftOrder(); else bottomOrder(); ?>

\sect


\pard\plain\fs32\qc\b\ul
��������� �����������\par\par
\pard\plain\fs24\qj
������ ��������� �������\par
<?=toUppercase($data['������'])?>\par\par
<? $a = get_datetime($data['��������������']); ?>
������������� ��� ��� <?=chk($a[1])?> ��� ��� <?=chk($a[0])?> �� ����������� �������� ����������� �� ������������ ���������, <?=chk($data['����������������'])?>, ��� <?=chk($data['���������������'])?>.\par\par
����������� ���������� ��� �������� <?=chk($data['�����������������'])?> (���������: <?=chk($data['�����������������'])?>).\par

\sect

