﻿!include installer_common.nsh
!include functions.nsh

OutFile "..\cost_${VERSION}.exe"


# ----------------------------------------------------- check for php & java ---
Function .onInit
	# Check for PHP
	Call PHPstatus
	IntCmp 3 $0 phpend
	IfFileExists $EXEDIR\php_cli.exe 0 +3
	ExecWait '"$EXEDIR\php_cli.exe" /S'
	Goto phpend
	IntCmp  0 $0 0 phpend
	MessageBox MB_YESNO|MB_ICONEXCLAMATION "Για να λειτουργήσει το πρόγραμμα πρέπει να$\nκατεβάσετε το PHP Command Line Interpreter.$\nΘέλετε να το κατεβάσετε τώρα;" IDNO +2
	ExecShell "open" "${PHP_RE_URL}"
	Abort
phpend:

	# Check for Java
	SetRegView 32	# Check 32-bit registry
	ReadRegStr $1 HKLM "Software\JavaSoft\Java Runtime Environment" "CurrentVersion"
	StrCmp $1 "" java64	# javanotexist
	ReadRegStr $0 HKLM "SOFTWARE\JavaSoft\Java Runtime Environment\$1" "JavaHome"
	StrCpy $0 "$0\bin\javaw.exe"
	StrCpy $2 $1 1
	StrCpy $3 $1 1 2
	StrCpy $4 "${JAVA_VERSION}" 1
	StrCpy $5 "${JAVA_VERSION}" 1 2
	IntCmp $2 $4 0 javaoldexists javaexists
	IntCmp $3 $5 0 javaoldexists
	Goto javaexists
java64:
	SetRegView 64	# Check 64-bit registry
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
	MessageBox MB_YESNO|MB_ICONEXCLAMATION "Έχετε εγκατεστημένο το Java Runtime Environment $1$\nκαι το πρόγραμμα απαιτεί το ${JAVA_VERSION} και πάνω.$\nΘέλετε να το κατεβάσετε τώρα;" IDNO +3 IDYES +2
javanotexist:
	MessageBox MB_YESNO|MB_ICONEXCLAMATION "Για να λειτουργήσει το πρόγραμμα πρέπει$\nνα κατεβάσετε το Java Runtime Environment ${JAVA_VERSION}.$\nΘέλετε να το κατεβάσετε τώρα;" IDNO +2
	ExecShell "open" "${JAVA_RE_URL}"
	Abort
javaexists:
FunctionEnd