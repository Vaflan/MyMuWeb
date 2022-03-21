####################################
# MyMuWeb ReadMe                   #
# Thank For use MyMuWeb by Vaflan. #
# http://www.mymuweb.ru/           #
# vaflancher@inbox.lv              #
####################################


*********************************************************************
Update AppServer, Opne File: C:\WINDOWS\php.ini
You need 576 cols - ;extension=php_mssql.dll - delete simbel ';'.
And 942 cols - mssql.secure_connection = Off - 'Îff' change to 'În'.
*********************************************************************
Update MSSQL, Copy File 'WZ_MD5_MOD.dll'
To: Microsoft SQL 'Server\MSSQL\Binn\'
*********************************************************************
Change config.php, Open 'config.php'
Change: 'IP Address', 'Login', 'Password', 'DataBase'
*********************************************************************
Export DataBase, Open Browser:
http://127.0.0.1/install.php
*********************************************************************


!-------------------------------------------------------------------!
To Create Admin Need:
Register in web, and in MEMB_INFO table with your name, 
change 'mmw_stats' Colums - '0' to '9'.
Level (3 - GM, 6 - Mini Admin, 9 - Admin)
Admin Username = Your Login in Reg WebSite
Admin Password = Your Password in Reg WebSite
Admin SecurityCode = '4321'

How to add Mp3 to Player?
add all need mp3 to 'media' folder.

How to add Language?
add language_name.php to 'lang' folder.

How to add Theme?
add folder to 'themes', and change in config.php $mmw[theme].
!--------------------------------------------------------------------!