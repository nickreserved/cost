<?
require_once('init.php');
require_once('order.php');
require_once('header.php');

startOrder();
preOrder(
		!$draft || isset($data['������������ �������']) ? $data['������������ �������'] : null,
		array($data['��������� ����']), array($data['������']), $draft, '1 �������',
		'�������', array($data['������� �������� ����������']));
?>
1.\tab ��� ����������� ��������� ������ ��������� ������� ��� ����� �<?=rtf($data['������'])?>� ����� <?=euro($data['�����']['������������'])?>, ��� ��������������� ������.\par
2.\tab ����������� ��� ��� ��������� ���.\par

<? postOrder($draft); ?>

\sect

<?=rtf_close(__FILE__)?>