<?php

$db = Database::getInstance(); 

$autor = $db->query("
CREATE TABLE autor (
	id_autor INT NOT NULL AUTO_INCREMENT,
	imie VARCHAR(45) NOT NULL,
	nazwisko VARCHAR(45) NULL,
	data_urodzenia DATE NULL,
	opis_autora TEXT NULL,
	zdjecie VARCHAR(255) NULL,
	PRIMARY KEY (id_autor)
) ENGINE = InnoDB;
");
if($autor)
    echo "CREATE TABLE autor <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$wydawnictwo = $db->query("
CREATE TABLE wydawnictwo (
	id_wydawnictwo INT NOT NULL AUTO_INCREMENT,
	nazwa VARCHAR(255) NOT NULL,
	adres_WWW VARCHAR(255) NULL,
	logo VARCHAR(255) NULL,
	PRIMARY KEY (id_wydawnictwo)
) ENGINE = InnoDB;
");
if($wydawnictwo)
    echo "CREATE TABLE wydawnictwo <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$ksiazka = $db->query("
CREATE TABLE ksiazka (
	id_ksiazka INT NOT NULL AUTO_INCREMENT,
	id_wydawnictwo INT NOT NULL,
	tytul VARCHAR(255) NOT NULL,
	opis TEXT NULL,
	ISBN DECIMAL(13) NULL,
	ilosc_stron SMALLINT NULL,
	rok_wydania DECIMAL(4) NULL,
	jezyk_wydania VARCHAR(45) NULL,
	zdjecie_okladki VARCHAR(255) NULL,
	cena DECIMAL(5,2) NOT NULL,
	ilosc_sztuk INT NOT NULL DEFAULT 0,
	PRIMARY KEY (id_ksiazka),
	CONSTRAINT fk_ksiazka_wydawnictwo
		FOREIGN KEY (id_wydawnictwo)
		REFERENCES wydawnictwo (id_wydawnictwo)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB;
");
if($ksiazka)
    echo "CREATE TABLE ksiazka <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$czytelnik = $db->query("
CREATE TABLE czytelnik (
	id_czytelnik INT NOT NULL AUTO_INCREMENT,
	login VARCHAR(45) NOT NULL,
	haslo VARCHAR(128) NOT NULL,
	email VARCHAR(255) NOT NULL,
	imie VARCHAR(45) NULL,
	nazwisko VARCHAR(45) NULL,
	plec VARCHAR(10) NULL,
	rok_urodzenia DECIMAL(4) NULL,
	opis_czytelnika TEXT NULL,
	zdjecie VARCHAR(255) NULL,
  PRIMARY KEY (id_czytelnik)
) ENGINE = InnoDB;
");
if($czytelnik)
    echo "CREATE TABLE czytelnik <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$recenzja = $db->query("
CREATE TABLE recenzja (
	id_recenzja INT NOT NULL AUTO_INCREMENT,
	id_ksiazka INT NOT NULL,
	id_czytelnik INT NOT NULL,
	tytul VARCHAR(255) NULL,
	tresc TEXT NULL,
	ocena TINYINT NULL,
	data_dodania DATETIME NULL,
	PRIMARY KEY (id_recenzja),
	CONSTRAINT fk_recenzja_ksiazka
		FOREIGN KEY (id_ksiazka)
		REFERENCES ksiazka (id_ksiazka)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION,
	CONSTRAINT fk_recenzja_czytelnik
		FOREIGN KEY (id_czytelnik)
		REFERENCES czytelnik (id_czytelnik)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB;
");
if($recenzja)
    echo "CREATE TABLE recenzja <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$kategoria = $db->query("
CREATE TABLE kategoria (
	id_kategoria INT NOT NULL AUTO_INCREMENT,
	nazwa VARCHAR(255) NOT NULL,
	PRIMARY KEY (id_kategoria)
) ENGINE = InnoDB;
");
if($kategoria)
    echo "CREATE TABLE kategoria <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$ksiazka_autor = $db->query("
CREATE TABLE ksiazka_autor (
	id_ksiazka INT NOT NULL,
	id_autor INT NOT NULL,
	PRIMARY KEY (id_ksiazka, id_autor),
	CONSTRAINT fk_ksiazka_autor_ksiazka
		FOREIGN KEY (id_ksiazka)
		REFERENCES ksiazka (id_ksiazka)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION,
	CONSTRAINT fk_ksiazka_autor_autor
		FOREIGN KEY (id_autor)
		REFERENCES autor (id_autor)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB;
");
if($ksiazka_autor)
    echo "CREATE TABLE ksiazka_autor <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$ksiazka_kategoria = $db->query("
CREATE TABLE ksiazka_kategoria (
	id_ksiazka INT NOT NULL,
	id_kategoria INT NOT NULL,
	PRIMARY KEY (id_ksiazka, id_kategoria),
	CONSTRAINT fk_ksiazka_kategoria_ksiazka
		FOREIGN KEY (id_ksiazka)
		REFERENCES ksiazka (id_ksiazka)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION,
	CONSTRAINT fk_ksiazka_kategoria_kategoria
		FOREIGN KEY (id_kategoria)
		REFERENCES kategoria (id_kategoria)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB;
");
if($ksiazka_kategoria)
    echo "CREATE TABLE ksiazka_kategoria <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$zamowienie = $db->query("
CREATE TABLE zamowienie (
	id_zamowienie INT NOT NULL AUTO_INCREMENT,
	id_czytelnik INT NOT NULL,
	koszt DECIMAL(5,2) NOT NULL,
	data_wystawienia DATETIME NOT NULL,
	data_realizacji DATETIME NULL,
	zrealizowane TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (id_zamowienie),
	CONSTRAINT fk_zamowienie_czytelnik
		FOREIGN KEY (id_czytelnik)
		REFERENCES czytelnik (id_czytelnik)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB;
");
if($zamowienie)
    echo "CREATE TABLE zamowienie <br>";
else
    echo "ERROR: " . $db->error . "<br>";

$zamowienie_ksiazka = $db->query("
CREATE TABLE zamowienie_ksiazka (
	id_zamowienie INT NOT NULL,
	id_ksiazka INT NOT NULL,
	ilosc_sztuk INT NOT NULL DEFAULT 1,
	PRIMARY KEY (id_zamowienie, id_ksiazka),
	CONSTRAINT fk_zamowienie_ksiazka_zamowienie
		FOREIGN KEY (id_zamowienie)
		REFERENCES  zamowienie (id_zamowienie)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION,
	CONSTRAINT fk_zamowienie_ksiazka_ksiazka
		FOREIGN KEY (id_ksiazka)
		REFERENCES ksiazka (id_ksiazka)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB;
");
if($zamowienie_ksiazka)
    echo "CREATE TABLE zamowienie_ksiazka <br>";
else
    echo "ERROR: " . $db->error . "<br>";
