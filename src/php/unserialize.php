<?php
require_once('basic.php');

// ��������� ��� �������� ��� STDIN ���� ����� ���� ���������
$data = unserialize(stream_get_contents(STDIN));
if (!$data) trigger_error('�� ����������� �������� ����� �����', E_USER_ERROR);