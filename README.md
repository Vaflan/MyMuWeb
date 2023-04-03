# Open source MuOnline website

    Name: MyMuWeb <MMW>
    Created: 2009-03-17
    Repository: https://github.com/Vaflan/MyMuWeb
    Author: Ruslans Jermakovics <Vaflan>
    Contacts: http://mymuweb.ru


## Instruction
*********************************************************************
First step, you need to set up your php environment:
* Minimum PHP version must be 5.3 (extreme low 5.2)
* On Windows system ~ C:\WINDOWS\php.ini (extensions with .dll)
* On a Linux system ~ /etc/php/phpX.X/php.ini

      extension = gd2
      extension = pdo
      extension = odbc
      extension = pdo_odbc
      error_reporting = E_ALL & ~E_NOTICE

*********************************************************************
Second step, add the library if the database uses MD5.
* Copy "WZ_MD5_MOD.dll" from project to Microsoft SQL "Server\MSSQL\Binn\"
*********************************************************************
The third step is to change socks.
* Change `config.php` and replace 'IP Address', 'Login', 'Password', 'DataBase'
* If you will be installing from a non-local ip, you set CUSTOM_IP_ADDRESS in install.php
* Open install http://localhost/install.php
*********************************************************************
Running the CLI Web Server from Remote Computers
* Open the site folder in the console where index.php is located
* Run the command below and you will have a PHP site up and running (minimum 5.4)
* If your php is not available in the global environment, write instead of `php` - the full path to `C:\php54\php.exe`
* You can also specify your own configuration file for php `-c php.ini`
* More information about [Built-in web server](https://www.php.net/manual/en/features.commandline.webserver.php)

      php -S 0.0.0.0:8000

*********************************************************************


## FAQ
* How to add features?
    * add `someFunction.php` to 'includes/func/' folder.
* How to add MP3 to the player?
    * add `song.mp3` to 'media/' folder.
* How to add new language?
    * add `language_name.php` to 'lang/' folder.
* How to add theme?
    * extract `theme.zip` to 'themes/' folder and change `$mmw['theme']` in config.php.
*********************************************************************


### Thanks for using MyMuWeb by Vaflan!
Special thanks to the **x-Mu** community: https://x-mu.net/?board=84.0