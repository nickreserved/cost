<?php
require_once('functions.php');
init(6);

if (!$data['�����']['��']) trigger_error('��� �������� ��������� �� ��', E_USER_ERROR);
foreach ($data['����������'] as $per_contractor) {
	if (!$per_contractor['�����']['��']) continue;
	$contractor = $per_contractor['����������'];
?>

\sectd\lndscpsxn\pgwsxn16838\pghsxn11906\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain I. �������� ��� ��������\par

\pard\plain\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx6178
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx11227
\cellx15136
\qc <?=rtf($data['������ ������'])?>\line\b ��������\b0\line\line<?=rtf(get_unit_address())?>\line\b ��������� (���� - ���� - �.�.)\b0\line\line 090153025\line\b �.�.�.\b0\cell
����������� ������\line\b ������ �����\b0\line\line <?=rtf($data['��������'])?>\line\b ��. ���������\b0\line\line ��� �. �������\line\b �.�.�.\b0\cell
\b ��������\b0\line\line ��������������� ����� ��� ���������� ���� ������ ������ � ������� ��������� ��� ��� �������� ���, ���� �.�.�. (������. ��' �����. 1 ������ 37� ��� �.�. 3323/1955)\cell\row

\pard\plain\line II. �������� �����������\par
\trowd\trautofit1\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx6178
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx11227
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15136
\qc <?=rtf($contractor['��������'])?>\line\b ��������\b0\line\line <?=rtf($contractor['���������'])?>\line\b ��������� (���� - ���� - �.�.)\b0\cell
<?php if (isset($contractor['��������'])) echo rtf($contractor['��������']); ?>
\line\b ��������\b0\cell
<?=rtf($contractor['���'])?>\line\b �.�.�.\b0\line\line <?=rtf($contractor['���'])?>\line\b �.�.�.\b0\cell\row

\pard\plain\line III. �������� ����������\par

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
<?php
	foreach ($per_contractor['���������'] as $invoice)
		echo '\qc ' . rtf($invoice['���������']) . '\cell ' . $invoice['���������'] . '\cell\qr '
			. euro($invoice['�����']['������ ���� ��� ��']) . '\cell\qc ' . percent($invoice['��'])
			. '\cell\qr ' . euro($invoice['�����']['��']) . '\cell\row' . PHP_EOL
?>
\trowd\trpaddfl3\trpaddl28\trpaddfr3\trpaddr28
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx5669
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\cellx8787
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx15136
\qr ������\cell \qr <?=euro($per_contractor['�����']['������ ���� ��� ��'])?>\cell\qr <?=euro($per_contractor['�����']['��'])?>\cell\row

\pard\plain\qr <?=rtf($data['����']) . ', ' . strftime('%d %b %y', time())?>\par


\pard\plain\fs23\trowd\trkeep\cellx7568\cellx15136\qc
��������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=rtf($data['����� ��������']['�������������'])?>\line <?=rtf($data['����� ��������']['������'])?>\cell\row

\sect

<?php
}

unset($contractor, $invoice, $per_contractor);

rtf_close(__FILE__);