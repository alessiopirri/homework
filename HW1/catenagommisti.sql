CREATE DATABASE catenagommisti;
USE catenagommisti;

CREATE TABLE CLIENTE(
	Codice INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	CF CHAR(16) UNIQUE,
	Nome VARCHAR(255),
	Cognome VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
	TotaleSpeso FLOAT DEFAULT 0
)Engine = 'InnoDB';

CREATE TABLE SEDE(
	Codice SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Citta VARCHAR(255),
    Indirizzo VARCHAR(255),
    UNIQUE(Citta, Indirizzo)
)Engine = 'InnoDB';

CREATE TABLE PRODOTTO(
	ID SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    Prezzo FLOAT,
    Descrizione VARCHAR(255) DEFAULT NULL,
    Img VARCHAR(255) DEFAULT NULL,
    QuantitaEcommerce INT DEFAULT 0
)Engine = 'InnoDB';

CREATE TABLE SERVIZIO(
	Codice SMALLINT UNSIGNED PRIMARY KEY,
    Descrizione VARCHAR(255),
    INDEX idx_codice_servizio (Codice),
    FOREIGN KEY (Codice) REFERENCES PRODOTTO(ID)
)Engine = 'InnoDB';

CREATE TABLE CERCHIO(
	Codice SMALLINT UNSIGNED PRIMARY KEY,
    Marca VARCHAR(255),
    Modello VARCHAR(255),
    Diametro INTEGER,
    INDEX idx_codice_cerchio (Codice),
    FOREIGN KEY (Codice) REFERENCES PRODOTTO(ID)
)Engine = 'InnoDB';

CREATE TABLE INDICIVELOCITA (
	IndiceVelocita VARCHAR(2) PRIMARY KEY,
    VelocitaNumerica SMALLINT UNSIGNED
) Engine="InnoDB";

CREATE TABLE PNEUMATICO(
	Codice SMALLINT UNSIGNED PRIMARY KEY,
    Marca VARCHAR(255),
    Modello VARCHAR(255),
    Misura VARCHAR(255),
    Larghezza SMALLINT UNSIGNED NOT NULL,
    Altezza SMALLINT UNSIGNED NOT NULL,
    Diametro TINYINT UNSIGNED NOT NULL,
    IndiceCarico TINYINT UNSIGNED DEFAULT NULL,
    Velocita VARCHAR(2),
    INDEX idx_codice_pneumatico (Codice),
    INDEX idx_indice_carico (Velocita),
    FOREIGN KEY (Codice) REFERENCES PRODOTTO(ID),
    FOREIGN KEY (Velocita) REFERENCES INDICIVELOCITA(IndiceVelocita)
)Engine = 'InnoDB';

CREATE TABLE OPERAZIONE(
    Codice INTEGER AUTO_INCREMENT PRIMARY KEY,
	CodiceCliente INTEGER UNSIGNED,
    CodiceSede SMALLINT UNSIGNED,
    CodiceProdotto SMALLINT UNSIGNED,
    Data DATE,
    Quantita SMALLINT UNSIGNED,
    INDEX idx_cc_operazione (CodiceCliente),
    INDEX idx_cs_operazione (CodiceSede),
    INDEX idx_cp_operazione (CodiceProdotto),
	FOREIGN KEY (CodiceCliente) REFERENCES CLIENTE(Codice),
    FOREIGN KEY (CodiceSede) REFERENCES SEDE(Codice),
    FOREIGN KEY (CodiceProdotto) REFERENCES PRODOTTO(ID)
)Engine = 'InnoDB';

CREATE TABLE FORNITORE(
	Piva BIGINT UNSIGNED PRIMARY KEY,
    Nome VARCHAR(255),
    Indirizzo VARCHAR(255),
    Recapito VARCHAR(255)
)Engine = 'InnoDB';

CREATE TABLE FORNITURA(
	CodiceProdotto SMALLINT UNSIGNED,
    CodiceFornitore BIGINT UNSIGNED,
    CodiceSede SMALLINT UNSIGNED,
    Data DATE,
    Quantita SMALLINT UNSIGNED,
    PRIMARY KEY(CodiceProdotto, CodiceFornitore, CodiceSede, Data),
    INDEX idx_cp_fornitura (CodiceProdotto),
    INDEX idx_cf_fornitura (CodiceFornitore),
    INDEX idx_cs_fornitura (CodiceSede),
    FOREIGN KEY (CodiceProdotto) REFERENCES PRODOTTO(ID),
    FOREIGN KEY (CodiceFornitore) REFERENCES FORNITORE(Piva),
    FOREIGN KEY (CodiceSede) REFERENCES SEDE(Codice)
)Engine = 'InnoDB';

