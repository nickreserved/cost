<?
require_once('engine/init.php');
require_once('header.php');

if ($data['������������'] == '��������� - ��������� - ��������') trigger_error('�� ���������� ���������� ��� ��������� ��������� ����� ���������� �����', E_USER_ERROR);
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b <?=chk(toUppercase($data['������']))?>\par\par
\fs24\ul\qc ��������\line ��������� ��� �����\par\par
\pard\plain\tx567\tx1134\qj
\tab <?=chk(ucfirst($data['������޸����']))?> ������ ��� <?=$data['��������������������������������������']?> � �������� ���������� ��� ��������� ��������� ������������� ��� ����:\par
\tab\tab �. <?=man_ext($data['������������������������������������'], 2)?> �� �������\par
\tab\tab �. <?=man_ext($data['����������������������������������'], 2)?> ���\par
\tab\tab �. <?=man_ext($data['����������������������������������'], 2)?> �� ����\par
��� ������������ �� ��� \ul <?=chk_order($data['�����������'])?>\ul0 , ���������� ������ ��� ����� ��� ����� �<?=$data['����']?>�, ������� ����������� ��� ������������ ����� <?=man_ext($data['���������'], 1)?> ��������� �� �������� ���� �� ����� ������ ������������.\par\par

\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx2552\clftsWidth1\clNoWrap\cellx5103\clftsWidth1\clNoWrap\cellx7655\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ��������\line\line\line <?=chk($data['������������������������������������']['�������������'])?>\line <?=chk($data['������������������������������������']['������'])?>\cell
\line - �� -\line ����\line\line\line <?=chk($data['����������������������������������']['�������������'])?>\line <?=chk($data['����������������������������������']['������'])?>
\line\line\line <?=chk($data['����������������������������������']['�������������'])?>\line <?=chk($data['����������������������������������']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

