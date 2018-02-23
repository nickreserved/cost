<?

// ���������� ������ �������� ��� �� ������ ��������� ���������� ��� ����������
// ��� array $a
function calc_bills($a) {
	$b = array();
	foreach($a as $v) {
		calc_bills_sum($b, $v, '������������');
		calc_bills_sum($b, $v, '��������');
		calc_bills_sum($b, $v, '����������');
		calc_bills_sum($b, $v, '���������������');
		calc_bills_sum($b, $v, '��������');
		calc_bills_sum($b, $v, '����������������');
		calc_bills_sum_arr($b, $v, '�������������');
		calc_bills_sum_arr($b, $v, '����������������������');
	}
	return $b;
}

function calc_bills_sum_arr(& $b, $a, $i) {
	if (!isset($b[$i])) $b[$i] = array();
	foreach($a[$i] as $k => $v)
		if (!isset($b[$i][$k])) $b[$i][$k] = $v; else $b[$i][$k] += $v;
}

// �� �.�. ��� ������� �� $b['������������'] ����������� �� ��� �� ��������� $a
// �� ������� ���� �������� ��� �� ��������� $a
function calc_bills_sum(& $b, $a, $i) { if (!isset($b[$i])) $b[$i] = $a[$i]; else $b[$i] += $a[$i]; }


// ��� �� array $a ���������� �� ��������� ��� ����� ($f == true)
// � ��� ����� ($f == false) ���������� $i.
function getBillsCategory($a, $i, $f = true) {
	$b = array();
	foreach($a as $v)
		if (($v['���������'] == $i) == $f) $b[] = $v;
	return $b;
}

// ��� �� array $a ���������� �� ��������� ��� ����� ����� $i.
function getBillsType($a, $i) {
	$b = array();
	foreach($a as $v)
		if (strpos($i, "*{$v['�����������']['�����']}*") !== false) $b[] = $v;
	return $b;
}


// ���������� ��� array �� ��������� ��� ����� ��.
function bills_with_fe($a) {
	$b = array();
	foreach($a as $v)
		if ($v['���������']) $b[] = $v;
	return $b;
}

// ���������� ��� array �� keys ��� ��������� �� ������� ���
// values array �� ��� �� ��������� ��� ����� ������ �������.
// �� $zero == false ��� ���������� �� ��������� ��� �����
// ��������� 0 (������ �� ����� 0 ���� ��� �������)
function bills_by_hold($a, $zero = false) {
	$b = array();
	foreach($a as $v) {
		$n = $v['�������������������������']['������'];
		if ($n || $zero) $b[str_replace(',', '.', $n)][] = $v;
	}
	return $b;
}

// ���������� ��� array �� keys �� �� �� ������� ���
// values array �� ��� �� ��������� ��� ����� ������ ��.
// ��� ���������� ��������� ����� ��.
function bills_by_fe($a) {
	$b = array();
	foreach($a as $v) {
		$n = $v['���������'];
		if ($n) $b[str_replace(',', '.', $n)][] = $v;
	}
	return $b;
}

// ���������� ��� array �� keys ��� ���������� ���
// values array �� ��� �� ��������� ��� �����.
function bills_by_provider($a) {
	$b = array();
	foreach($a as $v)
		$b[$v['�����������']['��������']][] = $v;
	return $b;
}

// ���������� ��� array �� keys ��� "���� ����" �.�. "��� 2005" ���
// values array �� ��� �� ��������� ��� �����.
function bills_by_month($a) {
	$b = array();
	foreach($a as $v)
		if (preg_match('/\d{1,2}-(\d{1,2})-(\d{4})/', $v['���������'], $m)) {
			$b[mktime(0, 0, 0, $m[1], 1, $m[2])][] = $v;
		} else chk_bill($v['���������']);
	return $b;
}


// ������� ��� $a ��� ���������� ������� ��� RTF Spec ��� ������������� ����
// �� �������� �� backslash ��� �� ���������
function chk($a) { return preg_replace('/([\\\{\}])/', '$0$0', $a); }

