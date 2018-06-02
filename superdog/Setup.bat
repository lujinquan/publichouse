rem This is the file of registering COM control of GrandDog.
rem If you want to unregister the COM control, using "regsvr32 /u dog_com_windows.dll
"

%~d0
cd %~dp0

if "%SystemRoot%"=="" goto Win98ME

:Win2KXP
%SystemRoot%\System32\regsvr32 dog_com_windows.dll

goto End

:Win98ME
%WinDir%\System\regsvr32 dog_com_windows.dll


:End