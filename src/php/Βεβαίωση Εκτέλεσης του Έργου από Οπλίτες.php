<?php
require_once('functions.php');
init(4);

if ($data['����'] && !has_service_category($data['���������'])) {

	start_35_20();
?>

\pard\plain\sa240\qr\b <?=rtf(strtouppergn($data['������ ������']))?>\par
\fs24\ul\qc ��������\line ��������� ��� ����� ��� ������� ��� �������\par
\pard\plain\sb120\sa120\fi567\tx1134\tx1701\qj
������ ��� <?=strftime('%d %b %y', $data['���������� ���������� ����������'])?>, � ��������� ��� ����� �<?=rtf($data['������'])?>�, <?=personi($data['����� �����'], 0)?>, ��� �������� �� ��� <?=$data['��� ����������� ���������']['���������']?>, ��������� ��� �� ���� ����������� ��� �������.\par

\pard\plain\fs23\par\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx4394\clftsWidth1\clNoWrap\cellx8787\qc
��������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ����� �����\line\line\line <?=rtf($data['����� �����']['�������������'])?>\line <?=rtf($data['����� �����']['������'])?>\cell\row

\sect

<?php

}	// if

rtf_close(__FILE__);