<?php
require_once('init.php');
require_once('order.php');
require_once('header.php');

start_35_20();
order_header(
		!$draft || isset($data['������������ �������']) ? $data['������������ �������'] : null,
		array($data['��������� ����']), array($data['������']), $draft, '1 �������',
		'�������', array($data['������� �������� ����������']));
?>
1.\tab ��� ����������� ��������� ������ ��������� ������� ��� ����� �<?=rtf($data['������'])?>� ����� <?=euro($data['�����']['������������'])?>, ��� ��������������� ������.\par
2.\tab ����������� ��� ��� ��������� ���.\par

<?php order_footer($draft); ?>

\sect

<?php

rtf_close(__FILE__);