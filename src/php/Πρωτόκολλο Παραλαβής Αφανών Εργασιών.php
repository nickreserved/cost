<?php
require_once('functions.php');
init(4);

if ($data['����']) {
	if (!isset($data['��������'])) trigger_error('��� �������� ��������', E_USER_ERROR);

	start_35_20();
?>

\pard\plain\sa240\qr\b <?=rtf(strtouppergn($data['������ ������']))?>\par
\fs24\ul\qc ���������� ��������� ������ ��������\par
\pard\plain\sb120\sa120\fi567\tx1134\tx1701\qj
������ ��� <?=strftime('%d %b %y', $data['���������� ���������� ����������'])?>, � �������� ������ �������� ������������� ��� ����:\par
\tab �.\tab <?=personi($data['�������� ������ ��������'], 2)?> �� �������\par
\tab �.\tab <?=personi($data['����� ������ ��������'], 2)?> �� �����\par
��� ������������ �� ��� <?=$data['��� ����������� ���������']['���������']?> , �������� ���� ���� ��� ����� �<?=rtf($data['������'])?>�, ������� ����������� ��� ������������ ����� <?=personi($data['����� �����'], 1)?>, ���� ����������� ��� ��������, �������� ��� ���������, ��� ������� �������� ��� ����� ����� ���� ��������:\par

\pard\trowd\trhdr\fs23<?php ob_start(); ?>\trautofit1\trpaddfl3\trpaddl57\trpaddfr3\trpaddr57
\clvertalc\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx567
\clvertalc\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx4535
\clvertalc\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx5952
\clvertalc\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx7143
\clvertalc\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx8787
<?php $c = ob_get_flush(); ?>
\qc\b A/A\cell �������\cell ��������\cell ������\cell ���������\line ��������\b0\cell\row
\pard\trowd\trrh567<?=$c?>
<?php
foreach($data['��������'] as $c => $work)
	echo '\qr ' . ($c + 1) . '\cell\qj ' . rtf($work['�������']) . '\cell\qc ' . num($work['��������']) . '\cell ' . rtf($work['������ M�������']) . '\cell\cell\row' . PHP_EOL;
?>
\pard\plain\qr\par <?=rtf($data['����']) . ', ' . strftime('%d %b %y', $data['���������� ���������� ����������'])?>\par

\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx2929\clftsWidth1\clNoWrap\cellx5858\clftsWidth1\clNoWrap\cellx8787\qc
��������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ��������\line\line\line <?=rtf($data['�������� ������ ��������']['�������������'])?>\line <?=rtf($data['�������� ������ ��������']['������'])?>\cell
\line - �� -\line �����\line\line\line <?=rtf($data['����� ������ ��������']['�������������'])?>\line <?=rtf($data['����� ������ ��������']['������'])?>\cell\row

\sect

<?php

}	// if

unset($c, $work);

rtf_close(__FILE__);