<?
require_once('functions.php');
init(4);

if ($data['����']) {
	if (!isset($data['��������'])) trigger_error('��� �������� ��������', E_USER_ERROR);

	start_35_20();
?>

\pard\plain\sa240\qr\b <?=rtf(strtouppergn($data['������ ������']))?>\par
\fs24\ul\qc ��������� ��� �������� ����������\par
\pard\plain\sb120\sa120\fi567\tx1134\tx1701\qj
������ ��� <?=strftime('%d %b %y', $data['���������� ���������� ����������'])?>, � ��������� ��� ����� �<?=rtf($data['������'])?>�, <?=personi($data['����� �����'], 0)?>, ��� �������� �� ��� <?=$data['��� ����������� ���������']['���������']?>, �������������� ��� ��������� ��� �������� ���������� ���� ��� �������� ��� ������������, ������������, ���� ��������:\par

\pard\trowd\trhdr\fs23<?php ob_start(); ?>\trautofit1\trpaddfl3\trpaddl57\trpaddfr3\trpaddr57
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx567
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx6179
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx7596
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx8787
<?php $c = ob_get_flush(); ?>
\qc\b A/A\cell ������� ��� �����\cell ��������\cell ������\b0\cell\row
\pard\trowd<?=$c?>
<?php
foreach($data['��������'] as $c => $work) {
	echo '\b\qj ' . ($c + 1) . '\cell\qj ' . rtf($work['�������']) . '\cell\qc ' . num($work['��������']) . '\cell ' . rtf($work['������ M�������']) . '\b0\cell\row' . PHP_EOL;
	if (isset($work['�����']))
		foreach($work['�����'] as $c => $item)
			echo '\qr ' . greeknum($c + 1) . '\cell\qj ' . rtf($item['�����']) . '\cell\qc ' . num($item['��������']) . '\cell ' . rtf($item['������ M�������']) . '\cell\row' . PHP_EOL;
}
?>

\pard\plain\fs23\par\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx4394\clftsWidth1\clNoWrap\cellx8787\qc
��������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=rtf($data['����� �����']['�������������'])?>\line <?=rtf($data['����� �����']['������'])?>\cell\row

\sect

<?php

}	// if

unset($c, $item, $work);

rtf_close(__FILE__);