// ������� ��� $a ��� ���������� ������� ��� RTF Spec ��� ������������� ����
// �� �������� �� backslash ��� �� ���������
function chk_measure($a) { return preg_replace('/^\<html\>(\w+)\<sup\>(\d+)$/', '$1{\super $2}', chk($a)); }

// ������� ��� ��������� ���� �������� ��� ������ �� ���� �� ����� �.�.
// �.830/23/3424/�.891/12 ��� 2005/7�� ���/4� ��.
// �.830/23/3424/�.891/12 ��� 05/7�� ���/4� ��.
// �� ��� ��� ���� ��� �� $warning ����� true ���� ������ ��� warning
function chk_order($a, $warning = true) {
	if (preg_match('/�\.?\d{3}(\.\d+)?\/\d+\/\d+\/�\.?\d+\/\d{2} (���|���|���|���|���|����|����|���|���|���|���|���) (\d{2}|\d{4})\/.+/', $a))
		return chk($a);
	if ($warning) trigger_error(($a ? "�� '<b>$a</b>' ��� ����� �����" : '���������') . ' ��������� ��������', E_USER_ERROR);
}

// ������� ��� ��������� ���� ���������� ��� ������ �� ���� �� ����� �.�.
// 123/21-04-1967
function chk_bill($a) {
	if (preg_match('/\d+\/\d{1,2}-\d{1,2}-\d{4}/', $a))
		return chk($a);
	trigger_error("�� '<b>$a</b>' ��� ����� ����� ��������� ���������� ���� �.�. �� 1324/31-12-2006", E_USER_ERROR);
}

// ������� ���������� ��� ������ �� ���� �� ����� �.�. 21 ��� 1967 � 21 ��� 67
function chk_date($a) {
	if (preg_match('/\d{1,2} (���|���|���|���|���|����|����|���|���|���|���|���) (\d{2}|\d{4})/', $a))
		return chk($a);
	trigger_error(($a ? "�� '<b>$a</b>' ��� ����� ����������" : '�� ����������� ������ �� ��������') . " ��� ����� �.�. '20 ��� 2005' � '20 ��� 05'");
}

// ������� ��� string ��� ������ "21:10 26 ��� 2006"
function chk_datetime($a) {
	if (preg_match('/\d{1,2} \d{1,2}\:\d{2} (���|���|���|���|���|����|����|���|���|���|���|���) \d{4}/', $a))
		return chk($a);
	trigger_error(($a ? "�� '<b>$a</b>' ��� ����� ������� ������" : '�� �������� ������� ������ �� ��������') . " ��� ����� �.�. '20 21:34 ��� 2005'");
}

// ������� ��� string ��� ������ "21:10 26 ��� 2006" ��� ���������� ��� ��� ��� ��� ����������
function get_datetime($a) {
	if (!preg_match('/(\d{1,2}) (\d{1,2}\:\d{2}) (���|���|���|���|���|����|����|���|���|���|���|���) (\d{4})/', $a, $m))
		trigger_error(($a ? "�� '<b>$a</b>' ��� ����� ������� ������" : '�� �������� ������� ������ �� ��������') . " ��� ����� �.�. '20 21:34 ��� 2005'");
	else {
		$b[] = $m[2]; $b[] = "{$m[1]} {$m[3]} {$m[4]}";
		return $b;
	}
}

function man($a) { return chk($a['������'] . ' ' . $a['�������������']); }

function man_ext($a, $c) {
	return inflection(man($a), $c) . (isset($a['������']) ? " {$a['������']}" : null);
}


// ����� ��� ������� �� ��������
//('�������', '����������', '����������', '������', '����������', '�������')
function get_order($a) {
	$m = null;
	if (preg_match('/(�\.?\d{3}(\.\d+)?)\/(\d+)\/(\d+)\/(�\.?\d+)\/(\d{2} (���|���|���|���|���|����|����|���|���|���|���|���) (\d{2}|\d{4}))\/(.+)/', $a, $m))
		return array('�������' => $m[1], '����������' => $m[3], '����������' => $m[4],
			'������' => $m[5], '����������' => $m[6], '�������' => $m[9]);
	chk_order($a);
}

