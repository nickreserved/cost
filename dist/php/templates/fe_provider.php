<?
require_once('engine/init.php');
require_once('header.php');

$c = bills_with_fe($bills);
if (!$c) trigger_error('��� �������� ��������� �� ��', E_USER_ERROR);
$c = bills_by_provider($c);
foreach ($c as $v) {
	$b = calc_bills($v);
	$a = $v[0]['�����������'];
?>

\sectd\lndscpsxn\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain �������� ��� ��������\par

\pard\plain\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx6178
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx11227
\cellx15136
\qc <?=chk($data['������'])?>\line\b ��������\b0\line\line
<?
echo chk($data['����']);
if (isset($data['���������'])) echo ', ' . chk($data['���������']);
if (isset($data['��'])) echo ', ' . chk($data['��']);
?>
\line\b ��������� (���� - ���� - �.�.)\b0\line\line 090153025\line\b �.�.�.\b0\cell
����������� ������\line\b ������ �����\b0\line\line
<?
if (isset($data['�����������������'])) echo '����.: ' . chk($data['�����������������']);
if (isset($data['�����������������'])) echo '  ����.: ' . chk($data['�����������������']);
?>
\line\b ��. ���������\b0\line\line ��� �. �������\line\b �.�.�.\b0\cell
\b ��������\b0\line\line ��������������� ����� ��� ���������� ���� ������ ������ � ������� ��������� ��� ��� �������� ���, ���� �.�.�. (������. ��' �����. 1 ������ 37� ��� �.�. 3323/1955)\cell\row

\pard\plain\line I. �������� �����������\par
\trowd\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx6178
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx11227
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15136
\qc <?=chk($a['��������'])?>\line\b ��������\b0\line\line
<?
if (isset($a['����'])) echo chk($a['����']);
if (isset($a['���������']) && isset($a['����'])) echo ', ';
if (isset($a['���������'])) echo chk($a['���������']);
?>
\line\b ��������� (���� - ����)\b0\cell
<? if (isset($a['��'])) echo chk($a['��']); ?>
\line\b T.K.\b0\line\line
<? if (isset($a['��������'])) echo chk($a['��������']); ?>
\line\b ��������\b0\cell
<?=chk($a['���'])?>\line\b �.�.�.\b0\line\line <?=chk($a['���'])?>\line\b �.�.�.\b0\cell\row

\pard\plain\line I�. �������� ����������\par

\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx2835
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx5669
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx8787
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15136
\qc ����� ����������\cell ������� ����������\cell ������ ���� ����������\cell ���� ����� ��� �������������\cell\row
\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx2835
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx5669
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx8787
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx11961
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15136
<? foreach ($v as $i) { ?>
\qc <?=chk($i['���������'])?>\cell <?=chk_bill($i['���������'])?>\cell\qr <?=euro($i['������������������������'])?>\cell\qc <?=percent($i['���������'])?>\cell\qr <?=euro($i['��������'])?>\cell\row
<? } ?>
\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx5669
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx8787
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15136
\qr ������\cell \qr <?=euro($b['������������������������'])?>\cell\qr <?=euro($b['��������'])?>\cell\row

\pard\plain\qr <?=chk($data['����']) . ', ' . now()?>\par


\pard\plain\fs23\trowd\trkeep\cellx7568\cellx15136\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

<? } ?>