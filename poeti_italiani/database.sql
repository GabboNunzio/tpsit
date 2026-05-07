-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 07, 2026 alle 21:56
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poeti_italiani`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `correnti`
--

CREATE TABLE `correnti` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `periodo` varchar(100) DEFAULT NULL,
  `descrizione` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `correnti`
--

INSERT INTO `correnti` (`id`, `nome`, `periodo`, `descrizione`) VALUES
(1, 'Positivismo', 'Tardo Ottocento', 'Fiducia nella scienza, nel progresso e nel metodo sperimentale.'),
(2, 'Scapigliatura', '1860-1870', 'Gruppo milanese antiborghese, cupo e sperimentale.'),
(3, 'Naturalismo', 'Seconda meta Ottocento', 'Impersonalita, determinismo scientifico, osservazione oggettiva.'),
(4, 'Verismo', 'Seconda meta Ottocento', 'Variante italiana del Naturalismo, focalizzata sul mondo popolare meridionale.'),
(5, 'Decadentismo', 'Fine Ottocento', 'Simbolismo, crisi dei valori positivisti, esaltazione dell irrazionale.'),
(6, 'Decadentismo / Estetismo', 'Fine Ottocento', 'Superuomo, culto della bellezza, sensualita.'),
(7, 'Avanguardie', 'Primo Novecento', 'Rottura radicale con la tradizione. Futurismo, Dadaismo, Espressionismo.'),
(8, 'Crepuscolarismo', 'Primo Novecento', 'Toni dimessi, quotidiano modesto, rifiuto del dannunzianesimo.'),
(9, 'Modernismo', 'Primo Novecento', 'Inettitudine, psicoanalisi, crisi dell identita.'),
(10, 'Modernismo / Teatro', 'Primo Novecento', 'Relativismo, maschere sociali, rivoluzione del teatro.'),
(11, 'Ermetismo', 'Anni 1920-1940', 'Poesia essenziale, simbolismo oscuro, interiorita.'),
(12, 'Poesia onesta', 'Primo Novecento', 'Semplicita, autobiografismo, distanza dalle avanguardie.'),
(13, 'Neorealismo', 'Anni 1940-1960', 'Rappresentazione del reale, impegno civile, dopoguerra.'),
(14, 'Testimonianza', 'Anni 1940-1960', 'Memoria storica, Shoah, imperativo morale della scrittura.'),
(15, 'Neorealismo / Testimonianza', 'Anni 1940-1960', 'Resistenza partigiana narrata con rigore e asciuttezza.'),
(16, 'Neorealismo -> Sperimentazione', 'Anni 1950-1980', 'Dal neorealismo alla narrativa combinatoria e fantastica.');

-- --------------------------------------------------------

--
-- Struttura della tabella `opere`
--

CREATE TABLE `opere` (
  `id` int(11) NOT NULL,
  `poeta_id` int(11) NOT NULL,
  `titolo` varchar(300) NOT NULL,
  `anno` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `opere`
--

INSERT INTO `opere` (`id`, `poeta_id`, `titolo`, `anno`) VALUES
(1, 3, 'Madame Bovary', 1856),
(2, 4, 'Germinal', 1885),
(3, 4, 'L Assommoir', 1876),
(4, 5, 'I Malavoglia', 1881),
(5, 5, 'Mastro-don Gesualdo', 1889),
(6, 5, 'Vita dei campi', 1880),
(7, 7, 'Myricae', 1891),
(8, 7, 'Canti di Castelvecchio', 1903),
(9, 7, 'Poemetti', 1897),
(10, 7, 'Poemi conviviali', 1904),
(11, 8, 'Il piacere', 1889),
(12, 8, 'Laudi', 1903),
(13, 8, 'Il fuoco', 1900),
(14, 8, 'Alcyone', 1903),
(15, 9, 'Manifesto del Futurismo', 1909),
(16, 9, 'Zang Tumb Tumb', 1914),
(17, 11, 'Desolazione del povero poeta sentimentale', 1906),
(18, 11, 'Piccolo libro inutile', 1906),
(19, 12, 'I colloqui', 1911),
(20, 12, 'La via del rifugio', 1907),
(21, 13, 'La coscienza di Zeno', 1923),
(22, 13, 'Una vita', 1892),
(23, 13, 'Senilita', 1898),
(24, 14, 'Il fu Mattia Pascal', 1904),
(25, 14, 'Uno, nessuno e centomila', 1926),
(26, 14, 'Sei personaggi in cerca d autore', 1921),
(27, 14, 'Novelle per un anno', 1922),
(28, 15, 'L Allegria', 1919),
(29, 15, 'Sentimento del tempo', 1933),
(30, 15, 'Il dolore', 1947),
(31, 16, 'Ossi di seppia', 1925),
(32, 16, 'Le occasioni', 1939),
(33, 16, 'La bufera e altro', 1956),
(34, 16, 'Satura', 1971),
(35, 17, 'Il Canzoniere', 1921),
(36, 18, 'La luna e i falo', 1950),
(37, 18, 'Paesi tuoi', 1941),
(38, 18, 'La casa in collina', 1949),
(39, 18, 'Lavorare stanca', 1936),
(40, 19, 'Se questo e un uomo', 1947),
(41, 19, 'La tregua', 1963),
(42, 19, 'Il sistema periodico', 1975),
(43, 19, 'I sommersi e i salvati', 1986),
(44, 20, 'Il partigiano Johnny', 1968),
(45, 20, 'Una questione privata', 1963),
(46, 20, 'La malora', 1954),
(47, 21, 'Il sentiero dei nidi di ragno', 1947),
(48, 21, 'Le cosmicomiche', 1965),
(49, 21, 'Il barone rampante', 1957),
(50, 21, 'Se una notte d inverno un viaggiatore', 1979);

-- --------------------------------------------------------

--
-- Struttura della tabella `opposizioni`
--

CREATE TABLE `opposizioni` (
  `id` int(11) NOT NULL,
  `corrente_a` varchar(200) NOT NULL,
  `caratteristiche_a` text NOT NULL,
  `corrente_b` varchar(200) NOT NULL,
  `caratteristiche_b` text NOT NULL,
  `ordine` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `opposizioni`
--

INSERT INTO `opposizioni` (`id`, `corrente_a`, `caratteristiche_a`, `corrente_b`, `caratteristiche_b`, `ordine`) VALUES
(1, 'Positivismo', 'Fiducia nella scienza, progresso, metodo sperimentale', 'Scapigliatura', 'Antiborghese, cupa, ribelle, sperimentale', 1),
(2, 'Naturalismo (Zola)', 'Determinismo scientifico, osservazione oggettiva', 'Verismo (Verga)', 'Impersonalita, mondo popolare siciliano', 2),
(3, 'Decadentismo', 'Simbolismo, crisi dei valori, irrazionale', 'Pascoli (Fanciullino)', 'Simboli, dolore, natura, fragilita', 3),
(4, 'D Annunzio', 'Estetismo, superuomo, sensualita', 'Crepuscolarismo', 'Toni dimessi, quotidiano modesto, poesia fragile', 4),
(5, 'Futurismo (Marinetti)', 'Velocita, tecnologia, rottura col passato', 'Crepuscolari (Corazzini, Gozzano)', 'Ironia, oggetti dimessi, malinconia', 5),
(6, 'Svevo (Modernismo)', 'Inettitudine, psicoanalisi, introspezione', 'Pirandello', 'Relativismo, crisi dell identita, maschere', 6),
(7, 'Ermetismo (Ungaretti)', 'Poesia essenziale, frammenti, guerra', 'Montale', 'Male di vivere, simboli aridi', 7),
(8, 'Saba (Poesia onesta)', 'Semplicita, autobiografia', 'Neorealismo (Pavese, Fenoglio)', 'Racconto del reale, impegno civile', 8),
(9, 'Testimonianza (Primo Levi)', 'Memoria storica, Shoah, stile asciutto', 'Calvino (Postmoderno)', 'Fiabesco, combinatorio, leggerezza', 9);

-- --------------------------------------------------------

--
-- Struttura della tabella `poeti`
--

CREATE TABLE `poeti` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `corrente_id` int(11) DEFAULT NULL,
  `nascita` int(11) DEFAULT NULL,
  `morte` int(11) DEFAULT NULL,
  `is_movimento` tinyint(1) NOT NULL DEFAULT 0,
  `caratteristiche` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `bio_link` varchar(500) DEFAULT NULL,
  `immagine_path` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `poeti`
--

INSERT INTO `poeti` (`id`, `nome`, `corrente_id`, `nascita`, `morte`, `is_movimento`, `caratteristiche`, `bio`, `bio_link`, `immagine_path`) VALUES
(1, 'Positivismo', 1, NULL, NULL, 1, 'Fiducia nella scienza, progresso, metodo sperimentale.', 'Movimento culturale europeo del tardo Ottocento.', NULL, NULL),
(2, 'Scapigliatura', 2, NULL, NULL, 1, 'Antiborghese, cupa, sperimentale. Reazione romantica e bohemienne alla societa borghese.', 'Gruppo di artisti e scrittori milanesi ribelli degli anni 1860-70.', NULL, NULL),
(3, 'Gustave Flaubert', 3, 1821, 1880, 0, 'Impersonalita, osservazione oggettiva della realta, stile preciso e antiromantico.', 'Scrittore francese, uno dei massimi esponenti del Naturalismo europeo.', 'https://www.treccani.it/enciclopedia/gustave-flaubert/', 'immagini_poeti/Gustave_Flaubert.jpg'),
(4, 'Emile Zola', 3, 1840, 1902, 0, 'Determinismo scientifico, romanzo come esperimento sociale. Teorico del Naturalismo francese.', 'Scrittore e giornalista francese, teorico e principale esponente del Naturalismo.', 'https://www.treccani.it/enciclopedia/emile-zola/', 'immagini_poeti/Emile_Zola.jpg'),
(5, 'Giovanni Verga', 4, 1840, 1922, 0, 'Impersonalita narrativa, rappresentazione del mondo popolare siciliano, tecnica della regressione.', 'Scrittore siciliano, massimo esponente del Verismo italiano.', 'https://www.treccani.it/enciclopedia/giovanni-verga/', 'immagini_poeti/Giovanni_Verga.jpg'),
(6, 'Decadentismo', 5, NULL, NULL, 1, 'Simbolismo, crisi dei valori positivisti, irrazionale, estetismo.', 'Movimento letterario e artistico europeo di fine Ottocento.', NULL, NULL),
(7, 'Giovanni Pascoli', 5, 1855, 1912, 0, 'Poetica del fanciullino, uso dei simboli, dolore per lutti familiari, linguaggio pre-grammaticale.', 'Poeta romagnolo la cui vita fu segnata dalla morte del padre.', 'https://www.treccani.it/enciclopedia/giovanni-pascoli/', 'immagini_poeti/Giovanni_Pascoli.jpg'),
(8, 'Gabriele D Annunzio', 6, 1863, 1938, 0, 'Culto del superuomo, sensualita, estetismo, vita come opera d arte.', 'Scrittore e poeta abruzzese, figura centrale del Decadentismo italiano.', 'https://www.treccani.it/enciclopedia/gabriele-d-annunzio/', 'immagini_poeti/Gabriele_DAnnunzio.jpg'),
(9, 'Filippo Tommaso Marinetti', 7, 1876, 1944, 0, 'Esaltazione della velocita, della tecnologia e della guerra. Rottura radicale col passato.', 'Filippo Tommaso Marinetti, fondatore del movimento futurista nel 1909.', 'https://www.treccani.it/enciclopedia/filippo-tommaso-marinetti/', 'immagini_poeti/Filippo_Tommaso_Marinetti.jpg'),
(10, 'Crepuscolarismo ', 8, NULL, NULL, 1, 'Toni dimessi, quotidiano modesto, poesia fragile, rifiuto del dannunzianesimo.', 'Movimento poetico italiano dei primi del Novecento. Anti-dannunziani per eccellenza.', NULL, ''),
(11, 'Sergio Corazzini', 8, 1886, 1907, 0, 'Poesia della fragilita e del lamento, malinconia, temi della morte e della malattia.', 'Poeta romano, tra i maggiori crepuscolari. Mori giovanissimo di tubercolosi a soli 21 anni.', 'https://www.treccani.it/enciclopedia/sergio-corazzini/', 'immagini_poeti/Sergio_Corazzini.jpg'),
(12, 'Guido Gozzano', 8, 1883, 1916, 0, 'Ironia, oggetti dimessi e quotidiani, nostalgia borghese, stile elegante e disincantato.', 'Poeta torinese, massimo esponente del Crepuscolarismo.', 'https://www.treccani.it/enciclopedia/guido-gozzano/', 'immagini_poeti/Guido_Gozzano.jpg'),
(13, 'Italo Svevo', 9, 1861, 1928, 0, 'Inettitudine del protagonista, psicoanalisi, introspezione, narratore inaffidabile.', 'Scrittore triestino. Fu riscoperto da James Joyce.', 'https://www.treccani.it/enciclopedia/italo-svevo/', 'immagini_poeti/italo_svevo.jpg'),
(14, 'Luigi Pirandello', 10, 1867, 1936, 0, 'Relativismo, tema delle maschere sociali, crisi dell identita, umorismo come distacco.', 'Scrittore e drammaturgo siciliano, Premio Nobel per la Letteratura nel 1934.', 'https://www.treccani.it/enciclopedia/luigi-pirandello/', 'immagini_poeti/Luigi_Pirandello.jpg'),
(15, 'Giuseppe Ungaretti', 11, 1888, 1970, 0, 'Poesia essenziale e frammentata, esperienza della guerra, parola come luce nel buio.', 'Poeta nato ad Alessandria d Egitto. Visse la Prima Guerra Mondiale in prima persona.', 'https://www.treccani.it/enciclopedia/giuseppe-ungaretti/', 'immagini_poeti/Giuseppe_Ungaretti.jpg'),
(16, 'Eugenio Montale', 11, 1896, 1981, 0, 'Male di vivere, correlativo oggettivo, simboli aridi, paesaggio ligure come metafora esistenziale.', 'Poeta genovese, Premio Nobel per la Letteratura nel 1975.', 'https://www.treccani.it/enciclopedia/eugenio-montale/', 'immagini_poeti/Eugenio_Montale.jpg'),
(17, 'Umberto Saba', 12, 1883, 1957, 0, 'Semplicita, autobiografismo, voce limpida e diretta, distanza dalle avanguardie.', 'Poeta triestino. Il suo Canzoniere e una delle opere piu importanti del Novecento italiano.', 'https://www.treccani.it/enciclopedia/umberto-saba/', 'immagini_poeti/Umberto_Saba.jpg'),
(18, 'Cesare Pavese', 13, 1908, 1950, 0, 'Solitudine esistenziale, mito delle Langhe, dialogo tra intellettuale e realta popolare.', 'Scrittore piemontese, figura chiave dell editoria Einaudi. Si tolse la vita nel 1950.', 'https://www.treccani.it/enciclopedia/cesare-pavese/', 'immagini_poeti/Cesare_Pavese.jpg'),
(19, 'Primo Levi', 14, 1919, 1987, 0, 'Memoria della Shoah, chiarezza espressiva, stile scientifico-letterario, imperativo morale della testimonianza.', 'Scrittore torinese e chimico, sopravvissuto al campo di concentramento di Auschwitz.', 'https://www.treccani.it/enciclopedia/primo-levi/', 'immagini_poeti/Primo_Levi.jpg'),
(20, 'Beppe Fenoglio', 15, 1922, 1963, 0, 'Stile asciutto e incisivo, narrazione della Resistenza partigiana, influenza della letteratura anglosassone.', 'Scrittore nato ad Alba (Cuneo), partigiano durante la Seconda Guerra Mondiale.', 'https://www.treccani.it/enciclopedia/beppe-fenoglio/', 'immagini_poeti/Beppe_Fenoglio.jpg'),
(21, 'Italo Calvino', 16, 1923, 1985, 0, 'Narrativa fiabesca, combinatoria, leggerezza, tensione tra realta e fantasia.', 'Scrittore cresciuto a Sanremo. Dal Neorealismo alla narrativa fantastica e combinatoria. Aderi al Partito Comunista Italiano.', 'https://www.treccani.it/enciclopedia/italo-calvino/', 'immagini_poeti/Italo_Calvino.jpg');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `correnti`
--
ALTER TABLE `correnti`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `opere`
--
ALTER TABLE `opere`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poeta_id` (`poeta_id`);

--
-- Indici per le tabelle `opposizioni`
--
ALTER TABLE `opposizioni`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `poeti`
--
ALTER TABLE `poeti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `corrente_id` (`corrente_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `correnti`
--
ALTER TABLE `correnti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT per la tabella `opere`
--
ALTER TABLE `opere`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT per la tabella `opposizioni`
--
ALTER TABLE `opposizioni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `poeti`
--
ALTER TABLE `poeti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `opere`
--
ALTER TABLE `opere`
  ADD CONSTRAINT `opere_ibfk_1` FOREIGN KEY (`poeta_id`) REFERENCES `poeti` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `poeti`
--
ALTER TABLE `poeti`
  ADD CONSTRAINT `poeti_ibfk_1` FOREIGN KEY (`corrente_id`) REFERENCES `correnti` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
