<?
require_once('engine/init.php');
require_once('header.php');

if ($data['����������������'] == '����� ����������')
	trigger_error('��������� �� ������ ������ �����������', E_USER_ERROR);
$a = $data['����������������'] == '�������� �����������';
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b <?=chk(toUppercase($data['������']))?>\par\par
\fs28\ul\qc ���������� ������\par\par
\pard\plain\tx567\tx1134\qj

<? $a = get_datetime($data['��������������']);
$b = isset($data['��������������'], $data['����������������']); ?>
\tab 1. <?=$b ? "������ ��� {$a[1]} �" : '�'?> ������������� �������� ������������ ��� ����:\par
\tab\tab �. <?=man_ext($data['�������������������'], 2)?> �� �������\par
\tab\tab �. <?=man_ext($data['�����������������'], 2)?> ���\par
\tab\tab �. <?=man_ext($data['�����������������'], 2)?> �� ����\par
��� ������������ �� ��� \ul <?=chk_order($data['��������������'])?>\ul0  ������ ��o� <?=$a ? '�������' : '��������'?> ���������� ��� �<?=chk($data['���������������'])?>�.\par\par
<?
if (isset($data['�������']) || isset($draft)) { ?>
\tab 2. � �������� ���������� ��� ���������� ��� ����������� ��� �������� �<?=chk($data['�������']['��������'])?>� (���: <?=chk($data['�������']['���'])?>, ���: <?=chk($data['�������']['���'])?>
<?
if (isset($data['�������']['��������'])) echo ', ��������: ' . chk($data['�������']['��������']);
if (isset($data['�������']['�.�.'])) echo ', �.�.: ' . chk($data['�������']['�.�.']);
if (isset($data['�������']['����'])) echo ', ����: ' . chk($data['�������']['����']);
if (isset($data['�������']['���������'])) echo ', ���������: ' . chk($data['�������']['���������']);
?>).\par
<? } else { ?>
\tab 2. � �������� ���������� ��� ��������� ��� ����������� ��� ���� �������� ������:\par
\tab\tab �. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .\par
\tab\tab �. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .\par
\tab\tab �. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .\par
<? } ?>

\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx3402\clftsWidth1\clNoWrap\cellx6804\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ��������\line\line\line <?=chk($data['�������������������']['�������������'])?>\line <?=chk($data['�������������������']['������'])?>\cell
\line - �� -\line ����\line\line\line <?=chk($data['�����������������']['�������������'])?>\line <?=chk($data['�����������������']['������'])?>
\line\line\line <?=chk($data['�����������������']['�������������'])?>\line <?=chk($data['�����������������']['������'])?>\cell\row


\sect

