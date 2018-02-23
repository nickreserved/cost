# -------------------------------------------------------------- definitions ---
!define PROGRAM "������������ �������"
!define SHORTNAME "Cost"
!define VERSION "2018.2.25"
!define ME "������ ������ (�.�.�. 2002)"
!define JAVA_VERSION "1.8"
!define PHP_VERSION "5.6.15"
!define VER1 0x00050006
!define VER2 0x000F0000
!define PHP_RE_URL "https://sourceforge.net/projects/ha-expenditure/files/redistributable/x32/php_cli.exe/download"
!define JAVA_RE_URL "http://www.oracle.com/technetwork/java/javase/downloads/"

# ------------------------------------------------------------------ general ---
Name "${PROGRAM} ${VERSION}"
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
VIAddVersionKey /LANG=${LANG_GREEK} "LegalCopyright" "${ME}"
VIAddVersionKey /LANG=${LANG_GREEK} "FileVersion" "${VERSION}"


# ----------------------------------------------------- default installation ---
Section

	SetOutPath $INSTDIR

	File ..\dist\Cost.jar
	File /r ..\src\php
	File ..\*.txt
	File ..\cost.ico

	WriteRegStr HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "DisplayName" "${PROGRAM}"
	WriteRegStr HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "UninstallString" '"$INSTDIR\uninstall.exe"'
	WriteRegStr HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "DisplayIcon" '"$INSTDIR\uninstall.exe"'
	WriteRegDWORD HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "NoModify" 1
	WriteRegDWORD HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}" "NoRepair" 1
	WriteUninstaller "uninstall.exe"

	WriteRegStr HKLM "Software\Classes\.cost" "" "������ �������"
	WriteRegStr HKLM "Software\Classes\.cost\DefaultIcon" "" "$INSTDIR\cost.ico"
	WriteRegStr HKLM "Software\Classes\.cost\Shell" "" "�������"
	WriteRegStr HKLM "Software\Classes\.cost\Shell\�������\Command" "" '"$0" -jar "$INSTDIR\cost.jar" "%1"'

SectionEnd

# --------------------------------------------------------------- start menu ---
Section '������������ ��� ����� "������"'

	#CreateShortCut "$SMPROGRAMS\${PROGRAM}.lnk" "$0" "-jar $\"$INSTDIR\cost.jar$\"" "$INSTDIR\cost.ico" "" "" ALT|CONTROL|D "��������� ��������� ������������ �������$\n������: ${VERSION}$\n���������������: ${ME}$\n����� ������: BSD"
	CreateShortCut "$SMPROGRAMS\${PROGRAM}.lnk" "$INSTDIR\cost.jar" "" "$INSTDIR\cost.ico" "" "" ALT|CONTROL|D "��������� ��������� ������������ �������$\n������: ${VERSION}$\n���������������: ${ME}$\n����� ������: BSD"

SectionEnd

# -------------------------------------------------------------- source code ---
Section /o '������� �������'

	SetOutPath "$INSTDIR\source"

	File /r ..\src
	File /r ..\nbproject
	File /r ..\nsi
	File ..\build.xml

SectionEnd

# --------------------------------------------------------------------- help ---
Section '�������'

	SetOutPath $INSTDIR

	File /r ..\help

SectionEnd


# -------------------------------------------------------------- Uninstaller ---

Section "Uninstall"

	DeleteRegKey HKLM "Software\Microsoft\Windows\CurrentVersion\Uninstall\${SHORTNAME}"
	Delete "$SMPROGRAMS\${PROGRAM}.lnk"
	DeleteRegKey HKCR ".cost"

	IfFileExists $PROFILE\cost.ini 0 +2
	MessageBox MB_YESNO|MB_ICONEXCLAMATION|MB_DEFBUTTON2 "��� ������ cost.ini ���������� ��� �� �������� ��� ������������.$\n��� ����������� �� �� ����������.$\n������ �� �� ��������;" IDNO +2
	Delete $PROFILE\cost.ini
	RMDir /r $INSTDIR

SectionEnd