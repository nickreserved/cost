<?
require_once('engine/init.php');
require_once('header.php');

$a = $bills_info['����������������������'];
?>

\sectd\pgwsxn11906\pghsxn16838\marglsxn850\margrsxn850\margtsxn2835\margbsxn1134
\pard\plain\qc\fs32\b\i\ul <?=chk($data['���������������'])?>\line\line\line\fs36 ������� ��������� �������\line\line\line\line\par
\pard\plain\box\brdrs\brdrw1\brsp28 {\b ����:} �<?=chk($data['������'])?>�\par
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


\pard\tx1\tqdec\tx4457

\trowd
\clbrdrt\brdrs\brdrw1\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx5103
\clbrdrt\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx10206
\qc{\b ������� ���������\cell ������������ ����}\cell\row
\ql ���:\tab <? if (isset($a['���'])) echo euro($a['���']); ?>\cell\qc <?=euro($bills_info['������������'])?>\cell\row
\ql ���:\tab <? if (isset($a['���'])) echo euro($a['���']); ?>\cell\qc{\b �������� ����}\cell\row
\ql ������:\tab <? if (isset($a['������'])) echo euro($a['������']); ?>\cell\qc <?=euro($bills_info['��������'])?>\cell\row
\trowd
\clbrdrl\brdrs\brdrw1\clbrdrb\brdrs\brdrw1\clbrdrr\brdrs\brdrw1\cellx5103
\cellx10206
\ql �����:\tab <? if (isset($a['�����'])) echo euro($a['�����']); ?>\cell\cell\row
����:\tab <? if (isset($a['����'])) echo euro($a['����']); ?>\cell\cell\row
���������:\tab <? if (isset($a['���������'])) echo euro($a['���������']); ?>\cell\cell\row
��������� ���:\tab <? if (isset($a['���'])) echo euro($a['���']); ?>\cell\cell\row
������:\tab <? if (isset($a['������'])) echo euro($a['������']); ?>\cell\cell\row
{\b ������ ���������:\tab <? if (isset($a['������'])) echo euro($a['������'], true); ?>}\cell\cell\row

\sect

