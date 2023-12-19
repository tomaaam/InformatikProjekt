# Version2

S1: BlockJumpingGame
S2: Snake
S3: SuperTikTakToe
S4: 2048
S5: Tetris



Programmierprojekt Informatik

1) Sinatra-Script on Ruby installieren und kennenlernen => 22.11. (https://rubydoc.info/gems/sinatra)
	- Programm "läuft im Browser" => Localhost/HTTP-Adresse
	- Zur Kommunikation mit Datenbanken wird die "Sequel"-Extension empfohlen (https://github.com/rtomayko/sinatra-sequel)
	- Quellen:
		- https://www.scaleway.com/en/docs/tutorials/sinatra/ (gute Quelle)
		- https://www.sitepoint.com/mysql-data-web/
		- https://www.twilio.com/docs/usage/tutorials/how-to-set-up-your-ruby-and-sinatra-development-environment (nicht hilfreich)

	=> Entscheidung für PHP, Verwerfung von Sinatra und Ruby...


2) PHP-Script und Testumgebung aufbauen		    => 29.11. (DONE)

   - Nutzung von XAMPP, PHP Script problemlos, Verbindung zu HTML über Ajax
2) Datenbank erstellen (SQLite oder MySQL) 		    => 29.11. (DONE)
   - SQLite NICHT geeignet für Web-Orientieren Zugang auf die Datenbank
   - XAMPP => SQL-Database auf localhost (myphpadmin) + php-Workspace (Webserver)
 
3) Web- und Datenbankserver				 	    => 18.12. (DONE)
   - Spalten: ID (INT), USERNAME (VARCHAR, 20), SCORE (INT), DATE (DATE)
   - ID (INT, AUTO_INCREMENT), USERNAME (VARCHAR, 20, DEFAULT=Anonym), SCORE (INT), DATE (datetime, current_timestamp())

4) Implementation in HTML der anderen Gruppen	    => 19.12. (PENDING)
   - Erstellung der Tables für die Spiele
   - 

5) Absprechung und Anpassung an die anderen Gruppen (OPEN)

Links:
- https://entwickler.de/php/php-tutorial-datenbankprogrammierung-mit-php-und-mysql
- https://youtu.be/ifddQHjefxk?si=ZidfCelH-GBcFexS