// ���������� array �� ��� ����������
function getNewspapers($a) {
	$a = preg_split("/([ ]*,[ ]*)/", $a);
	foreach($a as & $v)
		$v = '��������� �' . toUppercase($v) . '�';
	return $a;
}

function getDates($a) {
	$a = preg_split("/([ ]*,[ ]*)/", $a);
	if (count($a) == 1) return chk_date($a[0]);
	$b = null;
	for ($z = 0; $z < count($a) - 1; $z++)
		$b .= ', ' . chk_date($a[$z]);
	$b .= ' ��� ' . chk_date($a[count($a) - 1]);
	return substr($b, 2);
}


// �� �� $a ����� �.�. 1234,1 ���������� '1.234,10 �'
// �� ��� ����� ������� ������ error ��� �� ����� 0 � null, ���������� null
function euro($a, $zero = false) {
	$a = num($a);
	if (!$a) return $zero ? '0,00 �' : null;
	else return sprintf('%01.2f �', $a);
}

// �� ��� ����� ������� ������ error ��� �� ����� 0 � null, ���������� 0
function percent($a) {
	$a = num($a);
	return !$a ? '0' : "$a%";
}

function num($a) {
	if (is_numeric($a)) return (float) $a;
	if ($a) trigger_error("� ���� '<b>$a</b>' �� ������ �� ����� �������");
}


function getEnvironment($a, $b = null) {
	if (isset($_ENV[$a])) {
		$a = $_ENV[$a];
		return $b ? $a == $b : $a;
	}
}

// convert a string to uppercase (in Greek capital letters has no tone)
// if we have e.g. "1�� �����" it returns "1�� �����"
function toUppercaseFull($s) {
	static $pre = array('/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/', '/�/');
	static $aft = array('�', '�', '�', '�', '�', '�', '�', '�');
	return preg_replace($pre, $aft, strtoupper($s));
}

// convert a string to uppercase (in Greek capital letters has no tone)
// if we have e.g. "1�� �����" it returns "1�� �����" and not "1�� ˼���"
function toUppercase($s) {
	return preg_replace_callback('/(\W|^)\D\w+/', create_function('$m', 'return toUppercaseFull($m[0]);'), $s);
}

// ���� � wordInflection ���� ������ ���� ��� ������ ��� ��������
// ����� �� ����� ����������� ��� 2 ��������
function inflection($a, $w) {
	return !$w ? $a : preg_replace_callback('/[�-��-��-��-�����]{3,}|\d+(��|�|�)/',
		create_function('$m', "return wordInflection(\$m[0], $w);"), $a);
}

// ���������� ��� ���������� ���� ��������� � ������� ��
// (1) ������, (2) ���������, (3) ������� ���� ��� ������
// ��� ����������� ����� �������
// � ���� ������ �� ����� �� ����� �������� (� ��������)
function wordInflection($o, $w) {
	$b = substr($o, -2);
	if ($b == '��' && $w == 1) return substr($o, 0, -1) . '�';
	elseif ($b == '��' && $w == 1) return substr($o, 0, -2) . '��';
	elseif ($w >= 2 && $w <= 3 && ($b == '��' || $b == '��') ||
					$w >= 1 && $w <= 3 && strpos('�� �� �� �� �� �� �� �� ', "$b ") !== false)
		return substr($o, 0, -1);
  elseif ($w == 1 && strpos('������', substr($o, -1)) !== false)
		return $o . '�';
	return $o;
}


// ���������� �� ����� �� ����� �.�. '05 ���� 2005'
function now($a = null) { return strftime('%d %b %Y', $a == null ? time() : $a); }


// returns the greek enumeration system for numbers 1 to 999
function countGreek($n) {
	if ($n < 1 || $n > 999) trigger_error("��� �� ����������� �� '<b>$n</b>' �� �������� �������� ������ �� ����� �������� ��� �� ������ ��� [1, 999]");
	static $m = array(null, '�', '�', '�', '�', '�', '��', '�', '�', '�');
	static $d = array(null, '�', '�', '�', '�', '�', '�', '�', '�', '\u991  ');
	static $e = array(null, '�', '�', '�', '�', '�', '�', '�', '�', '\u993  ');
	return $e[floor($n / 100)] . $d[floor($n / 10) % 10] . $m[$n % 10];
}


