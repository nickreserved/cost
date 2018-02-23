!define PROGRAM "PHP Command Line Interpreter"
!define SHORTNAME "PHP_cli"
!define VERSION "5.6.15"
!define VER1 0x00050006
!define VER2 0x000F0000
!define �� "http://www.php.net"
!define VCREDIST_URL "http://www.microsoft.com/en-us/download/details.aspx?id=30679"

Name "${PROGRAM} ${VERSION}"
OutFile "..\php_cli.exe"

VIProductVersion "${VERSION}.0"
VIAddVersionKey "ProductName" "${PROGRAM}"
VIAddVersionKey "FileDescription" "The Command Line Interpreter for PHP Scripts"
VIAddVersionKey "LegalCopyright" "${��}"
VIAddVersionKey "FileVersion" "${VERSION}"


!include functions.nsh


Function .onInit

	# Check if Visual C++ 2012 Redistributable (ver. 11) is installed
	ReadRegDWORD $1 HKLM "Software\Wow6432Node\Microsoft\VisualStudio\11.0\VC\Runtimes\x32" Installed
	StrCmp $1 1 redistexist
	ReadRegDWORD $1 HKLM "Software\Wow6432Node\Microsoft\VisualStudio\11.0\VC\Runtimes\x64" Installed
	StrCmp $1 1 redistexist
	ReadRegDWORD $1 HKLM "Software\Microsoft\VisualStudio\11.0\VC\Runtimes\x32" Installed
	StrCmp $1 1 redistexist

	# If Visual C++ 2012 Redistributable Installer is in the same directory with this installer
	IfFileExists $EXEDIR\vcredist_x86.exe 0 +3
	ExecWait '"$EXEDIR\vcredist_x86.exe" /quiet'
	Goto redistexist
	IfFileExists $EXEDIR\vcredist_x64.exe 0 redistdownload
	ExecWait '"$EXEDIR\vcredist_x64.exe" /quiet'
	Goto redistexist

redistdownload:
	MessageBox MB_YESNO|MB_ICONEXCLAMATION "��� �� ������������ �� PHP Command Line Interpreter$\n������ �� ���������� ��� �������������$\n�� Microsoft Visual C++ 2012 Redistributable.$\n������ �� �� ���������� ����;" /SD IDNO IDNO redistabort
	ExecShell "open" "${VCREDIST_URL}"
	Abort

redistabort:
	Abort 'Microsoft Visual C++ 2012 Redistributable MUST be installed'

redistexist:

FunctionEnd


Section
	Call PHPstatus
	IntCmp $0 2 0 phpinstall phpend
	MessageBox MB_YESNO|MB_ICONEXCLAMATION "������� � ������ PHP Command Line Interpreter $1 ��� ������ �� ����� ���������� ���� ������ ${VERSION}.$\n$\n������ ������� ������ ��� � ���������� ������ ��������������� ��� ������ web server. �� ������ ���� ������, ��� ����������� �� ����������.$\n$\n�� ���� � ����������� ����� ��������������� ���� ��� ���� ��� ��� ����� ������������ ������ web server � ��� ������������� ������ ��� ����, ���������� �� ���������� ��� PHP ���� ������ ${VERSION}.$\n$\n������ �� �� ������������;" /SD IDNO IDNO phpend

phpinstall:
	SetOutPath $WINDIR
	File ..\php5ts.dll
	File ..\php.exe

phpend:

SectionEnd