CREATE TABLE CASAPRODUTTRICE(
	Piva BIGINT UNSIGNED PRIMARY KEY,
    Sede VARCHAR(255),
    Nome VARCHAR(255),
    Fatturato FLOAT
)Engine = 'InnoDB';

CREATE TABLE CASEFORNITE(
	CodiceFornitore BIGINT UNSIGNED,
    CodiceCasa BIGINT UNSIGNED,
    PRIMARY KEY (CodiceFornitore, CodiceCasa),
    INDEX idx_cf_casefornite (CodiceFornitore),
    INDEX idx_cs_casefornite (CodiceCasa),
    FOREIGN KEY (CodiceFornitore) REFERENCES FORNITORE(Piva),
    FOREIGN KEY (CodiceCasa) REFERENCES CASAPRODUTTRICE(Piva)
)Engine = 'InnoDB';

CREATE TABLE IMPIEGATO(
	Codice SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    CF CHAR(16) UNIQUE,
    Nome VARCHAR(255),
    Cognome VARCHAR(255),
    DataNascita DATE,
    Password VARCHAR(255) DEFAULT MD5("password")
)Engine = 'InnoDB';

CREATE TABLE IMPIEGO(
	CodiceImpiegato SMALLINT UNSIGNED,
	CodiceSede SMALLINT UNSIGNED,
    DataInizio DATE,
    Tipo VARCHAR(255),
    DataFine DATE,
    PRIMARY KEY(CodiceImpiegato, CodiceSede, DataInizio),
    INDEX idx_ci_impiego (CodiceImpiegato),
    INDEX idx_cs_impiego (CodiceSede),
    FOREIGN KEY (CodiceImpiegato) REFERENCES IMPIEGATO(Codice),
    FOREIGN KEY (CodiceSede) REFERENCES SEDE(Codice)
)Engine = 'InnoDB';

CREATE TABLE DIREZIONE(
	Direttore SMALLINT UNSIGNED PRIMARY KEY,
    CodiceSede SMALLINT UNSIGNED, 
    INDEX idx_cd_direzione (Direttore),
    INDEX idx_cs_direzione (CodiceSede),
    FOREIGN KEY (Direttore) REFERENCES IMPIEGATO(Codice),
    FOREIGN KEY (CodiceSede) REFERENCES SEDE(Codice)
)Engine = 'InnoDB';
    
CREATE TABLE CARRELLO(
	Codice INT AUTO_INCREMENT PRIMARY KEY,
    CodiceCliente INT UNSIGNED,
    CodiceProdotto SMALLINT UNSIGNED,
    Quantita INT UNSIGNED,
    UNIQUE (CodiceCliente, CodiceProdotto),
    INDEX idx_carrello_codice_cliente (CodiceCliente),
    INDEX idx_carrello_codice_prodotto (CodiceProdotto),
    FOREIGN KEY (CodiceCliente) REFERENCES CLIENTE(Codice),
    FOREIGN KEY (CodiceProdotto) REFERENCES PRODOTTO(ID)
);

/* OPERAZIONE 1
VISUALIZZARE IL NUMERO DI CERCHI CON DIAMETRO MAGGIORE DI 16’’ PER OGNI MARCA. VISUALIZZARE TALE NUMERO SOLO SE SUPERIORE A 2
*/

DELIMITER //
CREATE PROCEDURE OP1(IN num INTEGER)
BEGIN
DROP TEMPORARY TABLE IF EXISTS TEMP;
CREATE TEMPORARY TABLE TEMP(
	Marca VARCHAR(255),
    Numero INTEGER
);
INSERT INTO TEMP
SELECT Marca, count(*) AS Numero
FROM CERCHIO
WHERE Diametro>16
GROUP BY Marca
HAVING Numero>num;
END //
DELIMITER ;

/*
CALL OP1(2);
SELECT * FROM TEMP;
*/

/* OPERAZIONE 2
VISUALIZZARE LE SEDI NELLE CITTÀ CHE COMINCIANO CON ‘CAT’ IN CUI LAVORANO O HANNO LAVORATO DELLE PERSONE PER CUI ESISTE
 ALMENO UN ALTRO DIPENDENTE NATO NELLO STESSO GIORNO DELL’ANNO ALL’INTERNO DELLA STESSA SEDE
*/

CREATE VIEW SedeNatiStessoGiorno as
SELECT CodiceSede, Citta, Indirizzo, count(*)
FROM IMPIEGO S1 JOIN SEDE S2 ON S1.CodiceSede = S2.Codice
WHERE CodiceImpiegato IN (SELECT I1.Codice
						  FROM IMPIEGATO I1
						  WHERE EXISTS (SELECT * 
										FROM IMPIEGATO I2
										WHERE MONTH(I1.DataNascita)=MONTH(I2.DataNascita)
										AND DAY(I1.DataNascita)=DAY(I2.DataNascita)
										AND I1.CF<>I2.CF
										)
						)
