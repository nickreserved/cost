<?
require_once('engine/init.php');
require_once('header.php');

if ($data['������������'] != '��������� - ��������� - ��������') trigger_error('� �������� �������������� ������� ��� ����� ���������� �����', E_USER_ERROR);

if ($bills_buy) {
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b\fs24\ul\qc ��������\line �������������� �������\par\par
\pard\plain\qj � ������������� . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . ��������� ��� �� ������������� ������ ��� �������� �� �������� ����� �� �������:\par

\pard\trowd\trhdr\fs23\trautofit1\trpaddfl3\trpaddl57\trpaddfr3\trpaddr57
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx567
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx7540
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx8787
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx10206
\qc\b A/A\cell �����\cell ������\cell ��������\b0\cell\row
<?
$count = 0;
foreach($bills_buy as $v)
	foreach($v['����'] as $i) {
		?>\qr <?=++$count?>\cell\qj <?=chk($i['�����'])?>\cell\qc <?=chk_measure($i['������M�������'])?>\cell <?=num($i['��������'])?>\cell\row<?
	} ?>
\pard\plain\qr <?=chk($data['����']) . ', ' . now()?>\par

\pard\plain\fs23\ri5102\qc\b - � -\line �������\par

\sect

<? } ?>