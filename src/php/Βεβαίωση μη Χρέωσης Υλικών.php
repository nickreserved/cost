<?php
require_once('init.php');
require_once('header.php');

$invoices = get_invoices_by_category($data['���������']);
if (!isset($invoices['��������� ������'])) return;
$invoices = $invoices['��������� ������'];
$c = count($invoices) > 1 ? '�' : '�';	// �������� ����������� - ������ ������� �� ��� ������ ����������
?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\qr <?=rtf($data['�����������'])?>\line <?=rtf($data['������'])?>\par\par
\fs24\qc{\b �������� �� ������� ������}\par\par

\qj ����������� � �����, ��������, �� ������ ��� ������� ��� ����������� ������ ������� ��� �������, ��� ������������� ��<?=$c?> ��' ������� <?=get_names_key($invoices, '���������')?> ��������<?=$c?> ���������� ������� �� ��� �.092/235631/9 ��� 1982 ������� ����� ��� �.600.9/12/601600/�.129/13 ��� 2005/���/���/3�.\par
\pard\plain\qr\par <?=rtf($data['����']) . ', ' . strftime('%d %b %y', get_newer_invoice_timestamp($invoices))?>\par

\pard\plain\par
\trowd\cellx3402\cellx6804\cellx10206\qc
���������\line - � -\line �����\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������'])?>\cell
\line - � -\line ���\line\line\line <?=rtf($data['���']['�������������'])?>\line <?=rtf($data['���']['������'])?>\cell
\line - � -\line ������\line\line\line <?=rtf($data['������']['�������������'])?>\line <?=rtf($data['������']['������'])?>\cell\row

\sect

<?
unset($c, $invoices);

rtf_close(__FILE__);
?>