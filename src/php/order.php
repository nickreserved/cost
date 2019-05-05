<?
require_once('functions.php');

$draft = isset($_ENV['draft']) && $_ENV['draft'] == 'true';

/** ������ ��� ��������� ��� �������� �������� ���� ������������ ��������. */
function startOrder() { ?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn1984\margrsxn1134\margtsxn1134\margbsxn1134

<? }

/** ������ �� ��� ��� �������� ����� ���� ������������ ��������.
 * @param string|null $order � ��������� ��� ��������
 * @param array $to �� ��������� ���� ��������. ����������� ��� ��������.
 * @param array|null $info �� ��������� ���� �����������. �� ������ �������� ����� null, ��������������
 * ��� ��� ������ ��� �������� $order � �� ���� ����� null, ��� �� ������ ��� ��������� �� ������.
 * @param bool draft �� ������� ����� ������
 * @param string|null $attached � ������� ����������
 * @param string $subject �� ���� ��� ��������
 * @param array|null $references �� ������� ��� �������� */
function preOrder($order, $to, $info, $draft, $attached, $subject, $references) {
	global $data;
	if (!$draft || isset($order)) { $ord = null; order($order, $ord); }
?>
\pard\plain\tx1134
\trowd\trautofit1\trpaddl0\trpaddr0\cellx5103\clftsWidth1\clNoWrap\cellx8788
\b ����:\b0<? foreach($to as $v) echo '\tab ' . rtf($v) . '\line'; ?>\line
\b ����.:\b0<?
	if (is_array($info))
		foreach($info as $v) {
			if (!$v) $v = isset($ord) ? $ord[5] : $data['������'];
			if ($v) echo '\tab ' . rtf($v) . '\line';
		}
	?>\cell
<?=rtf(toUppercase($data['������ ������']))?>\line <?=rtf(toUppercase($data['�������']))?>\line ���. <?=rtf($data['��������'])?>\line <?
	if (!$draft || isset($ord))
		echo rtf($ord[0]) . '/' . rtf($ord[1]) . '/' . rtf($ord[2]) . '\line ' . rtf($ord[3]) . '\line ' . rtf($data['����']) . ', ' . rtf($ord[4]);
	else echo '�.\line �.\line ' . rtf($data['����']);
	if ($attached) echo '\line ���������: ' . $attached;
	?>\cell\row

\pard\plain\sb240\sa240\fi-1134\li1134\tx1134\qj
{\b ����:}\tab{\ul <?=rtf($subject)?>}\par
<?
	if ($references) {
		$a = count($references);
		if ($a > 1) {
			echo '\pard\plain\fi-1644\li1644\tx1134\tx1644\qj{\b ����.:}';
			for($z = 0; $z < $a - 1; $z++)
				echo '\tab ' . countGreek($z + 1) . '.\tab ' . rtf($references[$z]) . '\par' . PHP_EOL;
			echo '\pard\plain\sa120\fi-1644\li1644\tx1134\tx1644\tab ' . countGreek($a) . '.';
		} else echo '\pard\plain\sa120\fi-1134\li1134\tx1134\qj{\b ����.:}';
		echo '\tab{\ul ' . rtf($references[$a - 1]) . '}\par' . PHP_EOL . PHP_EOL;
	} ?>
\pard\plain\sb120\sa120\fi567\tx1134\tx1701\tx2268\qj
<? }

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
<? }

/** ������ �� ���� ��� �������� �����, ���� �������� ���������� ������������ ��������. */
function postOrderCopy() {
	global $data; ?>
\pard\plain\par
\trowd\trkeep\trqc\trautofit1\trpaddfl3\trpaddl113\trpaddfr3\trpaddr113
\clftsWidth1\clNoWrap\cellx4394\clftsWidth1\clNoWrap\cellx8788\qc
������� ���������\line\line\line\line <?=person($data['����� ��������'])?>\line <?=rtf($data['�������� �����'])?>\cell
<?=person($data['�����'])?>\line ���������\cell\row
<? }