<?
require_once('engine/functions.php');
require_once('header.php');

if (!isset($bills_provider)) $bills_provider = bills_by_provider($data['���������']);

foreach ($bills_provider as $list) {
	$list_info = calc_bills($list);
	$provider = $list[0]['�����������'];
?>

{

\sectd\lndscpsxn\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\li11339 <?=chk(toUppercase($data['������']))?>\line <?=chk(toUppercase($data['�������']))?>\par
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
\qc <?=chk($provider['��������'])?>\line\b ��������\b0\line\line
<?
if (isset($provider['����'])) echo chk($provider['����']);
if (isset($provider['���������']) && isset($provider['����'])) echo ', ';
if (isset($provider['���������'])) echo chk($provider['���������']);
?>
\line\b ��������� (���� - ����)\b0\cell
<? if (isset($provider['��'])) echo chk($provider['��']); ?>
\line\b T.K.\b0\line\line
<? if (isset($provider['��������'])) echo chk($provider['��������']); ?>
\line\b ��������\b0\cell
<?=chk($provider['���'])?>\line\b �.�.�.\b0\line\line <?=chk($provider['���'])?>\line\b �.�.�.\b0\cell\row

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
<? foreach ($list as $v) { ?>
\qc <?=chk($v['���������'])?>\cell <?=chk($v['���������'])?>\cell\qr <?=euro($v['������������������������'])?>\cell\qc <?=percent($v['���������'])?>\cell\qr <?=euro($v['��������'])?>\cell\row
<? } ?>
\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx5669
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx8787
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15136
\qr ������\cell \qr <?=euro($list_info['������������������������'])?>\cell\qr <?=euro($list_info['��������'])?>\cell\row

\pard\plain\qr <?=chk($data['����']) . ', ' . now()?>\par


\pard\plain\fs23\trowd\trkeep\cellx7568\cellx15136\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

}

<? } ?>
