<?php
require_once('functions.php');
init(5);

$invoices = array_values(array_filter($data['���������'], function($i) { return is_supply($i['���������']); }));
if (count($invoices)) {
	$c = count($invoices) > 1 ? '�' : '�';	// �������� ����������� - ������ ������� �� ��� ������ ����������
?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134\facingp\margmirror

\pard\plain\qr <?=rtf($data['�����������'])?>\line <?=rtf($data['������'])?>\par\par
\fs24\qc{\b �������� �� ������� ������}\par\par

\qj ����������� � �����, ��������, �� ������ ��� ������� ��� ����������� ������ ������� <?=rtf(article(gender($data['������ ������']), 1) . ' ' . inflectPhrase($data['������ ������'], 1))?>, ��� ������������� ��<?=$c?> ��' ������� <?=get_names_key($invoices, '���������')?> ��������<?=$c?> ���������� ������� �� ��� �.092/235631/9 ��� 1982 ������� ����� ��� �.600.9/12/601600/�.129/13 ��� 2005/���/���/3�.\par
\pard\plain\qr\par <?=rtf($data['����']) . ', ' . strftime('%d %b %y', get_newer_timestamp($invoices))?>\par

\pard\plain\par
\trowd\clftsWidth1\clNoWrap\cellx2929\clftsWidth1\clNoWrap\cellx5859\clftsWidth1\clNoWrap\cellx8788\qc
���������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ���\line\line\line <?=rtf($data['���']['�������������'])?>\line <?=rtf($data['���']['������'])?>\cell
\line - � -\line ������\line\line\line <?=rtf($data['������']['�������������'])?>\line <?=rtf($data['������']['������'])?>\cell\row

\sect

<?php

}	// if

unset($c, $invoices);

rtf_close(__FILE__);