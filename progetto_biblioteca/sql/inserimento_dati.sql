USE Biblioteca;

-- Inserimento succursali
INSERT INTO Succursale (nome, indirizzo) VALUES
('Architettura', 'Via Ghiara, 36 - 44121 Ferrara'),
('Economia e Management', 'Via Voltapaletto n. 11 - 44121 Ferrara'),
('Fisica e Scienze della Terra', 'Via Saragat, 1 - 44122 Ferrara'),
('Giurisprudenza', 'Corso Ercole I d''Este n. 37 - 44121 Ferrara'),
('Ingegneria', 'Via Saragat, 1 - 44122 Ferrara'),
('Matematica e Informatica', 'Via Machiavelli, 30 - 44121 Ferrara'),
('Medicina Traslazionale e per la Romagna', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Neuroscienze e Riabilitazione', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Scienze Chimiche, Farmaceutiche ed Agrarie', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Scienze dell''Ambiente e della Prevenzione', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Scienze della Vita e Biotecnologie', 'Via Luigi Borsari, 46 - 44121 Ferrara'),
('Scienze Mediche', 'Via Fossato di Mortara, 64/B - 44121 Ferrara'),
('Studi Umanistici', 'Via Paradiso, 12 - 44121 Ferrara');

-- Inserimento autori
INSERT INTO Autore (nome, cognome, data_nascita, luogo_nascita) VALUES
('Mario', 'Rossi', '1970-05-12', 'Ferrara'),
('Lucia', 'Bianchi', '1985-09-20', 'Bologna'),
('Giorgio', 'Verdi', '1968-02-10', 'Modena');

-- Inserimento libri (nota: rimosso campo 'succursale' che non esiste in Libro)
INSERT INTO Libro (ISBN, titolo, anno_pubblicazione, lingua) VALUES
('9788812345601', 'Introduzione all\'Architettura Moderna', 2015, 'Italiano'),
('9788812345602', 'Fondamenti di Economia Aziendale', 2018, 'Italiano'),
('9788812345603', 'Fisica Quantistica: Teoria e Applicazioni', 2020, 'Italiano'),
('9788812345604', 'Diritto Civile: Principi e Casi', 2017, 'Italiano'),
('9788812345605', 'Ingegneria dei Materiali Avanzati', 2019, 'Italiano');

-- Associazione Autori-Libri
-- Per sicurezza, meglio recuperare id_libro da Libro in base a ISBN (se id_autore e id_libro non sono certi)
-- Ma se sicuro degli ID, lascio così
INSERT INTO AutoreLibro (id_autore, ISBN) VALUES
(1, 9788812345601),
(2, 9788812345602),
(3, 9788812345603),
(1, 9788812345604),
(2, 9788812345605),
(3, 9788812345601),
(1, 9788812345602),
(2, 9788812345603);

-- Inserimento utenti
INSERT INTO Utente (matricola, nome, cognome, indirizzo, telefono) VALUES
('000001', 'Elena', 'Neri', 'Via Roma 10, Ferrara', '0532-111111'),
('000002', 'Carlo', 'Blu', 'Via Bologna 15, Ferrara', '0532-222222'),
('000003', 'Anna', 'Verdi', 'Via Modena 20, Ferrara', '0532-333333');

-- Inserimento copie (3 per ciascun libro)
INSERT INTO CopiaLibro (ISBN, succursale) VALUES
('9788812345601', 'Architettura'),
('9788812345601', 'Architettura'),
('9788812345601', 'Architettura'),
('9788812345602', 'Economia e Management'),
('9788812345602', 'Economia e Management'),
('9788812345602', 'Economia e Management'),
('9788812345603', 'Fisica e Scienze della Terra'),
('9788812345603', 'Fisica e Scienze della Terra'),
('9788812345603', 'Fisica e Scienze della Terra'),
('9788812345604', 'Giurisprudenza'),
('9788812345604', 'Giurisprudenza'),
('9788812345604', 'Giurisprudenza'),
('9788812345605', 'Ingegneria'),
('9788812345605', 'Ingegneria'),
('9788812345605', 'Ingegneria');

-- Inserimento prestiti
INSERT INTO Prestito (id_copia, matricola, data_uscita, data_restituzione_prevista) VALUES
(1, '000001', '2025-06-01', '2025-07-01'),
(4, '000002', '2025-06-05', '2025-07-05'),
(7, '000003', '2025-06-10', '2025-07-10');
