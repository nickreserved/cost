<?
require_once('engine/functions.php');
require_once('header.php');

if (!isset($bills)) $bills = $data['���������'];
if (!isset($bills_contract)) $bills_contract = getBillsCategory($bills, '������ ���������');
if (!isset($bills_buy)) $bills_buy = getBillsCategory($bills, '������ ���������', false);
?>

{

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\fs28\ul\qc �����\line ����������� ��������\par\par

\pard\plain\tx397\tx9638
\trowd\fs23\trpaddfl3\trpaddl57\trpaddfr3\trpaddr57
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206
\qc{\line\b ���������� "�"\b0}\cell\row\ql
1.\tab ��� �������� <?=chk_order($data['�����������'])?>\cell\row
2.\tab ��� �������� <?=chk_order($data['�����������'])?>\cell\row
\qc{\line\b ���������� "�"\b0}\cell\row\ql
1.\tab ��� �������� <?=chk_order($data['�����������'])?>\cell\row
<?
$c = 1;
if ($bills_contract) { ?>
<?=++$c?>.\tab ���������� ��������� ��������� ��������\tab (x3)\cell\row
<? }
if ($bills_buy) { ?>
<?=++$c?>.\tab ���������� ������ ��� ��������\tab (x3)\cell\row
<? } ?>
<?=++$c?>.\tab ���������� ��������� ��� ��������� ���������\tab (x3)\cell\row
<?=++$c?>.\tab ������ ��������� �������\tab (x3)\cell\row
<?
foreach($bills as $v) {
	echo ++$c; ?>.\tab ��������� ��' ������� <?=$v['���������']?>\cell\row
<? } ?>
<?=++$c?>.\tab ��������� ���� ������\tab (x3)\cell\row
\qc{\line\b ���������� "�"\b0}\cell\row\ql
1.\tab ����������� ��������� ��\cell\row
2.\tab ����������� ��������� ���������\cell\row
3.\tab ����\cell\row
<?
$c = 3;
if ($bills_contract) { ?>
<?=++$c?>.\tab �������� �������������� �������\cell\row
<? }
if ($bills_buy) { ?>
<?=++$c?>.\tab �������� �������������� �������\cell\row
<? } ?>

\sect

}

