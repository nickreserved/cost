/* ----------------------------------------------------- ������� �� ������� ������������� �� PHP ---
���� ��� �����:
$0: 0: ��� ����� �������������, 1: ����� update, 2: ����� update ���� ������� web server, 3: up-to-date
$1: � ����� ������, �� �������
�����������: $2, $3
*/
Function PHPstatus
	IfFileExists $WINDIR\php.exe 0 PHPstatusinstall
	
	GetDllVersion '$WINDIR\php.exe' $1 $2				# Check version of php.exe
	IntCmpU ${VER1} $1 0 PHPstatusend +2
	IntCmpU ${VER2} $2 PHPstatusend PHPstatusend
	
	IntOp $0 $1 & 0xFFFF
	IntOp $1 $1 >> 16
	IntOp $3 $2 & 0xFFFF
	IntOp $2 $2 >> 16
	StrCpy $1 "$1.$0.$2.$3";

	IfFileExists $WINDIR\php.ini 0 PHPstatusupdate		# If php.ini exists, maybe a web server exist. Don't screw it.
	StrCpy $0 2
	Return
PHPstatusend:
	StrCpy $1 ''
	StrCpy $0 3
	Return
PHPstatusupdate:
	StrCpy $0 1
	Return
PHPstatusinstall:
	StrCpy $1 ''
	StrCpy $0 0
FunctionEnd

/* ------------------------------------------------------------------- compare 2 version strings ---
�������� �� ${VersionCompare} $version1 $version2 $out
To $out �����:
	0: $version1 == $version2
	1: $version1 > $version2
	2: $version1 < $version1
*/
Function VersionCompare
	!define VersionCompare `!insertmacro VersionCompareCall`
 
	!macro VersionCompareCall _VER1 _VER2 _RESULT
		Push `${_VER1}`
		Push `${_VER2}`
		Call VersionCompare
		Pop ${_RESULT}
	!macroend
 
	Exch $1
	Exch
	Exch $0
	Exch
	Push $2
	Push $3
	Push $4
	Push $5
	Push $6
	Push $7
 
	begin:
	StrCpy $2 -1
	IntOp $2 $2 + 1
	StrCpy $3 $0 1 $2
	StrCmp $3 '' +2
	StrCmp $3 '.' 0 -3
	StrCpy $4 $0 $2
	IntOp $2 $2 + 1
	StrCpy $0 $0 '' $2
 
	StrCpy $2 -1
	IntOp $2 $2 + 1
	StrCpy $3 $1 1 $2
	StrCmp $3 '' +2
	StrCmp $3 '.' 0 -3
	StrCpy $5 $1 $2
	IntOp $2 $2 + 1
	StrCpy $1 $1 '' $2
 
	StrCmp $4$5 '' equal
 
	StrCpy $6 -1
	IntOp $6 $6 + 1
	StrCpy $3 $4 1 $6
	StrCmp $3 '0' -2
	StrCmp $3 '' 0 +2
	StrCpy $4 0
 
	StrCpy $7 -1
	IntOp $7 $7 + 1
	StrCpy $3 $5 1 $7
	StrCmp $3 '0' -2
	StrCmp $3 '' 0 +2
	StrCpy $5 0
 
	StrCmp $4 0 0 +2
	StrCmp $5 0 begin newer2
	StrCmp $5 0 newer1
	IntCmp $6 $7 0 newer1 newer2
 
	StrCpy $4 '1$4'
	StrCpy $5 '1$5'
	IntCmp $4 $5 begin newer2 newer1
 
	equal:
	StrCpy $0 0
	goto end
	newer1:
	StrCpy $0 1
	goto end
	newer2:
	StrCpy $0 2
 
	end:
	Pop $7
	Pop $6
	Pop $5
	Pop $4
	Pop $3
	Pop $2
	Pop $1
	Exch $0
FunctionEnd