GROUP BY CodiceSede, Citta;     

DELIMITER //					
CREATE PROCEDURE OP2(IN Stringa VARCHAR(255))
BEGIN
DROP TEMPORARY TABLE IF EXISTS TEMP;
CREATE TEMPORARY TABLE TEMP(
	Codice SMALLINT UNSIGNED,
    Citta VARCHAR(255),
    Indirizzo VARCHAR(255)
);
INSERT INTO TEMP
SELECT CodiceSede, Citta, Indirizzo
FROM SedeNatiStessoGiorno
WHERE Citta LIKE CONCAT(Stringa, '%');
END //
DELIMITER ;

/*
CALL OP2('Cat');
SELECT * FROM TEMP;
*/ 

/* OPERAZIONE 3 
INSERIRE UN NUOVO IMPIEGATO ED ASSEGNARLO ALLA SEDE DI CATANIA (VIA ETNEA, 254) SE L’ANNO DI NASCITA È MULTIPLO DI 2, A QUELLA DI PALERMO (VIALE DELLA REGIONE SICILIANA, 48)
SE MULTIPLO DI 3, A QUELLA DI MESSINA (VIA ACIREALE, 15) SE MULTIPLO DI ENTRAMBI E A QUELLA DI AGRIGENTO (CORSO SICILIA, 102) SE NON È MULTIPLO DI NESSUNO DEI DUE
*/

DELIMITER //
CREATE PROCEDURE OP3 (IN CodiceFiscale CHAR(16), IN Nome VARCHAR(255), IN Cognome VARCHAR(255), IN DataNascita DATE)
BEGIN
INSERT INTO IMPIEGATO (CF, Nome, Cognome, DataNascita) VALUES
	(CodiceFiscale, Nome, Cognome, DataNascita);
INSERT INTO IMPIEGO VALUES
	((SELECT Codice FROM IMPIEGATO WHERE CF=CodiceFiscale),
	CASE 
		WHEN YEAR(DataNascita)%2=0 AND YEAR(DataNascita)%3=0 THEN (SELECT Codice FROM SEDE WHERE Citta='Messina' AND Indirizzo='Via Acireale, 15')
        WHEN YEAR(DataNascita)%2=0 THEN (SELECT Codice FROM SEDE WHERE Citta='Catania' AND Indirizzo='Via Etnea, 254')
        WHEN YEAR(DataNascita)%3=0 THEN (SELECT Codice FROM SEDE WHERE Citta='Palermo' AND Indirizzo='Viale della regione siciliana, 48')
        ELSE (SELECT Codice FROM SEDE WHERE Citta='Agrigento' AND Indirizzo='Corso Sicilia, 102')
	END, 
    CURRENT_DATE(), 
    "Corrente",
    NULL); 
END //
DELIMITER ;

/*
CALL OP3("ASDQWE98D28A026F", "Alfonso", "Qwerty", "1998-04-28");
CALL OP3("DFGBVC54S23A028N", "DFG", "BVC", "1954-11-23");
select * from impiego
*/
      
/* OPERAZIONE 4 
LEGGERE TUTTI I DATI DI CLIENTI CHE NEL 2020 HANNO ACQUISTATO SIA UNO PNEUMATICO CHE UN CERCHIO   */
DELIMITER //
CREATE PROCEDURE OP4 ()
BEGIN
DROP TEMPORARY TABLE IF EXISTS TEMP;
CREATE TEMPORARY TABLE TEMP (
	Codice INTEGER UNSIGNED,
	CF CHAR(16),
	Nome VARCHAR(255),
	Cognome VARCHAR(255),
    Email VARCHAR(255),
	TotaleSpeso FLOAT
);
INSERT INTO TEMP
SELECT Codice, CF, Nome, Cognome, Email, TotaleSpeso 
FROM CLIENTE
WHERE Codice IN (SELECT CodiceCliente
				 FROM OPERAZIONE
                 WHERE CodiceProdotto IN (SELECT Codice FROM CERCHIO)
                 AND YEAR(Data)=2020)
AND Codice IN (SELECT CodiceCliente
			   FROM OPERAZIONE
			   WHERE CodiceProdotto IN (SELECT Codice FROM PNEUMATICO)
               AND YEAR(Data)=2020);			
END //
DELIMITER ;

/*
CALL OP4;
SELECT * FROM TEMP;
*/   

/* Procedura inserimento ordine */

