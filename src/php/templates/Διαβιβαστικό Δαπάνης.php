<?
require_once('engine/init.php');
require_once('header.php');

if (!isset($prereport)) $prereport = false;

$attached = $prereport ? '��� (2)' : '1 �������';
$connect = $prereport ? null : array($data['�����������']);
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134

<?=preOrder(!$draft || isset($data['������������']) ? $data['������������'] : null, array($data['�������������']), array(null), $draft, $attached)?>
<?=subjectOrder('�������', $connect)?>
\pard\plain\fs24\tx567\tx1134\tx1701\tx2268\qj
<? if ($prereport) { ?>
\tab 1.\tab ��� ����������� ��������� ������ ������������ ������� ��� ����� �<?=chk($data['������'])?>� ����� <?=euro($data['����'])?>.\par\par
<? } else { ?>
\tab 1.\tab ��� ����������� ��������� ������ ��������� ������� ��� ����� �<?=chk($data['������'])?>� ����� <?=euro($data['����'])?>, ��� ��������������� ������.\par\par
<? } ?>
\tab 2.\tab ����������� ��� ��� ��������� ���.\par\par

<? if ($draft) draftOrder(); else bottomOrder(); ?>

\sect

