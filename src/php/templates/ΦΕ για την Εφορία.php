<?
require_once('engine/init.php');
require_once('header.php');

$c = bills_with_fe($bills);
if (!$c) trigger_error('��� �������� ��������� �� ��', E_USER_ERROR);
$c = bills_by_month($c);
foreach ($c as $k => $v) {
	$a = calc_bills($v);
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\fs21\trowd\cellx7370\cellx10206
\ul ���� �� ���\line ���������� ����:\ul0  <?=strftime('%Y', $k)?>\line\ul �����:\ul0  <?=strftime('%b', $k)?>\cell
\ul ������:\line ������� �������:\line ���. ������:\cell\row

\pard\plain\qc{\b � � � � � �}\par\par
{\fs20 �������� ��������������� ����� ��� ���������� ���� ������ ������ � ������� ��������� ��� ��� �������� ���������, �.�.�., �.�.�.�. �.�.�. (����������� ��' ���������� 1 ������ 37� �.�. 3323/1955)}\par\par

\pard\plain\trowd
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx5670
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206
\qc <?=chk($data['������'])?>\line\b ��������\b0\line\line
<?
echo chk($data['����']);
if (isset($data['���������'])) echo ', ' . chk($data['���������']);
if (isset($data['��'])) echo ', ' . chk($data['��']);
?>
\line\b ��������� (���� - ���� - �.�.)\b0\line\line 090153025\line\b �.�.�.\b0\cell
����������� ������\line\b ������ �����\b0\line\line <?=chk($data['��������']) ?>
\line\b ��. ���������\b0\line\line ��� �. �������\line\b �.�.�.\b0\cell\row

\pard\plain\par\par


\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx3118
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx5386
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx8220
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206
\qc ����� ����������\cell ������ ����\cell ����������� �����\cell ���� �����\cell\row
<?
	$b = bills_by_fe($v);
	foreach($b as $i) {
		$d = calc_bills($i);
		echo '\ql ' . chk($i[0]['���������']) . '\cell\qr ' . euro($d['���������������']) . '\cell\qc ' . percent($i[0]['���������']) . '\cell\qr ' . euro($d['��������']) . '\cell\row';
	}
?>
\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx3118
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx5386
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206
\qr ������\cell <?=euro($a['���������������'])?>\cell <?=euro($a['��������'])?>\cell\row
\ql ����� ���� �����������\cell\cell\cell\row
\qr ������ ������\cell\cell\cell\row

\pard\plain\par\qc{\fs24\b\ul �������� ������}\par\par
\ql{\fs20 �������� �������� ��� �� �������� ��� ��������� ��� ����� ��� �������� ��� �������� �������.}\par\par
\qc {\ul � �����}\line\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\par\par

\trowd\cellx3402\cellx6804\cellx10206\qc\fs20
����������� - ���������\cell ������������\cell �����������\cell\row
\trowd\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\cellx1701\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx3402
\cellx5103\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx6804
\cellx8505\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206\qr
����������\cell\cell ����\cell\cell ����\cell\cell\row
����������\cell\cell ��. ����������\cell\cell ��. ����������\cell\cell\row
����������\cell\cell ����������\cell\cell ����������\cell\cell\row
\pard\plain\par
\trowd\cellx3402\cellx6804\cellx10206\qc
� ��������� - ��������\cell � �������\cell � ��������� �� ��������\cell\row
\pard\plain

\sect

\sectd\lndscpsxn\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qc{\fs24\b\ul ������� ������������}\par\par
{\fs20 ��� ��� ������ ������������� ���� ������ ����� � ��������� �� �������� ������������\line ����� ����������� ��� ������. ��' ��� ������. 1 ��� ������ 37� ��� �.�. 3323/1955.}\par\par

\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28\fs20
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx3175
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx4252
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx7262
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx9468
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx11169
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx12416
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx13946
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15137
��������\cell �.�.�.\cell ���������\cell ����� ����������\cell ���������\cell\ ������ ����\cell ������� �����\cell ���� �����\cell\row
<?
	foreach($v as $i) {
		$d = $i['�����������'];
		echo '\ql ' . chk($d['��������']) . '\cell\qc ' . chk($d['���']) . '\cell\ql ';
		if (isset($d['����'])) echo chk($d['����']);
		if (isset($d['���������']) && isset($d['����'])) echo ', ';
		if (isset($d['���������'])) echo chk($d['���������']);
		echo '\cell\qc ' . chk($i['���������']) . '\cell ' . chk_bill($i['���������']) . '\cell\qr ' . euro($i['���������������']) . '\cell\qc ' . percent($i['���������']) . '\cell\qr ' . euro($i['��������']) . '\cell\row';
	}
?>
\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28\fs20
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx11169
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx12416
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15137
\qr ������:\cell <?=euro($a['���������������'])?>\cell <?=euro($a['��������'])?>\cell\row
\pard\plain\qr <?=chk($data['����']) . ', ' . now()?>\par

\pard\plain\fs23\par
\trowd\trkeep\cellx7568\cellx15136\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

<? } ?>