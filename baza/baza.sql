
-- Tabela autor

CREATE TABLE IF NOT EXISTS autor ( -- jeśli tabela nie istnieje stworzy ją
	id_autor INT AUTO_INCREMENT NOT NULL,
	imie VARCHAR(45) NOT NULL,
	nazwisko VARCHAR(45) NULL,
	data_urodzenia DATE NULL,
	opis_autora TEXT NULL,
	zdjecie VARCHAR(255) NULL, -- url do zdjęcia
	PRIMARY KEY (id_autor) -- klucz główny
) ENGINE = InnoDB;


-- Tabla wydawnictwo

CREATE TABLE IF NOT EXISTS wydawnictwo (
	id_wydawnictwo INT AUTO_INCREMENT NOT NULL,
	nazwa VARCHAR(255) NOT NULL,
	adres_WWW VARCHAR(255) NULL,
	logo VARCHAR(255) NULL, -- url do zdjęcia
	PRIMARY KEY (id_wydawnictwo)
) ENGINE = InnoDB;


-- Tabla ksiazka

CREATE TABLE IF NOT EXISTS ksiazka (
	id_ksiazka INT AUTO_INCREMENT NOT NULL,
	id_wydawnictwo INT NOT NULL,
	tytul VARCHAR(255) NOT NULL,
	opis TEXT NULL,
	ISBN DECIMAL(13) NULL,
	ilosc_stron SMALLINT NULL, -- 2 bajty
	rok_wydania DECIMAL(4) NULL,
	jezyk_wydania VARCHAR(45) NULL,
	zdjecie_okladki VARCHAR(255) NULL,
	cena DECIMAL(5,2) NOT NULL,
	ilosc_sztuk INT NOT NULL DEFAULT 0,
	PRIMARY KEY (id_ksiazka),
	CONSTRAINT fk_ksiazka_wydawnictwo
		FOREIGN KEY (id_wydawnictwo) -- klucz obcy
		REFERENCES wydawnictwo (id_wydawnictwo)
		ON DELETE NO ACTION -- jeśli klucz obcy istnieje nie można usunąć rekordu
		ON UPDATE NO ACTION
) ENGINE = InnoDB;


-- Tabla czytelnik

CREATE TABLE IF NOT EXISTS czytelnik (
	id_czytelnik INT AUTO_INCREMENT NOT NULL,
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


-- Tabla recenzja

CREATE TABLE IF NOT EXISTS recenzja (
	id_recenzja INT AUTO_INCREMENT NOT NULL,
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


-- Tabla kategoria

CREATE TABLE IF NOT EXISTS kategoria (
	id_kategoria INT AUTO_INCREMENT NOT NULL,
	nazwa VARCHAR(255) NOT NULL,
	PRIMARY KEY (id_kategoria)
) ENGINE = InnoDB;


-- Tabla ksiazka_autor

CREATE TABLE IF NOT EXISTS ksiazka_autor (
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


-- Tabla ksiazka_kategoria

CREATE TABLE IF NOT EXISTS ksiazka_kategoria (
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


-- Tabla zamowienie

CREATE TABLE IF NOT EXISTS zamowienie (
	id_zamowienie INT AUTO_INCREMENT NOT NULL,
	id_czytelnik INT NOT NULL,
	koszt DECIMAL(5,2) NOT NULL,
	data_wystawienia DATETIME NOT NULL,
	data_realizacji DATETIME NULL,
	zrealizowane TINYINT(1) NOT NULL DEFAULT 0, -- 0-nie, 1-tak
	PRIMARY KEY (id_zamowienie),
	CONSTRAINT fk_zamowienie_czytelnik
		FOREIGN KEY (id_czytelnik)
		REFERENCES czytelnik (id_czytelnik)
		ON DELETE NO ACTION
		ON UPDATE NO ACTION
) ENGINE = InnoDB;


-- Tabla zamowienie_ksiazka

CREATE TABLE IF NOT EXISTS zamowienie_ksiazka (
	id_zamowienie INT NOT NULL,
	id_ksiazka INT NOT NULL,
	ilosc_sztuk INT NOT NULL DEFAULT 1, -- domyślnie minimalna liczba sztuk zamówienia
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
