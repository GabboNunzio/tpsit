-- ============================================================
--  DATABASE: poeti_italiani
--  Esegui in phpMyAdmin oppure dalla CLI:
--    mysql -u root -p < database.sql
-- ============================================================
CREATE DATABASE IF NOT EXISTS poeti_italiani CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE poeti_italiani;

CREATE TABLE IF NOT EXISTS correnti (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  periodo VARCHAR(100) NULL,
  descrizione TEXT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS poeti (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(150) NOT NULL,
  corrente_id INT NULL,
  nascita YEAR NULL,
  morte YEAR NULL,
  is_movimento TINYINT(1) NOT NULL DEFAULT 0,
  caratteristiche TEXT NULL,
  bio TEXT NULL,
  bio_link VARCHAR(500) NULL,
  immagine_path VARCHAR(500) NULL,
  FOREIGN KEY (corrente_id) REFERENCES correnti(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS opere (
  id INT AUTO_INCREMENT PRIMARY KEY,
  poeta_id INT NOT NULL,
  titolo VARCHAR(300) NOT NULL,
  anno YEAR NULL,
  FOREIGN KEY (poeta_id) REFERENCES poeti(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS opposizioni (
  id INT AUTO_INCREMENT PRIMARY KEY,
  corrente_a VARCHAR(200) NOT NULL,
  caratteristiche_a TEXT NOT NULL,
  corrente_b VARCHAR(200) NOT NULL,
  caratteristiche_b TEXT NOT NULL,
  ordine INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO correnti (nome, periodo, descrizione) VALUES
('Positivismo','Tardo Ottocento','Fiducia nella scienza, nel progresso e nel metodo sperimentale.'),
('Scapigliatura','1860-1870','Gruppo milanese antiborghese, cupo e sperimentale.'),
('Naturalismo','Seconda meta Ottocento','Impersonalita, determinismo scientifico, osservazione oggettiva.'),
('Verismo','Seconda meta Ottocento','Variante italiana del Naturalismo, focalizzata sul mondo popolare meridionale.'),
('Decadentismo','Fine Ottocento','Simbolismo, crisi dei valori positivisti, esaltazione dell irrazionale.'),
('Decadentismo / Estetismo','Fine Ottocento','Superuomo, culto della bellezza, sensualita.'),
('Avanguardie','Primo Novecento','Rottura radicale con la tradizione. Futurismo, Dadaismo, Espressionismo.'),
('Crepuscolarismo','Primo Novecento','Toni dimessi, quotidiano modesto, rifiuto del dannunzianesimo.'),
('Modernismo','Primo Novecento','Inettitudine, psicoanalisi, crisi dell identita.'),
('Modernismo / Teatro','Primo Novecento','Relativismo, maschere sociali, rivoluzione del teatro.'),
('Ermetismo','Anni 1920-1940','Poesia essenziale, simbolismo oscuro, interiorita.'),
('Poesia onesta','Primo Novecento','Semplicita, autobiografismo, distanza dalle avanguardie.'),
('Neorealismo','Anni 1940-1960','Rappresentazione del reale, impegno civile, dopoguerra.'),
('Testimonianza','Anni 1940-1960','Memoria storica, Shoah, imperativo morale della scrittura.'),
('Neorealismo / Testimonianza','Anni 1940-1960','Resistenza partigiana narrata con rigore e asciuttezza.'),
('Neorealismo -> Sperimentazione','Anni 1950-1980','Dal neorealismo alla narrativa combinatoria e fantastica.');

INSERT INTO poeti (nome,corrente_id,nascita,morte,is_movimento,caratteristiche,bio,bio_link) VALUES
('Positivismo',1,NULL,NULL,1,'Fiducia nella scienza, progresso, metodo sperimentale.','Movimento culturale europeo del tardo Ottocento.',NULL),
('Scapigliatura',2,NULL,NULL,1,'Antiborghese, cupa, sperimentale. Reazione romantica e bohemienne alla societa borghese.','Gruppo di artisti e scrittori milanesi ribelli degli anni 1860-70.',NULL),
('Gustave Flaubert',3,1821,1880,0,'Impersonalita, osservazione oggettiva della realta, stile preciso e antiromantico.','Scrittore francese, uno dei massimi esponenti del Naturalismo europeo.','https://www.treccani.it/enciclopedia/gustave-flaubert/'),
('Emile Zola',3,1840,1902,0,'Determinismo scientifico, romanzo come esperimento sociale. Teorico del Naturalismo francese.','Scrittore e giornalista francese, teorico e principale esponente del Naturalismo.','https://www.treccani.it/enciclopedia/emile-zola/'),
('Giovanni Verga',4,1840,1922,0,'Impersonalita narrativa, rappresentazione del mondo popolare siciliano, tecnica della regressione.','Scrittore siciliano, massimo esponente del Verismo italiano.','https://www.treccani.it/enciclopedia/giovanni-verga/'),
('Decadentismo',5,NULL,NULL,1,'Simbolismo, crisi dei valori positivisti, irrazionale, estetismo.','Movimento letterario e artistico europeo di fine Ottocento.',NULL),
('Giovanni Pascoli',5,1855,1912,0,'Poetica del fanciullino, uso dei simboli, dolore per lutti familiari, linguaggio pre-grammaticale.','Poeta romagnolo la cui vita fu segnata dalla morte del padre.','https://www.treccani.it/enciclopedia/giovanni-pascoli/'),
('Gabriele D Annunzio',6,1863,1938,0,'Culto del superuomo, sensualita, estetismo, vita come opera d arte.','Scrittore e poeta abruzzese, figura centrale del Decadentismo italiano.','https://www.treccani.it/enciclopedia/gabriele-d-annunzio/'),
('Futurismo (Marinetti)',7,1876,1944,0,'Esaltazione della velocita, della tecnologia e della guerra. Rottura radicale col passato.','Filippo Tommaso Marinetti, fondatore del movimento futurista nel 1909.','https://www.treccani.it/enciclopedia/filippo-tommaso-marinetti/'),
('Crepuscolari',8,NULL,NULL,1,'Toni dimessi, quotidiano modesto, poesia fragile, rifiuto del dannunzianesimo.','Movimento poetico italiano dei primi del Novecento. Anti-dannunziani per eccellenza.',NULL),
('Sergio Corazzini',8,1886,1907,0,'Poesia della fragilita e del lamento, malinconia, temi della morte e della malattia.','Poeta romano, tra i maggiori crepuscolari. Mori giovanissimo di tubercolosi a soli 21 anni.','https://www.treccani.it/enciclopedia/sergio-corazzini/'),
('Guido Gozzano',8,1883,1916,0,'Ironia, oggetti dimessi e quotidiani, nostalgia borghese, stile elegante e disincantato.','Poeta torinese, massimo esponente del Crepuscolarismo.','https://www.treccani.it/enciclopedia/guido-gozzano/'),
('Italo Svevo',9,1861,1928,0,'Inettitudine del protagonista, psicoanalisi, introspezione, narratore inaffidabile.','Scrittore triestino. Fu riscoperto da James Joyce.','https://www.treccani.it/enciclopedia/italo-svevo/'),
('Luigi Pirandello',10,1867,1936,0,'Relativismo, tema delle maschere sociali, crisi dell identita, umorismo come distacco.','Scrittore e drammaturgo siciliano, Premio Nobel per la Letteratura nel 1934.','https://www.treccani.it/enciclopedia/luigi-pirandello/'),
('Giuseppe Ungaretti',11,1888,1970,0,'Poesia essenziale e frammentata, esperienza della guerra, parola come luce nel buio.','Poeta nato ad Alessandria d Egitto. Visse la Prima Guerra Mondiale in prima persona.','https://www.treccani.it/enciclopedia/giuseppe-ungaretti/'),
('Eugenio Montale',11,1896,1981,0,'Male di vivere, correlativo oggettivo, simboli aridi, paesaggio ligure come metafora esistenziale.','Poeta genovese, Premio Nobel per la Letteratura nel 1975.','https://www.treccani.it/enciclopedia/eugenio-montale/'),
('Umberto Saba',12,1883,1957,0,'Semplicita, autobiografismo, voce limpida e diretta, distanza dalle avanguardie.','Poeta triestino. Il suo Canzoniere e una delle opere piu importanti del Novecento italiano.','https://www.treccani.it/enciclopedia/umberto-saba/'),
('Cesare Pavese',13,1908,1950,0,'Solitudine esistenziale, mito delle Langhe, dialogo tra intellettuale e realta popolare.','Scrittore piemontese, figura chiave dell editoria Einaudi. Si tolse la vita nel 1950.','https://www.treccani.it/enciclopedia/cesare-pavese/'),
('Primo Levi',14,1919,1987,0,'Memoria della Shoah, chiarezza espressiva, stile scientifico-letterario, imperativo morale della testimonianza.','Scrittore torinese e chimico, sopravvissuto al campo di concentramento di Auschwitz.','https://www.treccani.it/enciclopedia/primo-levi/'),
('Beppe Fenoglio',15,1922,1963,0,'Stile asciutto e incisivo, narrazione della Resistenza partigiana, influenza della letteratura anglosassone.','Scrittore nato ad Alba (Cuneo), partigiano durante la Seconda Guerra Mondiale.','https://www.treccani.it/enciclopedia/beppe-fenoglio/'),
('Italo Calvino',16,1923,1985,0,'Narrativa fiabesca, combinatoria, leggerezza, tensione tra realta e fantasia.','Scrittore cresciuto a Sanremo. Dal Neorealismo alla narrativa fantastica e combinatoria. Aderi al Partito Comunista Italiano.','https://www.treccani.it/enciclopedia/italo-calvino/');

INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Madame Bovary',1857 FROM poeti WHERE nome='Gustave Flaubert';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Germinal',1885 FROM poeti WHERE nome='Emile Zola';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'L Assommoir',1877 FROM poeti WHERE nome='Emile Zola';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'I Malavoglia',1881 FROM poeti WHERE nome='Giovanni Verga';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Mastro-don Gesualdo',1889 FROM poeti WHERE nome='Giovanni Verga';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Vita dei campi',1880 FROM poeti WHERE nome='Giovanni Verga';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Myricae',1891 FROM poeti WHERE nome='Giovanni Pascoli';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Canti di Castelvecchio',1903 FROM poeti WHERE nome='Giovanni Pascoli';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Poemetti',1897 FROM poeti WHERE nome='Giovanni Pascoli';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Poemi conviviali',1904 FROM poeti WHERE nome='Giovanni Pascoli';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il piacere',1889 FROM poeti WHERE nome='Gabriele D Annunzio';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Laudi',1903 FROM poeti WHERE nome='Gabriele D Annunzio';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il fuoco',1900 FROM poeti WHERE nome='Gabriele D Annunzio';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Alcyone',1903 FROM poeti WHERE nome='Gabriele D Annunzio';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Manifesto del Futurismo',1909 FROM poeti WHERE nome='Futurismo (Marinetti)';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Zang Tumb Tumb',1914 FROM poeti WHERE nome='Futurismo (Marinetti)';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Desolazione del povero poeta sentimentale',1906 FROM poeti WHERE nome='Sergio Corazzini';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Piccolo libro inutile',1906 FROM poeti WHERE nome='Sergio Corazzini';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'I colloqui',1911 FROM poeti WHERE nome='Guido Gozzano';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'La via del rifugio',1907 FROM poeti WHERE nome='Guido Gozzano';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'La coscienza di Zeno',1923 FROM poeti WHERE nome='Italo Svevo';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Una vita',1892 FROM poeti WHERE nome='Italo Svevo';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Senilita',1898 FROM poeti WHERE nome='Italo Svevo';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il fu Mattia Pascal',1904 FROM poeti WHERE nome='Luigi Pirandello';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Uno, nessuno e centomila',1926 FROM poeti WHERE nome='Luigi Pirandello';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Sei personaggi in cerca d autore',1921 FROM poeti WHERE nome='Luigi Pirandello';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Novelle per un anno',1922 FROM poeti WHERE nome='Luigi Pirandello';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'L Allegria',1919 FROM poeti WHERE nome='Giuseppe Ungaretti';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Sentimento del tempo',1933 FROM poeti WHERE nome='Giuseppe Ungaretti';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il dolore',1947 FROM poeti WHERE nome='Giuseppe Ungaretti';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Ossi di seppia',1925 FROM poeti WHERE nome='Eugenio Montale';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Le occasioni',1939 FROM poeti WHERE nome='Eugenio Montale';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'La bufera e altro',1956 FROM poeti WHERE nome='Eugenio Montale';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Satura',1971 FROM poeti WHERE nome='Eugenio Montale';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il Canzoniere',1921 FROM poeti WHERE nome='Umberto Saba';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'La luna e i falo',1950 FROM poeti WHERE nome='Cesare Pavese';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Paesi tuoi',1941 FROM poeti WHERE nome='Cesare Pavese';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'La casa in collina',1949 FROM poeti WHERE nome='Cesare Pavese';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Lavorare stanca',1936 FROM poeti WHERE nome='Cesare Pavese';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Se questo e un uomo',1947 FROM poeti WHERE nome='Primo Levi';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'La tregua',1963 FROM poeti WHERE nome='Primo Levi';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il sistema periodico',1975 FROM poeti WHERE nome='Primo Levi';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'I sommersi e i salvati',1986 FROM poeti WHERE nome='Primo Levi';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il partigiano Johnny',1968 FROM poeti WHERE nome='Beppe Fenoglio';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Una questione privata',1963 FROM poeti WHERE nome='Beppe Fenoglio';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'La malora',1954 FROM poeti WHERE nome='Beppe Fenoglio';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il sentiero dei nidi di ragno',1947 FROM poeti WHERE nome='Italo Calvino';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Le cosmicomiche',1965 FROM poeti WHERE nome='Italo Calvino';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Il barone rampante',1957 FROM poeti WHERE nome='Italo Calvino';
INSERT INTO opere (poeta_id,titolo,anno) SELECT id,'Se una notte d inverno un viaggiatore',1979 FROM poeti WHERE nome='Italo Calvino';

INSERT INTO opposizioni (corrente_a,caratteristiche_a,corrente_b,caratteristiche_b,ordine) VALUES
('Positivismo','Fiducia nella scienza, progresso, metodo sperimentale','Scapigliatura','Antiborghese, cupa, ribelle, sperimentale',1),
('Naturalismo (Zola)','Determinismo scientifico, osservazione oggettiva','Verismo (Verga)','Impersonalita, mondo popolare siciliano',2),
('Decadentismo','Simbolismo, crisi dei valori, irrazionale','Pascoli (Fanciullino)','Simboli, dolore, natura, fragilita',3),
('D Annunzio','Estetismo, superuomo, sensualita','Crepuscolarismo','Toni dimessi, quotidiano modesto, poesia fragile',4),
('Futurismo (Marinetti)','Velocita, tecnologia, rottura col passato','Crepuscolari (Corazzini, Gozzano)','Ironia, oggetti dimessi, malinconia',5),
('Svevo (Modernismo)','Inettitudine, psicoanalisi, introspezione','Pirandello','Relativismo, crisi dell identita, maschere',6),
('Ermetismo (Ungaretti)','Poesia essenziale, frammenti, guerra','Montale','Male di vivere, simboli aridi',7),
('Saba (Poesia onesta)','Semplicita, autobiografia','Neorealismo (Pavese, Fenoglio)','Racconto del reale, impegno civile',8),
('Testimonianza (Primo Levi)','Memoria storica, Shoah, stile asciutto','Calvino (Postmoderno)','Fiabesco, combinatorio, leggerezza',9);
