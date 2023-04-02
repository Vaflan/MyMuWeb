# MuOnline Open Source WebSite

    Name: MyMuWeb <MMW>
    Created: 2009-03-17
    Repository: https://github.com/Vaflan/MyMuWeb
    Author: Ruslans Jermakovics <Vaflan>
    Contact: http://mymuweb.ru


## Instruction
*********************************************************************
First step, you need to set up a php environment:
* On Windows system ~ C:\WINDOWS\php.ini (extensions with .dll)
* On Linux system ~ /etc/php/phpX.X/php.ini

      extension = gd2
      extension = pdo
      extension = odbc
      extension = pdo_odbc
      error_reporting = E_ALL & ~E_NOTICE

*********************************************************************
The second step, add library if database uses MD5
* Copy 'WZ_MD5_MOD.dll' from project, to Microsoft SQL 'Server\MSSQL\Binn\'
*********************************************************************
The third step is to change socks
* Change `config.php` and replace 'IP Address', 'Login', 'Password', 'DataBase'
* If you will be installing from a non-local ip, you set CUSTOM_IP_ADDRESS in install.php
* Open installation http://localhost/install.php
*********************************************************************


## FAQ
* How to add functions?
  * add `someFunction.php` to 'includes/func/' folder.
* How to add Mp3 to Player?
    * add `song.mp3` to 'media/' folder.
* How to add new language?
    * add `language_name.php` to 'lang/' folder.
* How to add Theme?
    * extract `theme.zip` to 'themes/' folder and change in config.php `$mmw['theme']`.
*********************************************************************


### Thanks for using MyMuWeb by Vaflan!
Special thanks to the **x-Mu** Community: https://x-mu.net/?board=84.0