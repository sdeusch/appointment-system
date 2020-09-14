# Massage Online Buchen System

## Installation

1.  unzip appointment-system.tar.gz in htdocs Folder von Apache

2.  Datenbank Erstellen
    2.1 In phpMyAdmin, erstelle eine neue Datenbank names 'db_massage'.
    2.2 Installiere das Datenmodel in Datei db_massage_datamodel_create.sql
    Ein paar Beispiel Daten sind inkludiert zur Demonstration.

    2.3 Falls die Datenbank mit einem Passwort geschützt ist (normalerweise nicht der Fall in XAMPP)
    bitte das Passwort in Datei ~/assets/conn/dbconnect.php ändern.
    Das Quellkode im zip hat "" als Passwort:
    $con = mysqli_connect("localhost","root","","db_massage");
       Ansonsten muss das Passwort eingegeben werden:
           $con = mysqli_connect("localhost","root","secret123","db_massage");

3.  Benutzung
    3.1 Admin Backoffice für Angestellte
    Rechts unten ist eine Link im Footer für Angestellte 'admin login' zum Einloggen
    http://localhost/appointment-system/adminlogin.php
    Verwenden '123456' als ID und '123' als Passwort.
    Es gibt auch Angestellte '234567' und '345678' mit gleichem Passwort.

        Angestellte können ihre eigenen Daten ändern, Kunden und Termine löschen, und
        am wichtigsten, Angestellet können ihre Arbeitszeiten planen.
        Falls jemand an einem Tag nur von 9 bis 12 arbeiten kann, gibt man unter
        'Arbeit Planen' ein.

    3.2 Kunden Administration
    Kunden können sich selbst registrieren (Sign Up) und Termine buchen.
    Sie müssen dazu auf das Datum klicken (nicht das Kalendersymbol), eine Tag auswählen,
    dann den Therapeuten wählen, dann einen Termin buchen.
    Falls das Zeitinterval auserhalb der Arbeitsplanung (Tabelle work_schedule) des
    Therapeuten liegt, oder falls ein anderer Termin überlappt, wird ein Fehler angezeigt.
    Ein vorinstallierter Kunde ist lukas@gmail.com / 123.
    (Anmerkung: Alle Passwörter im System sind '123')
