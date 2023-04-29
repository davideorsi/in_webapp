# eseguire con python3
import sqlite3
import time
import locale
import datetime

conn=sqlite3.connect('IN.sqlite');

# Cambia date da stringa al formato giusto
cur=conn.execute("SELECT * from `Voci di Locanda`");
rows=cur.fetchall();
cur.execute("DROP TABLE IF EXISTS `Voci di Locanda`")
cur.execute("CREATE TABLE `Voci di Locanda`(ID INT, Data DATE, Testo TEXT, Chiusa TEXT, Bozza INT, PRIMARY KEY (ID))")
locale.setlocale(locale.LC_TIME, "it_IT.utf8");
for row in rows:
	tt=time.strftime('%Y-%m-%d',time.strptime(row[1],'%d %B %Y'));
	
	conn.execute("INSERT INTO `Voci di Locanda`(ID, Data, Testo,Chiusa,Bozza) values (?, ?, ?, ?, ?)", (row[0],tt,row[2],row[3],row[4]))

conn.commit()	


# Cambia date da stringa al formato giusto
cur=conn.execute("SELECT * from `Eventi`");
rows=cur.fetchall();
cur.execute("DROP TABLE IF EXISTS `Eventi`")
cur.execute("CREATE TABLE `Eventi`(ID INT, Titolo TEXT, Data DATE, Luogo TEXT, Orari TEXT, Info TEXT, Tipo TEXT, PRIMARY KEY (ID))")
locale.setlocale(locale.LC_TIME, "it_IT.utf8");
for row in rows:
	tt=time.strftime('%Y-%m-%d',time.strptime(row[2],'%d %B %Y'));
	
	conn.execute("INSERT INTO `Eventi`(ID, Titolo, Data, Luogo, Orari, Info, Tipo) values (?, ?, ?, ?, ?, ?, ?)", (row[0],row[1],tt,row[3],row[4],row[5],row[6]))

conn.commit()


# Cambia date da stringa al formato giusto
cur=conn.execute("SELECT * from `messaggi`");
rows=cur.fetchall();
cur.execute("DROP TABLE IF EXISTS `messaggi`")
cur.execute("CREATE TABLE 'messaggi' ('id' INTEGER PRIMARY KEY, 'mittente' TEXT, 'destinatario' TEXT, 'data' TEXT, 'testo' TEXT, 'costo' INTEGER, 'intercettato' INTEGER, 'pagato' INTEGER, 'tipo_mittente' TEXT, 'tipo_destinatario' TEXT)")
locale.setlocale(locale.LC_TIME, "it_IT.utf8");
for row in rows:
	tt=time.strftime('%Y-%m-%d',time.strptime(row[3],'%d %B %Y'));
	
	conn.execute("INSERT INTO `messaggi` (id,mittente,destinatario,data,testo,costo,intercettato,pagato,tipo_mittente,tipo_destinatario) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", (row[0],row[1],row[2],tt,row[4],row[5],row[6],row[7],row[8],row[9]))

conn.commit()



## Crea tabelle mancanti ##############################################
# Assegna categorie ai PNG
cur=conn.execute("CREATE TABLE `Categorie-PNG` (`ID` INTEGER, `PNG`	INTEGER NOT NULL, `CAT`	INTEGER NOT NULL, PRIMARY KEY (ID))");

## Assegna i PG ai live a cui si sono iscritti
cur=conn.execute("CREATE TABLE `Eventi-PG` (`ID` INTEGER, `PG`	INTEGER NOT NULL, `Evento` INTEGER NOT NULL, 'Arrivo' TEXT, 'Pernotto' INTEGER, 'Cena' INTEGER, 'Note' TEXT, PRIMARY KEY (ID))");

# lista di oggetti o opzioni di scelta fornite da una abilità
cur=conn.execute("CREATE TABLE `Ability-Opzioni` (`ID` INTEGER, 'Abilita' INTEGER, 'Opzione' TEXT, 'Costo' INTEGER, PRIMARY KEY (ID))");

# post di ambientazione
cur=conn.execute("CREATE TABLE `ambientazione` (`id` INTEGER, `titolo` TEXT NOT NULL, `tag` TEXT NOT NULL, `testo` TEXT NOT NULL, PRIMARY KEY(id));");