DELIMITER //
CREATE PROCEDURE inserisciOrdine (IN CodiceClienteIN INT)
BEGIN
DECLARE exit handler for sqlexception
    BEGIN
		ROLLBACK;
        RESIGNAL;
	END;
    START TRANSACTION;
    IF EXISTS (SELECT CodiceCliente FROM CARRELLO WHERE CodiceCliente = CodiceClienteIN) THEN
    BEGIN
		INSERT INTO operazione (CodiceCliente, CodiceProdotto, Data, Quantita, CodiceSede)
			SELECT CodiceCliente, CodiceProdotto, CURRENT_DATE(), Quantita, (SELECT Codice FROM sede WHERE Citta = "e-commerce")
            FROM carrello
            WHERE CodiceCliente = CodiceClienteIN;
		DELETE FROM carrello WHERE CodiceCliente = CodiceClienteIN;
        COMMIT;
	END;
    ELSE 
    BEGIN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Il carrello è vuoto";
	END;
    END IF;			
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER AllineaTotaleSpeso 
AFTER INSERT ON OPERAZIONE
FOR EACH ROW
BEGIN
IF EXISTS (SELECT * FROM CLIENTE C WHERE C.Codice = NEW.CodiceCliente) THEN
	UPDATE CLIENTE SET TotaleSpeso = TotaleSpeso + (NEW.Quantita*(SELECT Prezzo 
																  FROM PRODOTTO 
																  WHERE ID=NEW.CodiceProdotto)
													)
	WHERE Codice = NEW.CodiceCliente;
END IF;
END //
DELIMITER ;

/* BUSINESS RULE */
 
DELIMITER //
CREATE TRIGGER BusinessRule
BEFORE INSERT ON FORNITURA
FOR EACH ROW
BEGIN
IF EXISTS(SELECT *
			  FROM CERCHIO C JOIN PRODOTTO P ON C.Codice = P.ID WHERE P.ID = NEW.CodiceProdotto
              AND C.Marca NOT IN (SELECT CP.Nome
								  FROM CASEFORNITE CF JOIN CASAPRODUTTRICE CP ON CP.Piva = CF.CodiceCasa
                                  WHERE CF.CodiceFornitore = NEW.CodiceFornitore
								 ) 
		 )
THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Questo prodotto non può essere fornito dal produttore selezionato";
ELSEIF EXISTS (SELECT *
			  FROM PNEUMATICO P1 JOIN PRODOTTO P ON P1.Codice = P.ID WHERE P.ID = NEW.CodiceProdotto
              AND P1.Marca NOT IN (SELECT CP.Nome
								  FROM CASEFORNITE CF JOIN CASAPRODUTTRICE CP ON CP.Piva = CF.CodiceCasa
                                  WHERE CF.CodiceFornitore = NEW.CodiceFornitore
								 ) 
		 )
THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Questo prodotto non può essere fornito dal produttore selezionato";
END IF;
END //
DELIMITER ;

/* TRIGGER ALLINEAMENTO DISPONIBILITA' ECOMMERCE */

DELIMITER //
CREATE TRIGGER TriggerDispDeleteFornitura
AFTER DELETE ON FORNITURA
FOR EACH ROW
BEGIN
IF old.CodiceSede IN (SELECT Codice FROM sede WHERE Citta="e-commerce")
THEN
	IF EXISTS (SELECT ID FROM prodotto	
               where ID = old.CodiceProdotto) 
    THEN
		update prodotto set QuantitaEcommerce =(SELECT (SELECT COALESCE ((SELECT sum(Quantita)  
                                                                FROM fornitura F JOIN sede S on S.Codice = F.CodiceSede 
                                                                WHERE CodiceProdotto = old.CodiceProdotto
                                                                AND Citta = "e-commerce"
                                                                GROUP BY CodiceSede, CodiceProdotto),0)) -
                                        (SELECT COALESCE((SELECT sum(Quantita)  
                                        FROM operazione O JOIN sede S on S.Codice = O.CodiceSede 
                                        WHERE CodiceProdotto = old.CodiceProdotto
                                        AND Citta = "e-commerce"
                                        GROUP BY CodiceSede, CodiceProdotto), 0 ))
                                    )
        where id=old.CodiceProdotto;
	end if;
end if;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TriggerDispInsertFornitura
AFTER INSERT ON FORNITURA
FOR EACH ROW
BEGIN
IF NEW.CodiceSede IN (SELECT Codice FROM sede WHERE Citta="e-commerce")
THEN
	IF EXISTS (SELECT ID FROM prodotto	
               where ID = NEW.CodiceProdotto) 
    THEN
		update prodotto set QuantitaEcommerce =(SELECT (SELECT COALESCE ((SELECT sum(Quantita)  
                                                                FROM fornitura F JOIN sede S on S.Codice = F.CodiceSede 
                                                                WHERE CodiceProdotto = NEW.CodiceProdotto
                                                                AND Citta = "e-commerce"
                                                                GROUP BY CodiceSede, CodiceProdotto),0)) -
                                        (SELECT COALESCE((SELECT sum(Quantita)  
                                        FROM operazione O JOIN sede S on S.Codice = O.CodiceSede 
                                        WHERE CodiceProdotto = NEW.CodiceProdotto
                                        AND Citta = "e-commerce"
                                        GROUP BY CodiceSede, CodiceProdotto), 0 ))
                                    )
        where id=NEW.CodiceProdotto;
	end if;
