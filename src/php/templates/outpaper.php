<?
require_once('engine/init.php');
require_once('header.php');

$a = $bills_info['����������������������'];
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn2835\margbsxn1134
\pard\plain\qc\fs32\b\i\ul <?=chk($data['���������������'])?>\line\line\line\fs36 ������� ��������� �������\line\line\line\line\par
\pard\plain\box\brdrs\brdrw1\brsp28 {\b ����:} �<?=chk(ucwords($data['������']))?>�\par
\pard\par
\pard\plain\box\brdrs\brdrw1\brsp28 {\b ����:} <?=euro($data['����'])?>\par
\pard\par
\pard\plain\box\brdrs\brdrw1\brsp28 {\b ����������� �����:} <?=man_ext($data['���������'], 0)?>\par
\pard\par
\pard\plain\box\brdrs\brdrw1\brsp28 {\b ��������� �������:} <?=chk(chk_order($data['�����������']))?>\par
\pard\par
\pard\plain\box\brdrs\brdrw1\brsp28 {\b ��:} <?=chk($data['��'])?>\par
\pard\par
\pard\plain\box\brdrs\brdrw1\brsp28 {\b ��:} <? if (isset($data['��'])) echo $data['��']; ?>\par
\pard\line\line\line\line\line\line\par


\pard\plain\li6236\box\brdrs\brdrw1\brsp170\tqdec\tx9496

\b ������������\tab <?=euro($bills_info['������������'])?>\par
��������\tab <?=euro($bills_info['��������'])?>\par\par
���������\tab <?=euro($a['������'], true)?>\par\b0\tx6803\tqdec\tx9496
<?
	foreach($a as $k => $v)
		if ($k != '������')
			echo "\\tab $k\\tab " . euro($v) . '\par';
?>

\sect

