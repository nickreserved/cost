<?
require_once('engine/init.php');
require_once('header.php');

if (!strpos($data['������������'], '����������� ���������� �� �����'))
	trigger_error('� �������� ���������� ��� ��������� ��������� �������� �� ��������� ��� ���� ��� ������� ����� �� ����������� ������������ �� ����� �������� � ��������', E_USER_ERROR);
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134

<?
echo preOrder(!$draft || isset($data['������������������������������']) ? $data['������������������������������'] : null, array('���� ���������'), array(null), $draft);
echo '\pard\plain\par\par\par';
echo subjectOrder('���������� ������������ �����', array($data['�����������'], $data['�������������']));
?>
\pard\plain\sb57\sa57\fs24\tx567\tx1134\tx1701\tx2268\qj
\tab\b 1.\b0\tab ������� ��' ���� �� (�) ������� ���� ��� ������ ���������� <?=euro2str($data['����'])?> (<?=euro($data['����'])?>) ��� �<?=chk($data['������'])?>�\par
\qc{\b � � � � � � � � � � �}\par\qj
��� �������� ��������� ��� ��������� ��������� ���� ��������:\par
\tab\tab �.\tab <?=man_ext($data['�����������������������������������'], 2)?> \b �� �������\b0\par
\tab\tab �.\tab <?=man_ext($data['���������������������������������'], 2)?> \b ���\b0\par
\tab\tab �.\tab <?=man_ext($data['���������������������������������'], 2)?> \b �� ����\b0 .\par\par
\tab\b 2.\b0\tab �������� ��� ��������� �� ������� ��� �������� ���.\par\par

<? if ($draft) draftOrder(); else bottomOrder(); ?>

\sect

