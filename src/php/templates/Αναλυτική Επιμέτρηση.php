<?
require_once('engine/init.php');
require_once('header.php');

if (!count($data['��������'])) trigger_error('��� �������� ��������', E_USER_ERROR);
if ($data['������������'] == '��������� - ��������� - ��������') trigger_error('� ��������� ���������� ����� ���������� �����', E_USER_ERROR);
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr\b <?=chk(toUppercase($data['������']))?>\par\par
\fs24\ul\qc ��������� ����������\par\par
\pard\plain\tx567\tx1134\tx1701\qj <?=chk(ucfirst($data['������޸����']))?> ������ ��� <?=$data['������������������������']?> � ��������� ��� ����� �<?=$data['����']?>�, <?=man_ext($data['���������'], 0)?> �������������� ��� ��������� ���������� ���� ��� �������� ��� ������������ ������������ ���� ��������:\par
<?
$count = 0;
foreach($data['��������'] as $v) {
	echo '\par\tab\b ' . ++$count . '.\tab\ul ' . chk($v['�������']) . '\ul0\b0  (' . num($v['��������']) . ' ' . chk_measure($v['������M�������']) . ')\par';
	if (count($v['�����'])) echo '\tab\tab ��� ��� ������� ���� ������������� �� �������� �����:\par';
	$count1 = 0;
	foreach($v['�����'] as $i)
		echo '\tab\tab ' . countGreek(++$count1) . '.\tab ' . num($i['��������']) . ' ' . chk_measure($i['������M�������']) . ' ' . chk($i['�����']) . '\par';
} ?>

\pard\plain\fs23\par\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx5103\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

