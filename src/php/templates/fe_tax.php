<?
require_once('engine/functions.php');
require_once('header.php');

if (!isset($bills_month)) $bills_month = bills_by_month(bills_with_fe($data['���������']));

foreach ($bills_month as $my => $list) {
	$list_info = calc_bills($list);
?>

{

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\fs21\trowd\cellx7370\cellx10206
\ul ���� �� ���\line ���������� ����:\ul0  <?=strftime('%Y', $my)?>\line\ul �����:\ul0  <?=strftime('%b', $my)?>\cell
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
����������� ������\line\b ������ �����\b0\line\line
<?
if (isset($data['�����������������'])) echo '����.: ' . chk($data['�����������������']);
if (isset($data['�����������������'])) echo '  ����.: ' . chk($data['�����������������']);
?>
\line\b ��. ���������\b0\line\line ��� �. �������\line\b �.�.�.\b0\cell\row

\pard\plain\par\par


\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx3118
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx5386
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx8220
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206
\qc ����� ����������\cell ������ ����\cell ����������� �����\cell ���� �����\cell\row
<?
	$list_fe = bills_by_fe($list);
	foreach($list_fe as $v) {
		$v_info = calc_bills($v);
		echo '\ql ' . chk($v[0]['���������']) . '\cell\qr ' . euro($v_info['������������������������']) . '\cell\qc ' . percent($v[0]['���������']) . '\cell\qr ' . euro($v_info['��������']) . '\cell\row';
	}
?>
\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx3118
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\cellx5386
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206
\qr ������\cell <?=euro($list_info['������������������������'])?>\cell <?=euro($v_info['��������'])?>\cell\row
\ql ����� ���� �����������\cell\cell\cell\row
\qr ������ ������\cell\cell\cell\row

\pard\plain\par\qc{\fs28\b\ul �������� ������}\par\par
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

\pard\plain\qc{\fs28\b\ul ������� ������������}\par\par
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
��������\cell �.�.�.\cell ���������\cell\����� ����������\cell ���������\cell\ ������ ����\cell ������� �����\cell ���� �����\cell\row
<?
	foreach($list as $v) {
		$provider = $v['�����������'];
		echo '\ql ' . chk($provider['��������']) . '\cell\qc ' . chk($provider['���']) . '\cell\ql ';
		if (isset($provider['����'])) echo chk($provider['����']);
		if (isset($provider['���������']) && isset($provider['����'])) echo ', ';
		if (isset($provider['���������'])) echo chk($provider['���������']);
		echo '\cell\qc ' . chk($v['���������']) . '\cell ' . chk_bill($v['���������']) . '\cell\qr ' . euro($v['������������������������']) . '\cell\qc ' . percent($v['���������']) . '\cell\qr ' . euro($v['��������']) . '\cell\row';
	}
?>
\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28\fs20
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx11169
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx12416
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15137
\qr ������:\cell <?=euro($list_info['������������������������'])?>\cell <?=euro($list_info['��������'])?>\cell\row
\pard\plain\qr <?=chk($data['����']) . ', ' . now()?>\par

\pard\plain\fs23\par
\trowd\trkeep\cellx7568\cellx15136\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=chk($data['���������']['�������������'])?>\line <?=chk($data['���������']['������'])?>\cell\row

\sect

}


<? } ?>