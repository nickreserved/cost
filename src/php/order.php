<?php
require_once('functions.php');

$draft = isset($_ENV['draft']) && $_ENV['draft'] == 'true';

/** ������ �� �� � ������� ����� ��������� ��� ��������� � ���, ����� ��� �� ��� ���.
 * @param string adaKey �� ������ ��� $data �� �� ��� ��� ��������, ������ ������������� ��� ���������
 * @param bool draft �� ������� ����� ������ */
function order_publish($adaKey, $draft) {
	global $data;
	order_publish_plain($data['��������� ��� ���������'], $adaKey, $draft);
}

/** ������ �� �� � ������� ����� ��������� ��� ��������� � ���, ����� ��� �� ��� ���.
 * @param bool $public ����� ��������� ��� ���������
 * @param string adaKey �� ������ ��� $data �� �� ��� ��� ��������, ������ ������������� ��� ���������
 * @param bool draft �� ������� ����� ������ */
function order_publish_plain($public, $adaKey, $draft) {
	global $data;
	if ($public) { ?>

\pard\plain\qr ���: <?=orelse2(!$draft, $data, $adaKey, '........')?>\par
\pard\plain\qc{\ul\b ��������� ��� ���������}\par\par

<?php } else { ?>

\pard\plain\qc{\ul\b �� ��������� ��� ���������}\par\par

<?php }
}


/** ������ �� ��� ��� �������� ����� ���� ������������ ��������.
 * ���������� �������� �� ������ �� �������� �� ��������� � ������ �� ���� '������� ���������'.
 * @param string|null $order � ��������� ��� ��������
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� �����������
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function order_header_autorecipients($order, $to, $info, $draft, $attached, $subject, $references) {
	if (need_recipient_table($to, $info))
		order_header_recipients($order, $draft, $attached, $subject, $references);
	else order_header($order, $to, $info, $draft, $attached, $subject, $references);
}

/** ������� �� ���������� ������� ��������� �� ��� ����������� �������.
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� �����������
 * @return bool �� ��������� ����� ������� ��� ���������� ������� ��������� */
function need_recipient_table($to, $info) { return (count($to) + is_array($info) ? count($info) : 0) > 5; }

/** ������ �� ��� ��� �������� ����� ���� ������������ ��������, �� ������ ���������.
 * @param string|null $order � ��������� ��� ��������
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function order_header_recipients($order, $draft, $attached, $subject, $references) {
	$r = <<<'EOT'
{\b ����:}\line ������� ���������\line\par
{\b ����.:}
EOT;
	order_header_common($order, $r, $draft, $attached, $subject, $references);
}

/** ������ �� ��� ��� �������� ����� ���� ������������ ��������.
 * @param string|null $order � ��������� ��� ��������
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� �����������
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function order_header($order, $to, $info, $draft, $attached, $subject, $references) {
	$r = '{\b ����:}\tab ';
	foreach($to as $v) $r .= rtf($v) . '\line';
	$r .= '\par' . PHP_EOL;
	$r .= '{\b ����.:}\tab ';
	if (is_array($info))
		foreach($info as $v) $r .= rtf($v) . '\line';
	order_header_common($order, $r, $draft, $attached, $subject, $references);
}

/** ������ �� ��� ��� �������� ����� ���� ������������ ��������.
 * @param string|null $order � ��������� ��� ��������
 * @param string $recipients �� ��������� ��� ��������
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function order_header_common($order, $recipients, $draft, $attached, $subject, $references) {
	global $data;
	if (!$draft || isset($order)) { $ord = null; order($order, $ord); }
?>

\trowd\trautofit1\trpaddl0\trpaddr0\cellx5103\clftsWidth1\clNoWrap\cellx8788
\pard\plain\fi-1134\li1134\tx1134\intbl
<?=$recipients?>\cell
\pard\plain\intbl
<?=wordwrap(rtf(strtouppergn($data['������ ������'])), 25, '\line ')?>\line <?=rtf(strtouppergn($data['�������']))?>\line ���. <?=rtf($data['��������'])?>\line <?php
	if (!$draft || isset($ord))
		echo rtf($ord[0]) . '/' . rtf($ord[1]) . '/' . rtf($ord[2]) . '\line ' . rtf($ord[3]) . '\line ' . rtf($data['����']) . ', ' . rtf($ord[4]);
	else echo '�. \u8230_ / \u8230_ / \u8230_\line �. \u8230_\line ' . rtf($data['����']) . ', \u8230_ ' . strftime('%b %y');
	if ($attached) echo '\line ���������: ' . $attached;
	?>\cell\row

\pard\plain\sb240\sa240\fi-1134\li1134\tx1134\qj
{\b ����:}\tab{\ul <?=rtf($subject)?>}\par
<?php
	if ($references) {
		$a = count($references);
		if ($a > 1) {
			echo '\pard\plain\fi-1644\li1644\tx1134\tx1644\qj{\b ����.:}';
			for($z = 0; $z < $a - 1; $z++)
				echo '\tab ' . greeknum($z + 1) . '.\tab ' . rtf($references[$z]) . '\par' . PHP_EOL;
			echo '\pard\plain\sa120\fi-1644\li1644\tx1134\tx1644\tab ' . greeknum($a) . '.';
		} else echo '\pard\plain\sa120\fi-1134\li1134\tx1134\qj{\b ����.:}';
		echo '\tab{\ul ' . rtf($references[$a - 1]) . '}\par' . PHP_EOL . PHP_EOL;
	} ?>
\pard\plain\sb120\sa120\fi567\tx1134\tx1701\tx2268\qj
<?php }

/** ������ �� ���� ��� �������� �����, ���� ������������ ��������.
 * @param bool $draft �� ������� ��������� ��� ������, �������� ��� ������� ��������� */
