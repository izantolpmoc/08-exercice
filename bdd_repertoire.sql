-- => Création d'un repertoire :

-- 	-- 1 - Création bdd 'repertoire'
	
-- 	-- 2 - Création table 'annuaire'(id_annuaire, nom, prenom, telephone, ville, cp, adresse)
-- */

CREATE DATABASE repertoire;

USE repertoire;



CREATE TABLE annuaire (
    id_annuaire int(5) NOT NULL AUTO_INCREMENT,
    nom varchar(20) NOT NULL,
    prenom varchar(20) NOT NULL,
    telephone varchar(10) NOT NULL,
    ville varchar(20) NOT NULL,
    cp varchar(5) NOT NULL,
    adresse text NOT NULL,
    PRIMARY KEY (id_annuaire),
    UNIQUE KEY telephone(telephone)
)ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

INSERT INTO annuaire(id_annuaire, nom, prenom, telephone, ville, cp, adresse) VALUES
(1, 'BERNARD', 'Emilie', '0625873941', 'Drancy', '93210', '10, rue des Misères'),
(2, 'DUPONT', 'Victor', '0700218546', 'Versailles', '76000', '90, impasse des Hirondelles');
