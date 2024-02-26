
DROP DATABASE IF EXISTS e_commerce;
CREATE DATABASE e_commerce;
USE e_commerce;

CREATE TABLE CATEGORIA (
    idCategoria INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    descrizione TEXT
);

CREATE TABLE PRODUTTORE (
    idProduttore INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    descrizione TEXT,
    StatoResidenza VARCHAR(255),
    tipologiaProdotti VARCHAR(255)
);

CREATE TABLE PRODOTTO (
    idProdotto INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    descrizione TEXT,
    numeroProdotti INT,
    prezzo DECIMAL(10, 2),
    idProduttore INT,
    FOREIGN KEY (idProduttore) REFERENCES PRODUTTORE(idProduttore)
);


CREATE TABLE ACCESSORIO (
    idAccessorio INT PRIMARY KEY AUTO_INCREMENT,
    descrizione TEXT,
    prezzo DECIMAL(10, 2),
    idProdotto INT,
    FOREIGN KEY (idProdotto) REFERENCES PRODOTTO(idProdotto)
);

CREATE TABLE UTENTE (
    idUtente INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    cognome VARCHAR(255),
    sesso VARCHAR(1),
    metodoPagamento VARCHAR(255),
    mail VARCHAR(255),
    numeroTelefono VARCHAR(20)
);

CREATE TABLE RECENSIONE (
    idRecensione INT PRIMARY KEY AUTO_INCREMENT,
    titolo VARCHAR(255),
    contenuto TEXT,
    stelle INT,
    idUtente INT,
    idProdotto INT,
    FOREIGN KEY (idUtente) REFERENCES UTENTE(idUtente),
    FOREIGN KEY (idProdotto) REFERENCES PRODOTTO(idProdotto)
);

CREATE TABLE ORDINE (
    idOrdine INT PRIMARY KEY AUTO_INCREMENT,
    data DATE,
    costoTotale DECIMAL(10, 2),
    idUtente INT,
    FOREIGN KEY (idUtente) REFERENCES UTENTE(idUtente)
);

CREATE TABLE CARRELLO (
    idCarrello INT PRIMARY KEY AUTO_INCREMENT,
    costoAttuale DECIMAL(10, 2),
    idUtente INT,
    FOREIGN KEY (idUtente) REFERENCES UTENTE(idUtente)
);

CREATE TABLE INDIRIZZO (
    idIndirizzo INT PRIMARY KEY AUTO_INCREMENT,
    via VARCHAR(255),
    stato VARCHAR(255),
    citta VARCHAR(255),
    CAP VARCHAR(10),
    idUtente INT,
    FOREIGN KEY (idUtente) REFERENCES UTENTE(idUtente)
);

CREATE TABLE CREDENZIALI (
    idCredenziale INT PRIMARY KEY AUTO_INCREMENT,
    nomeUtente VARCHAR(255),
    password VARCHAR(255),
    privilegi int(5),-- 1->cliente & 2->admin
    idUtente INT,
    FOREIGN KEY (idUtente) REFERENCES UTENTE(idUtente)
);

CREATE TABLE CATEGORIA_PRODOTTI (
    idCategoria INT,
    idProdotto INT,
    PRIMARY KEY (idCategoria, idProdotto),
    FOREIGN KEY (idCategoria) REFERENCES CATEGORIA(idCategoria),
    FOREIGN KEY (idProdotto) REFERENCES PRODOTTO(idProdotto)
);

CREATE TABLE CARRELLO_PRODOTTI (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idCarrello INT,
    idProdotto INT,
    idAccessorio INT,
    FOREIGN KEY (idCarrello) REFERENCES CARRELLO(idCarrello),
    FOREIGN KEY (idProdotto) REFERENCES PRODOTTO(idProdotto)
);

CREATE TABLE ORDINE_PRODOTTI (
    id INT PRIMARY KEY AUTO_INCREMENT,
    idOrdine INT,
    idProdotto INT,
    idAccessorio INT,
    FOREIGN KEY (idOrdine) REFERENCES ORDINE(idOrdine),
    FOREIGN KEY (idProdotto) REFERENCES PRODOTTO(idProdotto),
    FOREIGN KEY (idAccessorio) REFERENCES ACCESSORIO(idAccessorio)
);

CREATE TABLE IMMAGINE_PRODOTTO (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255),
    idProdotto int,
    FOREIGN KEY (idProdotto) REFERENCES PRODOTTO(idProdotto)
);
    
-- Inserimento valori per la tabella CATEGORIA
INSERT INTO CATEGORIA (idCategoria, nome, descrizione) VALUES
(1, 'Elettronica', 'Prodotti elettronici'),
(2, 'Abbigliamento', 'Vestiti e accessori'),
(3, 'Casa', 'Articoli per la casa');

-- Inserimento valori per la tabella PRODUTTORE
INSERT INTO PRODUTTORE (idProduttore, nome, descrizione, StatoResidenza, tipologiaProdotti) VALUES
(1, 'Samsung', 'Produttore di elettronica', 'Corea del Sud', 'Telefoni e dispositivi elettronici'),
(2, 'Nike', 'Azienda di abbigliamento sportivo', 'Stati Uniti', 'Abbigliamento sportivo'),
(3, 'IKEA', 'Azienda di mobili e arredamento', 'Svezia', 'Mobili e articoli per la casa');

-- Inserimento valori per la tabella PRODOTTO
INSERT INTO PRODOTTO (idProdotto, nome, descrizione, numeroProdotti, prezzo, idProduttore) VALUES
(1, 'Galaxy S21', 'Smartphone Samsung', 100, 899.99, 1),
(2, 'Air Max', 'Scarpe sportive Nike', 200, 129.99, 2),
(3, 'Billy', 'Libreria IKEA', 50, 49.99, 3);

-- Inserimento valori per la tabella ACCESSORIO
INSERT INTO ACCESSORIO (idAccessorio, descrizione, prezzo, idProdotto) VALUES
(1, 'Cover in silicone', 19.99, 1),
(2, 'Calze sportive', 9.99, 2),
(3, 'Vetrina a due ante', 29.99, 3);

-- Inserimento valori per la tabella UTENTE
INSERT INTO UTENTE (idUtente, nome, cognome, sesso, metodoPagamento, mail, numeroTelefono) VALUES
(1, 'Mario', 'Rossi', 'M', 'Carta di credito', 'mario.rossi@email.com', '1234567890'),
(2, 'Anna', 'Verdi', 'F', 'PayPal', 'anna.verdi@email.com', '9876543210');

-- Inserimento valori per la tabella RECENSIONE
INSERT INTO RECENSIONE (idRecensione, titolo, contenuto, stelle, idUtente, idProdotto) VALUES
(1, 'Ottime prestazioni', 'Il Galaxy S21 ha prestazioni eccezionali.', 5, 1, 1),
(2, 'Comode e di qualità', 'Le Air Max sono estremamente comode e di alta qualità.', 4, 2, 2);

-- Inserimento valori per la tabella ORDINE
INSERT INTO ORDINE (idOrdine, data, costoTotale, idUtente) VALUES
(1, '2024-02-17', 149.98, 1),
(2, '2024-02-18', 179.98, 2);

-- Inserimento valori per la tabella CARRELLO
INSERT INTO CARRELLO (idCarrello, costoAttuale, idUtente) VALUES
(1, 149.98, 1),
(2, 179.98, 2);

-- Inserimento valori per la tabella INDIRIZZO
INSERT INTO INDIRIZZO (idIndirizzo, via, stato, citta, CAP, idUtente) VALUES
(1, 'Via Roma 123', 'Italia', 'Roma', '00100', 1),
(2, '123 Main Street', 'Stati Uniti', 'New York', '10001', 2);

-- Inserimento valori per la tabella CREDENZIALI
INSERT INTO CREDENZIALI (idCredenziale, nomeUtente, password, privilegi, idUtente) VALUES
(1, 'mario_rossi', '$2y$10$v2z4TMg46ShavCO2A06p2OdA1paRNBjOMIYvxSthMO3rk9lpp/S9m', 1, 1), -- password123
(2, 'anna_verdi', '$2y$10$AtJ6Oay0.JZu0SxrSrav5OcPm43P3Gu1CqYD33LhaKE4aZqAJbGbS', 1, 2), -- securepwd456
(3, '!', '$2y$10$AtJ6Oay0.JZu0SxrSrav5OcPm43P3Gu1CqYD33LhaKE4aZqAJbGbS', 2, null); -- securepwd456

-- Inserimento valori per la tabella CATEGORIA_PRODOTTI
INSERT INTO CATEGORIA_PRODOTTI (idCategoria, idProdotto) VALUES
(1, 1),
(2, 2),
(3, 3);

-- Inserimento valori per la tabella CARRELLO_PRODOTTI
INSERT INTO CARRELLO_PRODOTTI (id,idCarrello, idProdotto) VALUES
(1,1, 1),
(2,2, 2);

INSERT INTO ORDINE_PRODOTTI (id,idOrdine,idProdotto,idAccessorio) VALUES
(1,1,1,null),
(2,2,2,2);

INSERT INTO IMMAGINE_PRODOTTO (id,nome,idProdotto) VALUES
(1,'galaxy_s21.jpg',1),
(2,'air_max.jpg',2),
(3,'billy.jpg',3);