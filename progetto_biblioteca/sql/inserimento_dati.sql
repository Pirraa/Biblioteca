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

INSERT INTO Autore (nome, cognome, data_nascita, luogo_nascita) VALUES
('Elena', 'Rossi', '1975-03-15', 'Ferrara'),
('Luca', 'Bianchi', '1980-07-22', 'Bologna'),
('Maria', 'Verdi', '1968-11-05', 'Modena');

INSERT INTO Libro (ISBN, titolo, anno_pubblicazione, succursale, lingua) VALUES
('978-88-123456-01', 'Introduzione all''Architettura Moderna', 2015, 'Architettura', 'Italiano'),
('978-88-123456-02', 'Fondamenti di Economia Aziendale', 2018, 'Economia e Management', 'Italiano'),
('978-88-123456-03', 'Fisica Quantistica: Teoria e Applicazioni', 2020, 'Fisica e Scienze della Terra', 'Italiano'),
('978-88-123456-04', 'Diritto Civile: Principi e Casi', 2017, 'Giurisprudenza', 'Italiano'),
('978-88-123456-05', 'Ingegneria dei Materiali Avanzati', 2019, 'Ingegneria', 'Italiano');

INSERT INTO AutoreLibro (id_autore, id_libro) VALUES
(1, 1),
(2, 2),
(3, 3),
(1, 4),
(2, 5);

INSERT INTO Utente (matricola, nome, cognome, indirizzo, telefono) VALUES
('U00001', 'Giovanni', 'Neri', 'Via Roma 10, Ferrara', '0532-123456'),
('U00002', 'Anna', 'Gialli', 'Via Bologna 20, Ferrara', '0532-654321'),
('U00003', 'Marco', 'Blu', 'Via Modena 30, Ferrara', '0532-789012');

INSERT INTO Prestito (id_libro, matricola, succursale, data_uscita, data_restituzione_prevista) VALUES
(1, 'U00001', 'Architettura', '2025-05-01', '2025-06-01'),
(2, 'U00002', 'Economia e Management', '2025-05-10', '2025-06-10'),
(3, 'U00003', 'Fisica e Scienze della Terra', '2025-05-15', '2025-06-15');