end if;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TriggerDispUpdateFornitura
AFTER UPDATE ON FORNITURA
FOR EACH ROW
BEGIN
IF NEW.CodiceSede IN (SELECT Codice FROM sede WHERE Citta="e-commerce")
THEN
	IF EXISTS (SELECT ID FROM prodotto	
               where ID = NEW.CodiceProdotto) 
    THEN
		update prodotto set QuantitaEcommerce =(SELECT (SELECT COALESCE ((SELECT sum(Quantita)  
                                                                FROM fornitura F JOIN sede S on S.Codice = F.CodiceSede 
                                                                WHERE CodiceProdotto = NEW.CodiceProdotto
                                                                AND Citta = "e-commerce"
                                                                GROUP BY CodiceSede, CodiceProdotto),0)) -
                                        (SELECT COALESCE((SELECT sum(Quantita)  
                                        FROM operazione O JOIN sede S on S.Codice = O.CodiceSede 
                                        WHERE CodiceProdotto = NEW.CodiceProdotto
                                        AND Citta = "e-commerce"
                                        GROUP BY CodiceSede, CodiceProdotto), 0 ))
                                    )
        where id=NEW.CodiceProdotto;
	end if;
end if;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TriggerDispDeleteOperazione
AFTER DELETE ON OPERAZIONE
FOR EACH ROW
BEGIN
IF old.CodiceSede IN (SELECT Codice FROM sede WHERE Citta="e-commerce")
THEN
	IF EXISTS (SELECT ID FROM prodotto	
               where ID = old.CodiceProdotto) 
    THEN
		update prodotto set QuantitaEcommerce =(SELECT (SELECT COALESCE ((SELECT sum(Quantita)  
                                                                FROM fornitura F JOIN sede S on S.Codice = F.CodiceSede 
                                                                WHERE CodiceProdotto = old.CodiceProdotto
                                                                AND Citta = "e-commerce"
                                                                GROUP BY CodiceSede, CodiceProdotto),0)) -
                                        (SELECT COALESCE((SELECT sum(Quantita)  
                                        FROM operazione O JOIN sede S on S.Codice = O.CodiceSede 
                                        WHERE CodiceProdotto = old.CodiceProdotto
                                        AND Citta = "e-commerce"
                                        GROUP BY CodiceSede, CodiceProdotto), 0 ))
                                    )
        where id=old.CodiceProdotto;
	end if;
end if;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TriggerDispInsertOperazione
AFTER INSERT ON OPERAZIONE
FOR EACH ROW
BEGIN
IF NEW.CodiceSede IN (SELECT Codice FROM sede WHERE Citta="e-commerce")
THEN
	IF EXISTS (SELECT ID FROM prodotto	
               where ID = NEW.CodiceProdotto) 
    THEN
		update prodotto set QuantitaEcommerce =(SELECT (SELECT COALESCE ((SELECT sum(Quantita)  
                                                                FROM fornitura F JOIN sede S on S.Codice = F.CodiceSede 
                                                                WHERE CodiceProdotto = NEW.CodiceProdotto
                                                                AND Citta = "e-commerce"
                                                                GROUP BY CodiceSede, CodiceProdotto),0)) -
                                        (SELECT COALESCE((SELECT sum(Quantita)  
                                        FROM operazione O JOIN sede S on S.Codice = O.CodiceSede 
                                        WHERE CodiceProdotto = NEW.CodiceProdotto
                                        AND Citta = "e-commerce"
                                        GROUP BY CodiceSede, CodiceProdotto), 0 ))
                                    )
        where id=NEW.CodiceProdotto;
	end if;
end if;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER TriggerDispUpdateOperazione
AFTER UPDATE ON OPERAZIONE
FOR EACH ROW
BEGIN
IF NEW.CodiceSede IN (SELECT Codice FROM sede WHERE Citta="e-commerce")
THEN
	IF EXISTS (SELECT ID FROM prodotto	
               where ID = NEW.CodiceProdotto) 
    THEN
		update prodotto set QuantitaEcommerce =(SELECT (SELECT COALESCE ((SELECT sum(Quantita)  
                                                                FROM fornitura F JOIN sede S on S.Codice = F.CodiceSede 
                                                                WHERE CodiceProdotto = NEW.CodiceProdotto
                                                                AND Citta = "e-commerce"
                                                                GROUP BY CodiceSede, CodiceProdotto),0)) -
                                        (SELECT COALESCE((SELECT sum(Quantita)  
                                        FROM operazione O JOIN sede S on S.Codice = O.CodiceSede 
                                        WHERE CodiceProdotto = NEW.CodiceProdotto
                                        AND Citta = "e-commerce"
                                        GROUP BY CodiceSede, CodiceProdotto), 0 ))
                                    )
        where id=NEW.CodiceProdotto;
	end if;
