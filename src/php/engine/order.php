<?

require_once('functions.php');

if (!isset($draft)) $draft = getEnvironment('draft', 'true');


function preOrder($order, $to, $info, $draft = false, $add = null) {
	global $data;
?>
\pard\plain\fs28\tx1134
\trowd\trautofit1\trpaddl0\trpaddr0\cellx5103\clftsWidth1\clNoWrap\cellx8788
\b ����:<? foreach($to as $v) echo '\tab ' . chk($v) . '\line'; ?>
\line ����:
<?
	if (chk_order($order, !$draft)) $ord = get_order($order);
	if (is_array($info))
		foreach($info as $v) {
			if (!$v && isset($ord)) $v = $ord['�������'];
			if ($v) echo '\tab ' . chk($v) . '\line';
		}
	?>\cell <?=chk(toUppercase($data['������']))?>\line <?=chk(toUppercase($data['�������']))?>\line\b0 ��� (����.) <?=chk($data['�����������������'])?>\line <?
	if (!$draft)
		echo chk($ord['�������']) . '/' . chk($ord['����������']) . '/' . chk($ord['����������']) . '\line ' . chk($ord['������']) . '\line ' . chk($data['����']) . ', ' . chk($ord['����������']);
	else {
		?>�.\line �.\line <?
		echo chk($data['����']);
	}
	if ($add) echo '\line ���: ' . $add;
	?>\cell\row <?
}


function subjectOrder($subject, $orders) { ?>
\pard\plain\fs28\tx1134\tx1644
\b ����:\tab\ul <?=chk($subject)?>\ul0\par
<?
	if ($orders) {
		echo '����:';
		$a = count($orders);
		if ($a > 1) {
			for($z = 0; $z < $a - 1; $z++)
				echo '\tab\b ' . countGreek($z + 1) . '.\b0\tab ' . chk_order($orders[$z]) . '\par';
			echo '\tab\b ' . countGreek($a) . '.';
		}
		echo '\tab\ul ' . chk_order($orders[$a - 1]) . '\par';
	}
	echo '\par';
}


function draftOrder() {
	global $data;
?>
\pard\plain\fs28\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx2929\clftsWidth1\clNoWrap\cellx5858\clftsWidth1\clNoWrap\cellx8788\qc
- �� -\line\ul <?=chk($data['�������'])?>\ul0\line\line\line <?=chk($data['�������������']['�������������'])?>\line <?=chk($data['�������������']['������'])?>\cell
- � -\line\ul ������\ul0\line\line\line <?=chk($data['���']['�������������'])?>\line <?=chk($data['���']['������'])?>\cell
- � -\line\ul �����\ul0\line\line\line <?=chk($data['�����']['�������������'])?>\line <?=chk($data['�����']['������'])?>\cell\row
<?
}


function bottomOrder() {
	global $data;
?>
\pard\plain\fs28\b\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx4394\clftsWidth1\clNoWrap\cellx8788\qc
������� ���������\line\line\line\line <?=man($data['�������������'])?>\line <?=chk($data['�������������'])?>\cell
<?=man($data['�����'])?>\line � � � � � � � � �\cell\row
<?
}

?>