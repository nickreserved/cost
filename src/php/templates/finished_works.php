<?
require_once('engine/init.php');
require_once('header.php');

if (count($data['��������']) && $bills_buy) {
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b <?=chk(toUppercase($data['������']))?>\par\par
\fs28\ul\qc ����������\line ������������� ��������\par\par
\pard\plain\tx567\tx1134\tx1701\qj
\tab ������ ��� <?=$data['������������������������������']?> � ������������� �������� ������������ ��� ����:\par
\tab\tab �. <?=man_ext($data['����������������������'], 2)?> �� �������\par
\tab\tab �. <?=man_ext($data['��������������������'], 2)?> ���\par
\tab\tab �. <?=man_ext($data['��������������������'], 2)?> �� ����\par
��� ������������ �� ��� \ul <?=chk_order($data['�����������������'])?>\ul0 , ��������� ��� ��� ��� �������������� ��� ��������, ���������� ����� ���� ��������:\par
<?
$count = 0;
foreach($data['��������'] as $v) {
	echo '\par\tab\b ' . ++$count . '.\tab\ul ' . chk($v['�������']) . '\ul0\b0  (' . num($v['��������']) . ' ' . chk_measure($v['������M�������']) . ')\par';
	$count1 = 0;
	foreach($v['�����'] as $i)
		echo '\tab\tab ' . countGreek(++$count1) . '.\tab ' . chk($i['�����']) . ' (' . num($i['��������']) . ' ' . chk_measure($i['������M�������']) . ')\par';
} ?>

\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx2552\clftsWidth1\clNoWrap\cellx5103\clftsWidth1\clNoWrap\cellx7655\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ��������\line\line\line <?=chk($data['����������������������']['�������������'])?>\line <?=chk($data['����������������������']['������'])?>\cell
\line - �� -\line ����\line\line\line <?=chk($data['��������������������']['�������������'])?>\line <?=chk($data['��������������������']['������'])?>
\line\line\line <?=chk($data['��������������������']['�������������'])?>\line <?=chk($data['��������������������']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

<? } ?>