end if;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER inserisciOrdine
BEFORE INSERT ON OPERAZIONE
FOR EACH ROW
BEGIN

IF NEW.CodiceSede IN (SELECT Codice FROM sede WHERE Citta = "e-commerce")
THEN
	IF (NEW.Quantita > (SELECT X.QuantitaEcommerce
						FROM (SELECT QuantitaEcommerce, ID, @msg := CONCAT(new.quantita, " ", 
																		(SELECT CONCAT(pro.Marca, " ", pro.Modello) 
																		FROM Prodotto p 
																		JOIN ( (SELECT Marca, Modello, Codice FROM cerchio)
																				UNION
																				(SELECT Marca, Modello, Codice FROM pneumatico)
																			) pro ON p.ID = pro.Codice
																		WHERE p.ID = 6)								
                                                                    
                                                                    , " non disponibili. Disponibili ", QuantitaEcommerce)
								FROM prodotto 
                                WHERE ID = NEW.CodiceProdotto
                                ) AS X
							)
		)
    THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = @msg;
    END IF;
END IF;
END //
DELIMITER ;

INSERT INTO PRODOTTO /*('ID', 'Prezzo', 'Descrizione', 'Img')*/ VALUES 
	(1, 5, "", "", 0),
	(2, 5, "", "", 0),
	(3, 4, "", "", 0),
	(4, 399.9, "Avenger è il nuovo design multirazza della collezione cerchi in lega momo: una definita diamantatura a 5 punte si staglia sul medesimo disegno geometrico realizzato in finitura nero opaco, in un gioco di incroci e sovrapposizioni che conferisce al cerchio dinamicità e movimento. il profilo diamantato converge armonicamente al centro in corrispondenza del logo che risulta in questo modo particolarmente evidenziato. ", "img/avenger.png", 0),
	(5, 449.9, "Avenger è il nuovo design multirazza della collezione cerchi in lega momo: una definita diamantatura a 5 punte si staglia sul medesimo disegno geometrico realizzato in finitura nero opaco, in un gioco di incroci e sovrapposizioni che conferisce al cerchio dinamicità e movimento. il profilo diamantato converge armonicamente al centro in corrispondenza del logo che risulta in questo modo particolarmente evidenziato. ", "img/avenger.png", 0),
	(6, 499.9, "Il fascino di Stealth, la nuova cinque razze della gamma MOMO, risiede nell'ipnotica linearità delle razze, accentuata da un gioco di sottile diamantatura che verte al centro della ruota alla ricerca della più spiccata concavità, senza però rinunciare ad una completa ed ampia gamma di applicazioni omologate ABE e NAD. Stealth è proposta in 19″ in finitura antracite opaca diamantata e in 20″ in una nuovissima ed esclusiva finitura antracite magnesio diamantata.", "img/stealth.png", 0),
	(7, 549.9, "Il fascino di Stealth, la nuova cinque razze della gamma MOMO, risiede nell'ipnotica linearità delle razze, accentuata da un gioco di sottile diamantatura che verte al centro della ruota alla ricerca della più spiccata concavità, senza però rinunciare ad una completa ed ampia gamma di applicazioni omologate ABE e NAD. Stealth è proposta in 19″ in finitura antracite opaca diamantata e in 20″ in una nuovissima ed esclusiva finitura antracite magnesio diamantata.", "img/stealth.png", 0),
	(8, 299.9, "La prima ruota MOMO con 10 razze sdoppiate in oltre 30 anni, caratterizzata da un design innovativo e da linee scolpite. Estremamente sportiva e al tempo stesso elegante, REVENGE è disponibile in antracite e nero, entrambi con una finitura opaca in grado di valorizzarne ulteriormente il raffinato design. ", "img/revenge.png", 0),
	(9, 329.9, "La prima ruota MOMO con 10 razze sdoppiate in oltre 30 anni, caratterizzata da un design innovativo e da linee scolpite. Estremamente sportiva e al tempo stesso elegante, REVENGE è disponibile in antracite e nero, entrambi con una finitura opaca in grado di valorizzarne ulteriormente il raffinato design. ", "img/revenge.png", 0),
	(10, 349.9, "La prima ruota MOMO con 10 razze sdoppiate in oltre 30 anni, caratterizzata da un design innovativo e da linee scolpite. Estremamente sportiva e al tempo stesso elegante, REVENGE è disponibile in antracite e nero, entrambi con una finitura opaca in grado di valorizzarne ulteriormente il raffinato design. ", "img/revenge.png", 0),
	(11, 369.9, "La prima ruota MOMO con 10 razze sdoppiate in oltre 30 anni, caratterizzata da un design innovativo e da linee scolpite. Estremamente sportiva e al tempo stesso elegante, REVENGE è disponibile in antracite e nero, entrambi con una finitura opaca in grado di valorizzarne ulteriormente il raffinato design. ", "img/revenge.png", 0),
	(12, 399.9, "La prima ruota MOMO con 10 razze sdoppiate in oltre 30 anni, caratterizzata da un design innovativo e da linee scolpite. Estremamente sportiva e al tempo stesso elegante, REVENGE è disponibile in antracite e nero, entrambi con una finitura opaca in grado di valorizzarne ulteriormente il raffinato design. ", "img/revenge.png", 0),
	(13, 449.9, "La prima ruota MOMO con 10 razze sdoppiate in oltre 30 anni, caratterizzata da un design innovativo e da linee scolpite. Estremamente sportiva e al tempo stesso elegante, REVENGE è disponibile in antracite e nero, entrambi con una finitura opaca in grado di valorizzarne ulteriormente il raffinato design. ", "img/revenge.png", 0),
	(14, 749.9, "La prima ruota mesh design di Sparco Wheels. Pro Corsa è una ruota tecnica, dal look sportivo, perfetta per gli amanti della velocità e delle performance.", "img/procorsa.jpg", 0),
	(15, 149.9, "", "", 0),
	(16, 159.9, "", "", 0),
	(17, 169.9, "", "", 0),
	(18, 49, "", "img/energysaver+.png", 0),
	(19, 120, "", "img/energysaver+.png", 0),
    (20, 60, "", "img/turanza.png", 0),
    (21, 70, "", "img/potenza.png", 0),
    (22, 69.9, "", "img/primacy4.png", 0),
    (23, 69.9, "", "img/primacy4.png", 0),
    (24, 74.9, "", "img/primacy4.png", 0),
    (25, 72.9, "", "img/turanza.png", 0),
    (26, 134.9, "", "img/turanza.png", 0);

