<?
require_once('engine/functions.php');
require_once('header.php');


//if ($data['������������'] == '��������� - ��������� - ��������')
	$bills_rr = $data['���������'];
//else {
//	if (!isset($bills_buy)) $bills_buy = getBillsCategory($data['���������'], '��������� ������');
//	$bills_rr = $bills_buy;
//}
//if ($bills_rr) {
?>

{

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn1134\margbsxn1134

\pard\plain\b\ul ������:\ul0\b0  <?=chk($data['���������������'])?>\line
\b\ul ����:\ul0\b0  <?=chk($data['������'])?>\par\par
\fs28\ul\qc ����������\line ��������� ��� ��������� ����������\par\par
\pard\plain\tx567\tx1134\qj
\tab ������ ��� <?=now()?> � ������������� �������� ������������ ��� ����:\par
\tab\tab �. <?=inflection(man($data['�����������������������������������']), 2)?> �� �������\par
\tab\tab �. <?=inflection(man($data['���������������������������������']), 2)?> ���\par
\tab\tab �. <?=inflection(man($data['���������������������������������']), 2)?> �� ����\par
��� ������������ �� ��� \ul <?=chk_order($data['�����������'])?>\ul0  ������ ���� �������� ��� �������� �������� ��� �������� ������ ���/� �������� �� ����� ����� �� ������ ��������� ��� �� ����� �������� ���� ���� ����� <?=inflection(man($data['���������']), 2)?>.\par\par


\pard\trowd\trhdr\fs23\trautofit1\trpaddfl3\trpaddl57\trpaddfr3\trpaddr57
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx567
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx7540
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx8787
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\clftsWidth1\clNoWrap\cellx10206
\qc\b A/A\cell �����\cell ������\cell ��������\b0\cell\row
<?
$count = 0;
foreach($bills_rr as $v) {
	$items = $v['����'];
	foreach($items as $i) { ?>
\qr <?=++$count?>\cell\qj <?=chk($i['�����'])?>\cell\qc <?=chk($i['������M�������'])?>\cell <?=num($i['��������'])?>\cell\row
<? } } ?>


\pard\plain\fs23\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx3402\clftsWidth1\clNoWrap\cellx6804\clftsWidth1\clNoWrap\cellx10206\qc
��������\line - � -\line �����\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell
\line - � -\line ��������\line\line\line <?=chk($data['�����������������������������������']['�������������'])?>\line <?=chk($data['�����������������������������������']['������'])?>\cell
\line - �� -\line ����\line\line\line <?=chk($data['���������������������������������']['�������������'])?>\line <?=chk($data['���������������������������������']['������'])?>
\line\line\line <?=chk($data['���������������������������������']['�������������'])?>\line <?=chk($data['���������������������������������']['������'])?>\cell\row

\sect

}