function order_footer($draft) { if ($draft) order_footer_draft(); else order_footer_copy(); }

/** ������ �� ���� ��� �������� �����, ���� ������� ������������ ��������. */
function order_footer_draft() {
	global $data;
	order_footer_draft_signs(array(
		array('��', $data['�������'], $data['����� ��������']),
		array('�', '������', $data['���']),
		array('�', '�����', $data['�����'])
	));
}

/** ������ �� ���� ��� �������� �����, ���� ������� ������������ ��������.
 * @param array $a ��� �������� ��� ���� �����������. �� �������� ����� array �� �� ����� ���
 * ��������� ��� ������������, ��� �������� ��� ������������ ��� ��� �����������.
 * @param int $width �� ������� ������ ��� ������� (�� ����� � ������ ����� ��������� � ������) */
function order_footer_draft_signs($a, $width = 8788) {
	$c = count($a);
	$width /= $c;
	?>
\pard\plain\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113

<?php
	for($z = 1; $z <= $c; ++$z)
		echo '\clftsWidth1\clNoWrap\cellx' . (int) ($width * $z);
	echo '\qc' . PHP_EOL;
	foreach($a as $v)
		echo '- ' . rtf($v[0]) . ' -\line{\ul ' . rtf($v[1]) . '}\line\line\line ' . rtf($v[2]['�������������']) . '\line ' . rtf(fullrank($v[2]['������'])) . '\cell' . PHP_EOL;
	echo '\row' . PHP_EOL . PHP_EOL;
}

/** ������ �� ���� ��� �������� �����, ���� �������� ���������� ������������ ��������.
 * ������������ ����� � ��������� ��� � ���������. */
function order_footer_copy() {
	global $data;
	order_footer_copy_signs($data['�������� �����'], $data['����� ��������'], '���������', $data['�����']);
}

/** ������ �� ���� ��� �������� �����, ���� �������� ���������� ������������ ��������. */
function order_footer_copy_signs($operatorProperty, $operator, $appovalProperty, $approvalPerson) { ?>
\pard\plain\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx4394\clftsWidth1\clNoWrap\cellx8788\qc
������� ���������\line\line\line\line <?=person($operator)?>\line <?=rtf($operatorProperty)?>\cell
<?=person($approvalPerson)?>\line <?=rtf($appovalProperty)?>\cell\row

<?php }



