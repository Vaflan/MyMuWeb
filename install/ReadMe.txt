####################################
# MyMuWeb ReadMe                   #
# Thank For use MyMuWeb by Vaflan. #
# http://www.mymuweb.ru/           #
# vaflancher@inbox.lv              #
####################################

If you don't understand what need to do, or leave MuOnline or write here - http://mymuweb.ru/forum/22-2989-1
*********************************************************************
For security use xampp 5.5.30 - https://www.apachefriends.org/ru/download.html
To use this website with SQL 2008 make this - http://mymuweb.ru/forum/10-3235-1
For security and speed use SQL 2008 R2 - https://www.microsoft.com/ru-ru/download/details.aspx?id=30438

Open ..\WINDOWS\php.ini and edit:
598 " ;extension=php_mssql.dll " - delete " ; " 
649 " sql.safe_mode = Off " change to " În " 

Open ..\apache\conf\httpd.conf and edit:
" #LoadModule rewrite_module modules/mod_rewrite.so - delete " # " 

*********************************************************************
Configure website, Open 'config.php'
First Change: IP Address, Login, Password, DataBase
*********************************************************************
Export DataBase, Open Browser:
Put install.php in /htdocs(or /www) directory from /install folder
http://127.0.0.1/install.php
*********************************************************************

After install delete /install folder
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

How to add Language?
add language_name.php to 'lang/' folder.

How to add Theme?
add folder to 'themes/', and change in config.php $mmw[theme].
!--------------------------------------------------------------------!