INSERT INTO SERVIZIO VALUES
	(1, 'Installazione pneumatico'),
    (2, 'Convergenza'),
    (3, 'Equilibratura');

INSERT INTO CERCHIO VALUES
	(4, 'Momo', 'Avenger', 17),
    (5, 'Momo', 'Avenger', 18),
    (6, 'Momo', 'Stealth', 19),
    (7, 'Momo', 'Stealth', 20),
    (8, 'Momo', 'Revenge', 15),
    (9, 'Momo', 'Revenge', 16),
    (10, 'Momo', 'Revenge', 17),
    (11, 'Momo', 'Revenge', 18),
    (12, 'Momo', 'Revenge', 19),
    (13, 'Momo', 'Revenge', 20),
	(14, 'Sparco', 'Procorsa', 20),
    (15, 'Opel', 'CorsaC', 14),
    (16, 'Opel', 'CorsaC', 15),
    (17, 'Opel', 'CorsaC', 16);

INSERT INTO SEDE VALUES
	(1, 'Catania', 'Via Etnea, 254'),
    (2, 'Palermo', 'Viale della regione siciliana, 48'),
    (3, 'Messina', 'Via Acireale, 15'),
    (4, 'Agrigento', 'Corso Sicilia, 102'),
    (5, 'Catanzaro', 'Corso Italia, 154'),
    (6, 'e-commerce', 'Via San Giuseppe la Rena, 50, 95121, Catania');

INSERT INTO IMPIEGATO(Codice, CF, Nome, Cognome, DataNascita) VALUES
	(1, 'PRRLSS99S02C351A', 'Alessio', 'Pirri', '1999-11-02'),
    (2, 'PRRMTT99S02C351E', 'Mattia', 'Pirri', '1999-11-02'),
    (3, 'GRDRSS29M53A028D', 'Gerarda', 'Rossi', '1929-08-13'),
    (4, 'MRARSS29M13C351F', 'Mario', 'Rossi', '1929-08-13'),
    (5, 'GFBHTG86D05C351H', 'Stefano', 'Bianchi', '2000-12-18'),
    (6, 'ASDQWE98D28A026F', 'Alfonso', 'Qwerty', '1998-04-28');
    
INSERT INTO IMPIEGO VALUES 
	(1, 1, '2020-12-10', 'Corrente', NULL),
    (2, 1, '2019-11-05', 'Corrente', NULL),
    (3, 2, '2018-06-14', 'Corrente', NULL),
    (4, 2, '2013-05-12', 'Passato', '2019-12-25'),
    (5, 5, '2020-02-14', 'Corrente', NULL),
    (6, 3, '2021-05-07', 'Corrente', NULL);
    
 
INSERT INTO CLIENTE  VALUES
	(1, 'PRRLSS99S02C351A', 'Alessio', 'Pirri', "alessio.pirri99@gmail.com", "$2y$10$xX4o.T./DiBzESM/TmikMOWZpJYgvqRyiNirXQzCN0VuDGgZZgtAG", 0);  /* Password: Ciaociao12! */

INSERT INTO INDICIVELOCITA VALUES 
    ("", 0),
    ("A1", 5),
    ("A2", 10),
    ("A3", 15),
    ("A4", 20),
    ("A5", 25),
    ("A6", 30),
    ("A7", 35),
    ("A8", 40),
    ("B", 50),
    ("C", 60),
    ("D", 65),
    ("E", 70),
    ("F", 80),
    ("G", 90),
    ("J", 100),
    ("K", 110),
    ("L", 120),
    ("M", 130),
    ("N", 140),
    ("P", 150),
    ("Q", 160),
    ("R", 170),
    ("S", 180),
    ("T", 190),
    ("U", 200),
    ("H", 210),
    ("V", 240),
    ("ZR", 241),
    ("W", 270),
    ("Y", 300);

INSERT INTO PNEUMATICO VALUES
	(18, 'Michelin', 'Energy Saver+', '165/70 R14 81T', 165, 70, 14, 81, 'T'),
    (19, 'Michelin', 'Energy Saver+', '205/60 R16 92W MO', 205, 60, 16, 92, 'W'),
    (20, 'Bridgestone', 'Turanza', '155/60 R15', 155, 60, 15, 0, ''),
    (21, 'Bridgestone', 'Potenza', '185/55 R15', 185, 55, 15, 0, ''),
    (22, 'Michelin', 'Primacy 4', '225/45R17 110W', 225, 45, 17, 110, 'W'),
    (23, 'Michelin', 'Primacy 4', '225/45R17 91H', 225, 45, 17, 91, 'H'),
    (24, 'Michelin', 'Primacy 4', '225/45R17 90H', 225, 45, 17, 90, 'H'),
    (25, 'Bridgestone', 'Turanza', '225/45R17', 225, 45, 17, 0, ''),
    (26, 'Bridgestone', 'Turanza', '235/35R19 91Y', 235, 35, 19, 91, 'Y');

INSERT INTO OPERAZIONE VALUES
	(1, 1, 1, 4, '2020-12-23', 4),
	(2, 1, 1, 18, '2020-12-22', 4);
    
INSERT INTO CASAPRODUTTRICE VALUES 
	(00570070011, 'Corso Romania, 546 10156 TORINO (TO) ITALIA', 'Michelin', 240),
    (04638560963, 'Via Winckelmann, 2 – 20146 Milano – Italia', 'Momo', 580), 
    (00907241004, 'Via Gallarate, 199 - 20151 Milano', 'Opel', 1230),
    (9712150961, 'Via Energy Park 14 20871 Vimercate, Lombardy Italia', 'Bridgestone', 24000);

INSERT INTO FORNITORE VALUES
	(12345678901, 'Pneumo2020', 'Corso Italia, 255, Catania', '3487564567');

INSERT INTO CASEFORNITE VALUES
	(12345678901, 00570070011),
    (12345678901, 04638560963),
    (12345678901, 9712150961);
    
INSERT INTO FORNITURA VALUES
	(11, 12345678901, 1, '2018-01-01', 10),
    (10, 12345678901, 1, '2017-12-03', 18),
    (4, 12345678901, 6, '2021-05-13', 4),
    (5, 12345678901, 6, '2021-05-13', 4),
    (6, 12345678901, 6, '2021-05-13', 16),
    (7, 12345678901, 6, '2021-05-13', 8),
    (8, 12345678901, 6, '2021-05-13', 4),
    (9, 12345678901, 6, '2021-05-13', 4),
    (10, 12345678901, 6, '2020-12-23', 30),
    (11, 12345678901, 6, '2021-05-13', 4),
    (12, 12345678901, 6, '2021-05-13', 4),
    (13, 12345678901, 6, '2021-05-13', 4),
    (18, 12345678901, 6, '2021-05-13', 4),
    (19, 12345678901, 6, '2021-05-13', 16),
    (20, 12345678901, 6, '2021-05-13', 36),
    (21, 12345678901, 6, '2021-05-13', 8),
    (22, 12345678901, 6, '2021-05-13', 12),
    (23, 12345678901, 6, '2021-05-13', 12),
    (24, 12345678901, 6, '2021-05-13', 12);