create schema Biblioteca;
use Biblioteca;
-- 1. Tabella Autore
CREATE TABLE Autore (
    id_autore INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    data_nascita DATE,
    luogo_nascita VARCHAR(100)
);

-- 4. Tabella Dipartimento
CREATE TABLE Succursale (
    nome VARCHAR(100) PRIMARY KEY,
    indirizzo VARCHAR(255)
);

-- 2. Tabella Libro
CREATE TABLE Libro (
    id_libro INT PRIMARY KEY AUTO_INCREMENT,
    ISBN VARCHAR(20),
    titolo VARCHAR(255) NOT NULL,
    anno_pubblicazione INT,
    succursale VARCHAR(100),
    lingua VARCHAR(50),
    FOREIGN KEY (succursale) REFERENCES Succursale(nome) ON DELETE CASCADE
);

-- 3. Tabella di relazione AutoreLibro (N:N)
CREATE TABLE AutoreLibro (
    id_autore INT,
    id_libro INT,
    PRIMARY KEY (id_autore, id_libro),
    FOREIGN KEY (id_autore) REFERENCES Autore(id_autore) ON DELETE CASCADE,
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro) ON DELETE CASCADE
);

-- 6. Tabella Utente
CREATE TABLE Utente (
    matricola VARCHAR(6) PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cognome VARCHAR(100) NOT NULL,
    indirizzo VARCHAR(255),
    telefono VARCHAR(20)
);

-- 7. Tabella Prestito
CREATE TABLE Prestito (
    id_libro INT NOT NULL,
    matricola VARCHAR(6) NOT NULL,
    succursale varchar(100) NOT NULL,
    data_uscita DATE NOT NULL,
    data_restituzione_prevista DATE,
    PRIMARY KEY (id_libro, matricola, succursale),
    FOREIGN KEY (id_libro) REFERENCES Libro(id_libro) ON DELETE CASCADE,
    FOREIGN KEY (matricola) REFERENCES Utente(matricola) ON DELETE CASCADE,
    FOREIGN KEY (succursale) REFERENCES Succursale(nome) ON DELETE CASCADE
);