// �� ������ 100.91 �� ������ "����� ���� ��� �������� ��� �����"
function euro2str($d) {
	$a = int2str((int) floor($d), 2);
	$b = int2str((int) (($d - floor($d)) * 100 + 0.4), 2);
	if ($b != '�����') $b .= ' �����'; else $b = null;
	if ($a == '�����')
		return ($b == null) ? '����� ����' : $b;
	else
		return $a . ' ����' . ($b == null ? '' : ' ��� ' . $b);
}

// ���������� �� string ��� ������� ������� $n
// ��� �������� ��� 0 �� 999.999.999.999.999.999.999.999.999.999.999
// �������� �� php ��� ����������� integers ������������ ��� 2^31-1 (��� 32 bit ����������)
// �� $genos ���������� ��� ����� (�������� = 0, ������ = 1, �������� = 2)
function int2str($n, $genos) {
	if (!is_int($n) || $n < 0) return;
	if (!$n) return '�����';
	static $xilia = array('������', '������', '�����');
	static $polla = array('', '���', '����', '�������� ', '�������� ', '������ ', '������� ', '������� ', '�������� ');

	$out = null;
	$b = $n % 1000;
	$n = floor($n / 1000);
	if ($b) $out = int2str_1_999($b, $genos);
	if (!$n) return $out;

	$b = $n % 1000;
	$n = floor($n / 1000);
	if ($b) {
		if ($out) $out = ' ' . $out;
		if ($b == 1) $out = $xilia[$genos] . $out;
		else $out = int2str_1_999($b, 1) . ' ��������' . $out;
	}

	$c = 0;
	while($n) {
		$b = $n % 1000;
		$a = floor($n / 1000);
		if ($b) {
			if ($out) $out = ' ' . $out;
			if ($b == 1) $out = '��� �����������' . $out;
			else $out = int2str_1_999($b, 2) . ' ' . $polla[$c] . '�����������' . $out;
		}
		if (!$n) return $out;
		$c++;
	}
	return $out;
}

// ���������� �� string ��� ������� ������� $n ��� �������� ��� 1 �� 999.
// �� $genos ���������� ��� ����� (�������� = 0, ������ = 1, �������� = 2)
function int2str_1_999($n, $genos) {
	if (!is_int($n) || $n < 1 || $n > 999) return;

	static $ekatodades = array(
		array('�����', '������', '���������', '����������', '�����������', '�����������', '���������', '����������', '����������', '�����������'),
		array('�����', '������', '���������', '����������', '�����������', '�����������', '���������', '����������', '����������', '�����������'),
		array('�����', '������', '��������', '���������', '����������', '����������', '��������', '���������', '���������', '����������')
	);
  static $dekades = array('������', '�������', '�������', '�������', '������', '���������', '�������', '��������');
	static $monades = array(
		array('����', '���', '�����', '���������', '�����', '���', '����', '����', '�����', '����', '������', '������', '���������', '�������������', '���������', '�������', '��������', '��������', '���������'),
		array('���', '���', '����', '�������', '�����', '���', '����', '����', '�����', '����', '������', '������', '��������', '�����������', '���������', '�������', '��������', '��������', '���������')
	);

  $out = null;
	$a = floor($n / 100);
	$b = $n % 100;
	if ($a) {
		if (!$b && $a == 1) $a = 0;
		$out = $ekatodades[$genos][$a];
	}
	if (!$b) return $out;
	if ($out) $out .= ' ';
	if ($b < 20) {
		if ($genos == 1 && $b == 1) return $out . '���';
		return $out . $monades[$genos == 2 ? 1 : 0][$b - 1];
	}
	$out .= $dekades[floor($b / 10) - 2];
	$b = $n % 10;
	if (!$b) return $out;
	if ($genos == 1 && $b == 1) return $out . ' ���';
	return $out . ' ' . $monades[$genos == 2 ? 1 : 0][$b - 1];
}


?>