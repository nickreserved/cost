<?php
require_once('functions.php');

$draft = isset($_ENV['draft']) && $_ENV['draft'] == 'true';

/** ������ ��� ��������� ��� �������� �������� ���� ������������ ��������. */
function startOrder() { ?>

\sectd\sbkodd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134\facingp\margmirror

<?php }

/** ������ �� ��� ��� �������� ����� ���� ������������ ��������.
 * ���������� �������� �� ������ �� �������� �� ��������� � ������ �� ���� '������� ���������'.
 * @param string|null $order � ��������� ��� ��������
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� �����������
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function preOrderS($order, $to, $info, $draft, $attached, $subject, $references) {
	if (need_recipient_table($to, $info))
		preOrderN($order, $draft, $attached, $subject, $references);
	else preOrder($order, $to, $info, $draft, $attached, $subject, $references);
}

/** ������� �� ���������� ������� ��������� �� ��� ����������� �������.
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� �����������
 * @return bool �� ��������� ����� ������� ��� ���������� ������� ��������� */
function need_recipient_table($to, $info) { return (count($to) + is_array($info) ? count($info) : 0) > 5; }


/** ������ �� ��� ��� �������� ����� ���� ������������ ��������.
 * @param string|null $order � ��������� ��� ��������
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function preOrderN($order, $draft, $attached, $subject, $references) {
	$r = <<<'EOT'
{\b ����:}\line ������� ���������\line\par
{\b ����.:}
EOT;
	preOrderR($order, $r, $draft, $attached, $subject, $references);
}

/** ������ �� ��� ��� �������� ����� ���� ������������ ��������.
 * @param string|null $order � ��������� ��� ��������
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� �����������
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function preOrder($order, $to, $info, $draft, $attached, $subject, $references) {
	$r = '{\b ����:}\tab ';
	foreach($to as $v) $r .= rtf($v) . '\line';
	$r .= '\par' . PHP_EOL;
	$r .= '{\b ����.:}\tab ';
	if (is_array($info))
		foreach($info as $v) $r .= rtf($v) . '\line';
	preOrderR($order, $r, $draft, $attached, $subject, $references);
}

/** ������ �� ��� ��� �������� ����� ���� ������������ ��������.
 * @param string|null $order � ��������� ��� ��������
 * @param string $recipients �� ��������� ��� ��������
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function preOrderR($order, $recipients, $draft, $attached, $subject, $references) {
	global $data;
	if (!$draft || isset($order)) { $ord = null; order($order, $ord); }
?>

\trowd\trautofit1\trpaddl0\trpaddr0\cellx5103\clftsWidth1\clNoWrap\cellx8788
\pard\plain\fi-1134\li1134\tx1134
<?=$recipients?>\cell
\pard\plain
<?=rtf(strtouppergn($data['������ ������']))?>\line <?=rtf(strtouppergn($data['�������']))?>\line ���. <?=rtf($data['��������'])?>\line <?php
	if (!$draft || isset($ord))
		echo rtf($ord[0]) . '/' . rtf($ord[1]) . '/' . rtf($ord[2]) . '\line ' . rtf($ord[3]) . '\line ' . rtf($data['����']) . ', ' . rtf($ord[4]);
	else echo '�.\line �.\line ' . rtf($data['����']);
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
function postOrder($draft) { if ($draft) postOrderDraft(); else postOrderCopy(); }


/** ������ �� ���� ��� �������� �����, ���� ������� ������������ ��������. */
function postOrderDraft() {
	global $data; ?>
\pard\plain\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx2929\clftsWidth1\clNoWrap\cellx5858\clftsWidth1\clNoWrap\cellx8788\qc
- �� -\line\ul <?=rtf($data['�������'])?>\ul0\line\line\line <?=rtf($data['����� ��������']['�������������'])?>\line <?=rtf($data['����� ��������']['������ ������'])?>\cell
- � -\line\ul ������\ul0\line\line\line <?=rtf($data['���']['�������������'])?>\line <?=rtf($data['���']['������ ������'])?>\cell
- � -\line\ul �����\ul0\line\line\line <?=rtf($data['�����']['�������������'])?>\line <?=rtf($data['�����']['������ ������'])?>\cell\row
<?php }

/** ������ �� ���� ��� �������� �����, ���� �������� ���������� ������������ ��������. */
function postOrderCopy() {
	global $data; ?>
\pard\plain\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx4394\clftsWidth1\clNoWrap\cellx8788\qc
������� ���������\line\line\line\line <?=person($data['����� ��������'])?>\line <?=rtf($data['�������� �����'])?>\cell
<?=person($data['�����'])?>\line ���������\cell\row
<?php }

/** ������ ��� ������ ��������� ���� ������������ ��������.
 * ���������� �������� �� ������ �� ���� '������� ���������'.
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� ����������� */
function recipientTableOrderS($to, $info) {
	if (need_recipient_table($to, $info)) recipientTableOrder($to, $info);
}

/** ������ ��� ������ ��������� ���� ������������ ��������.
 * @param array $to �� ��������� ���� ��������
 * @param array|null $info �� ��������� ���� �����������. */
function recipientTableOrder($to, $info) { ?>

\pard\plain\sb567\sa57\ul ������� ���������\par
\sb0\sa0 ��������� ��� ��������\ul0\par\sb0
<?php
	foreach($to as $v) echo rtf($v) . '\par'. PHP_EOL;
	if (is_array($info)) {
?>\sb57{\ul ��������� ��� ����������}\par\sb0
<?php
		foreach($info as $v) echo rtf($v) . '\par'. PHP_EOL;
	}
}