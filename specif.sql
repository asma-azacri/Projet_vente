DROP TABLE IF EXISTS LigneDevis;
DROP TABLE IF EXISTS Devis;
DROP TABLE IF EXISTS PC, Portable, Imprimante;
DROP TABLE IF EXISTS Produit;

CREATE TABLE Produit (
	modele			INT NOT NULL,
	fabricant		VARCHAR(10) NOT NULL,
	prix				NUMERIC(12,2) NOT NULL CHECK(prix >= 0),
	type				VARCHAR(10) NOT NULL,
	PRIMARY KEY (modele)
) ENGINE=InnoDB;

CREATE TABLE PC (
	modele			INT NOT NULL,
	processeur	CHAR(2) NOT NULL,
	RAM					INT NOT NULL CHECK(RAM >= 0),
	DD					INT NOT NULL CHECK(DD >= 0),
	lecteur			VARCHAR(10),
	PRIMARY KEY (modele),
	FOREIGN KEY (modele) REFERENCES Produit(modele)
) ENGINE=InnoDB;

CREATE TABLE Portable (
	modele			INT NOT NULL,
	processeur	CHAR(2) NOT NULL,
	RAM					INT NOT NULL CHECK(RAM >= 0),
	DD					INT NOT NULL CHECK(DD >= 0),
	ecran				INT NOT NULL CHECK(ecran >= 0),
	PRIMARY KEY (modele),
	FOREIGN KEY (modele) REFERENCES Produit(modele)
) ENGINE=InnoDB;

CREATE TABLE Imprimante (
	modele			INT NOT NULL,
	typeImp			VARCHAR(15) NOT NULL,
	couleur			CHAR(3) NOT NULL CHECK(couleur IN ('oui','non')),
	PRIMARY KEY (modele),
	FOREIGN KEY (modele) REFERENCES Produit(modele)
) ENGINE=InnoDB;

CREATE TABLE Devis (
	num						CHAR(10) NOT NULL,
	dateCreation	DATE NOT NULL,
	dateSign			DATE DEFAULT NULL,
	client				VARCHAR(20) NOT NULL CHECK(Client <> ''),
	status				VARCHAR(7) NOT NULL CHECK(status IN ('encours','signe','annule')),
	PRIMARY KEY (num),
	CHECK (status <> 'signe' OR (NOT (dateSign IS NULL)) )
) ENGINE=InnoDB;

CREATE TABLE LigneDevis (
	numDevis	CHAR(10) NOT NULL,
	modele		INT NOT NULL,
	quantite	INT NOT NULL CHECK(quantite >= 0),
	PRIMARY KEY (numDevis,modele),
	FOREIGN KEY (numDevis) REFERENCES Devis(num),
	FOREIGN KEY (modele) REFERENCES Produit(modele)
) ENGINE=InnoDB;



INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('A', 1001, 'pc', 400);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('A', 1002, 'pc', 500);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('A', 1003, 'pc', 600);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('B', 1004, 'pc', 650);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('B', 1005, 'pc', 700);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('B', 1006, 'pc', 350);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('C', 1007, 'pc', 450);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('C', 1008, 'pc', 500);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('D', 1009, 'pc', 700);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('D', 1010, 'pc', 450);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('E', 1011, 'pc', 300);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('E', 1012, 'pc', 550);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('A', 2001, 'portable', 600);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('A', 2002, 'portable', 700);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('A', 2003, 'portable', 750);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('C', 2004, 'portable', 700);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('C', 2005, 'portable', 650);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('C', 2006, 'portable', 700);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('D', 2007, 'portable', 650);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('D', 2008, 'portable', 850);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('E', 2009, 'portable', 800);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('E', 2010, 'portable', 550);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('F', 2011, 'portable', 900);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('F', 2012, 'portable', 700);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('B', 3001, 'imprimante', 250);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('B', 3002, 'imprimante', 150);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('B', 3003, 'imprimante', 100);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('C', 3004, 'imprimante', 90);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('E', 3005, 'imprimante', 350);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('F', 3006, 'imprimante', 120);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('F', 3007, 'imprimante', 230);
INSERT INTO Produit(fabricant,modele,type,prix) VALUES ('F', 3008, 'imprimante', 450);

INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1001, 'i3', 2,  400, '8xDVD');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1002, 'i3', 4,  450, '16xDVD');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1003, 'i5', 4,  500, '8xBR');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1004, 'i5', 8,  400, '16xDVD');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1005, 'i7', 8,  600, '6xBR');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1006, 'i7', 16, 800, '8xDVD');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1007, 'a4', 4,  500, '16xDVD');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1008, 'a4', 8,  800, '6xBR');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1009, 'a6', 8,  600, '7xBR');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1010, 'a8', 16, 800, '12xBR');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1011, 'a9', 8,  500, '8xBR');
INSERT INTO PC(modele,processeur,RAM,DD,lecteur) VALUES (1012, 'a9', 16, 900, '12xBR');

INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2001, 'a4', 4,  200, 14);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2002, 'a6', 4,  250, 13);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2003, 'a6', 6,  300, 14);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2004, 'a8', 4,  200, 15);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2005, 'a8', 6,  300, 14);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2006, 'i3', 16, 200, 11);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2007, 'i3', 4,  300 ,13);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2008, 'i5', 8,  200, 15);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2009, 'i5', 8,  400, 13);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2010, 'i7', 8,  400, 13);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2011, 'i7', 6,  500, 14);
INSERT INTO Portable(modele,processeur,RAM,DD,ecran) VALUES (2012, 'a9', 16, 900, 15);

INSERT INTO Imprimante(modele,typeImp,couleur) VALUES (3001, 'laser',         'oui');
INSERT INTO Imprimante(modele,typeImp,couleur) VALUES (3002, 'jet d''encre',  'oui');
INSERT INTO Imprimante(modele,typeImp,couleur) VALUES (3003, 'laser',         'non');
INSERT INTO Imprimante(modele,typeImp,couleur) VALUES (3004, 'laser',         'non');
INSERT INTO Imprimante(modele,typeImp,couleur) VALUES (3005, 'multifonction', 'non');
INSERT INTO Imprimante(modele,typeImp,couleur) VALUES (3006, 'jet d''encre',  'oui');
INSERT INTO Imprimante(modele,typeImp,couleur) VALUES (3007, 'laser',         'oui');
INSERT INTO Imprimante(modele,typeImp,couleur) VALUES (3008, 'multifonction', 'oui');

INSERT INTO Devis(num,dateCreation,dateSign,client,status) VALUES ('D201200001','2012-02-28','2012-03-5','a','signe');
INSERT INTO LigneDevis(numDevis,modele,quantite) VALUES ('D201200001',2007,5);
INSERT INTO LigneDevis(numDevis,modele,quantite) VALUES ('D201200001',3008,1);

INSERT INTO Devis(num,dateCreation,client,status) VALUES ('D201200002','2012-03-11','b','encours');
INSERT INTO LigneDevis(numDevis,modele,quantite) VALUES ('D201200002',1001,2);


