<?
require_once('engine/init.php');
require_once('header.php');
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr\b <?=chk(toUppercase($data['������']))?>\par\par
\fs24\ul\qc ��������\line ����������������� ����� ��� �����\par\par
\pard\plain\tx567\tx1134\qj
\tab � ����� ����� <?=man_ext($data['���������'], 0)?> ��� �������� �� ��� \ul <?=chk_order($data['�����������'])?>\ul0 , ��������� ��� � ���������������� ���� ��� ����� ���� <?=euro($data['����'])?>. ���� ��� ��������� ��� ��������� ������� ��������� ��� ��� �������� �� ������ ������ ���� <?=euro($bills_info['������������'])?>, ������ ������� <?=percent(100 - round(100 * $bills_info['������������'] / $data['����'], 1))?>.\par\par

\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx5103\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect
