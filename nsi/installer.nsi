# -------------------------------------------------------------- definitions ---
!define PROGRAM "������������ �������"
!define SHORTNAME "Cost"
!define VERSION "1.4.2"
!define ME "������(��) ������ ������"
!define JAVA_RE_URL "http://www.java.com/"
!define JAVA_VERSION "1.5"
!define PHP_RE_URL "http://tassadar.physics.auth.gr/~chameleon/programs/cost/program/php_cli.exe"

# ------------------------------------------------------------------ general ---
Name "${PROGRAM} ${VERSION}"
OutFile "..\cost_${VERSION}.exe"
InstallDir "$PROGRAMFILES\������������ �������"
InstallDirRegKey HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "UninstallString"
Icon "..\cost.ico"
UninstallIcon "..\cost.ico"

# -------------------------------------------------------------------- pages ---
Page components
Page directory
Page instfiles
UninstPage uninstConfirm
UninstPage instfiles

# --------------------------------------------------------------- properties ---
LoadLanguageFile "${NSISDIR}\Contrib\Language files\Greek.nlf"
VIProductVersion "${VERSION}.0"
VIAddVersionKey /LANG=${LANG_GREEK} "ProductName" "${PROGRAM}"
VIAddVersionKey /LANG=${LANG_GREEK} "FileDescription" "��������� ��� ������� ��������������� ������������ �������"
VIAddVersionKey /LANG=${LANG_GREEK} "LegalCopyright" "${��}"
VIAddVersionKey /LANG=${LANG_GREEK} "FileVersion" "${VERSION}"

# ----------------------------------------------------- check for php & java ---
Function .onInit
	IfFileExists $WINDIR\php.exe 0 +3
	IfFileExists $WINDIR\php5ts.dll phpexists
	IfFileExists $WINDIR\php4ts.dll phpexists
	IfFileExists $EXEDIR\php_cli.exe 0 +3
	ExecWait '"$EXEDIR\php_cli.exe" /S'
	Goto phpexists
	MessageBox MB_YESNO|MB_ICONEXCLAMATION "��� �� ������������ �� ��������� ������ ��$\n���������� �� PHP Command Line Interpreter.$\n������ �� �� ���������� ����;" IDNO +2
	ExecShell "open" "${PHP_RE_URL}"
	Abort
phpexists:

	ReadRegStr $1 HKLM "Software\JavaSoft\Java Runtime Environment" "CurrentVersion"
	StrCmp $1 "" javanotexist
	ReadRegStr $0 HKLM "SOFTWARE\JavaSoft\Java Runtime Environment\$1" "JavaHome"
	StrCpy $0 "$0\bin\javaw.exe"
	StrCpy $2 $1 1
	StrCpy $3 $1 1 2
	StrCpy $4 "${JAVA_VERSION}" 1
	StrCpy $5 "${JAVA_VERSION}" 1 2
	IntCmp $2 $4 0 javaoldexists javaexists
	IntCmp $3 $5 0 javaoldexists
	Goto javaexists

javaoldexists:
	MessageBox MB_YESNO|MB_ICONEXCLAMATION "����� ������������� �� Java Runtime Environment $1$\n��� �� ��������� ������� �� ${JAVA_VERSION} ��� ����.$\n������ �� �� ���������� ����;" IDNO +3 IDYES +2
javanotexist:
	MessageBox MB_YESNO|MB_ICONEXCLAMATION "��� �� ������������ �� ��������� ������$\n�� ���������� �� Java Runtime Environment ${JAVA_VERSION}.$\n������ �� �� ���������� ����;" IDNO +2
	ExecShell "open" "${JAVA_RE_URL}"
	Abort
javaexists:
FunctionEnd


# ----------------------------------------------------- default installation ---
Section

	SetOutPath $INSTDIR

	File ..\dist\Cost.jar
	File /r ..\dist\php
	File ..\*.txt
	File ..\cost.ico

	IfFileExists $INSTDIR\main.ini 0 +2
	MessageBox MB_YESNO|MB_ICONEXCLAMATION|MB_DEFBUTTON2 "��� ������ ������������ ������� �� ����� ��� ������ main.ini$\n��� ����������� �� �� ����������$\n������ �� �� ��������;" IDNO +2
	File ..\dist\main.ini

	WriteRegStr HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "DisplayName" "${PROGRAM}"
	WriteRegStr HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "UninstallString" '"$INSTDIR\uninstall.exe"'
	WriteRegStr HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "DisplayIcon" '"$INSTDIR\uninstall.exe"'
	WriteRegDWORD HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "NoModify" 1
	WriteRegDWORD HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "NoRepair" 1
	WriteUninstaller "uninstall.exe"

	WriteRegStr HKCR ".cost" "" "������ �������"
	WriteRegStr HKCR ".cost\DefaultIcon" "" "$INSTDIR\cost.ico"
	WriteRegStr HKCR ".cost\Shell" "" "�������"
	WriteRegStr HKCR ".cost\Shell\�������\Command" "" '"$0" -jar "$INSTDIR\cost.jar" "%1"'

SectionEnd

# --------------------------------------------------------------- start menu ---
Section '������������ ��� ����� "������"'

	CreateShortCut "$SMPROGRAMS\${PROGRAM}.lnk" $SYSDIR\javaw.exe "-jar $\"$INSTDIR\cost.jar$\"" "$INSTDIR\cost.ico" "" "" ALT|CONTROL|D "��������� ��������� ������������ �������$\n������: ${VERSION}$\n���������������: ${ME}$\n����� ������: GNU GPL"

SectionEnd

# -------------------------------------------------------------- source code ---
Section /o '������� �������'

	SetOutPath "$INSTDIR\source"

	File /r ..\src
	File /r ..\nbproject
	File /r ..\nsi
	File ..\manifest.mf
	File ..\build.xml

SectionEnd

# --------------------------------------------------------------------- help ---
Section '�������'

	SetOutPath $INSTDIR

	File /r ..\help

SectionEnd

# ------------------------------------------------------------------ scripts ---
Section '������� Scripts'

	SetOutPath $INSTDIR

	File /r ..\scripts

SectionEnd

# -------------------------------------------------------------- Uninstaller ---

Section "Uninstall"

	DeleteRegKey HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}"
	Delete "$SMPROGRAMS\${PROGRAM}.lnk"
	DeleteRegKey HKCR ".cost"

	IfFileExists $INSTDIR\main.ini 0 +2
	MessageBox MB_YESNO|MB_ICONEXCLAMATION|MB_DEFBUTTON2 "��� ������ main.ini ���������� ��� �� �������� ��� ������������.$\n��� ����������� �� �� ����������.$\n������ �� �� ��������;" IDNO +3
	RMDir /r $INSTDIR
	Goto end

	Delete "$INSTDIR\Cost.*"
	Delete "$INSTDIR\*.txt"
	Delete "$INSTDIR\*.exe"
	RMDir /r "$INSTDIR\php"
	RMDir /r "$INSTDIR\help"
	RMDir /r "$INSTDIR\source"
	RMDir /r "$INSTDIR\scripts"
end:
SectionEnd
