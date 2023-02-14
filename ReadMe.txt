####################################
# MyMuWeb ReadMe                   #
# Thank For use MyMuWeb by Vaflan. #
# http://www.mymuweb.ru/           #
# vaflancher@inbox.lv              #
####################################


*********************************************************************
link appache 2.5.8 http://mymuweb.ru/forum/21-732-1

Open ..\WINDOWS\php.ini and edit:
598 " ;extension=php_mssql.dll " - delete " ; " 
649 " sql.safe_mode = Off " change to " În " 
1045 " mssql.secure_connection = Off " change to " În "
*********************************************************************
link mssql 2000 http://mymuweb.ru/forum/21-679-1
if you use md5 on,Update MSSQL, Copy File 'WZ_MD5_MOD.dll'
To: ..\Program File\Microsoft SQL Server\MSSQL\Binn\'
*********************************************************************
Configure website, Open 'config.php'
First Change: 'SQL PASS'
*********************************************************************
Export DataBase, Open Browser:
http://127.0.0.1/install.php
*********************************************************************

After install delete install.php and WZ_MD5_MOD.dll, ReadMe.txt and ChangeLog.txt it's optional.
Good luck ;)
!-------------------------------------------------------------------!
To Create Admin Need:
Register in web, and in MEMB_INFO table with your name, 
change 'mmw_stats' Colums - '0' to '10'. (0: Member, 5: GM, 10: Admin)
Admin Username = Your Login in Reg WebSite
Admin Password = Your Password in Reg WebSite
Admin SecurityCode = '***'

How to add Functions?
add functions.php to 'includes/func/' folder.

How to add Mp3 to Player?
add all need mp3 to 'media/' folder.

How to add Language?
add language_name.php to 'lang/' folder.

How to add Theme?
add folder to 'themes/', and change in config.php $mmw[theme].
!--------------------------------------------------------------------!