/** ������ ��� ������ ��������� ���� ������������ ��������.
 * ���������� �������� �� ������ �� ���� '������� ���������'.
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� ����������� */
function order_recipient_table_auto($to, $info) {
	if (need_recipient_table($to, $info)) order_recipient_table($to, $info);
}

/** ������ ��� ������ ��������� ���� ������������ ��������.
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� �����������. */
function order_recipient_table($to, $info) { ?>

\pard\plain\sb567\sa57\ul ������� ���������\par
\sb0\sa0 ��������� ��� ��������\ul0\par
<?php
	foreach($to as $v) echo rtf($v) . '\par'. PHP_EOL;
	if (is_array($info)) {
?>\sb57{\ul ��������� ��� ����������}\par\sb0
<?php
		foreach($info as $v) echo rtf($v) . '\par'. PHP_EOL;
	}
}

/** ���������� ��� ���������, ��� �������� ������������ ��������.
 * � ����� ��� �������� ����� '�������� (���������)'
 * @param array $contractor � ����������
 * @return string � ���������� ��� ��������� */
function get_contractor_recipient($contractor) {
	$a = $contractor['��������'];
	if (isset($contractor['���������'])) $a .= " ({$contractor['���������']})";
	return $a;
}

/** ����� ������������ ������������ ��������.
 * @param array $a ����� �� ���� ������� ��� ������������ */
function order_appendices($a) {
	echo '\pard\plain\sb567\sa57{\ul �����������}\par\sb0\sa0\tx567' . PHP_EOL;
	$c = 0;
	foreach($a as $v)
		echo '�' . strtoupper(greekNum(++$c)) . '�\tab ' . rtf($v) . '\par' . PHP_EOL;
}

/** ������ �� ��� ��� �������� ����� ���� ������������ ������������ ��������.
 * @param string $order � ��������� ��� ������������ ��������, � null �� ����� ������
 * @param string $appendix � ������� ��� ������������, �.�. '�' � '��'
 * @param string $title � ������ ��� ������������ */
function appendix_header($order, $appendix, $title) {
	global $data;
?>
\trowd\trautofit1\trpaddl0\trpaddr0\cellx5103\clftsWidth1\clNoWrap\cellx8788
\line\ul ��������� �<?=$appendix?>� ���\line
<?php
	if (isset($order)) {
		order($order, $order);
		echo "{$order[0]}/{$order[1]}/{$order[2]}/{$order[3]}";
	} else echo '�. \u8230_ / \u8230_ / \u8230_ / \u8230_';
?>\ul0\cell
<?=wordwrap(rtf(strtouppergn($data['������ ������'])), 25, '\line ')?>\line <?=rtf(strtouppergn($data['�������']))?>\line <?=isset($order) ? $order[4] : ('\u8230_ ' . strftime('%b %y'))?>\cell\row

\pard\plain\sb227\sa113\qc{\b\ul <?=rtf($title)?>}\par

<?php }

/** ������ �� ���� ��� �������� �����, ���� ������������ ������������ ��������.
 * @param bool $draft �� ������� ��������� ��� ������, �������� ��� ������� ��������� */
function appendix_footer($draft) { if ($draft) appendix_footer_draft(); else appendix_footer_copy(); }

/** ������ �� ���� ��� �������� �����, ���� ������� ������������ ������������ ��������. */
function appendix_footer_draft() {
	global $data;
	order_footer_draft_signs(array(
		array('��', $data['�������'], $data['����� ��������']),
		array('�', '������', $data['���'])
	));
}

/** ������ �� ���� ��� �������� �����, ���� �������� ���������� ������������ ������������ ��������.
 * ������������ ����� � ��������� ��� � ������������. */
function appendix_footer_copy() {
	global $data;
	order_footer_copy_signs($data['�������� �����'], $data['����� ��������'], '������������', $data['���']);
}