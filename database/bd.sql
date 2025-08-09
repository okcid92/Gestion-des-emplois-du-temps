-- Création de la table ETUDIANTS
CREATE TABLE ETUDIANTS (
    id_etudiant INT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    date_naissance DATE,
    email VARCHAR(255)
);

-- Création de la table ENSEIGNANTS
CREATE TABLE ENSEIGNANTS (
    id_enseignant INT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(255),
    grade VARCHAR(50)
);

-- Création de la table COURS
CREATE TABLE COURS (
    id_cours INT PRIMARY KEY,
    intitule VARCHAR(255),
    description TEXT,
    id_enseignant INT,
    CONSTRAINT fk_cours_enseignant FOREIGN KEY (id_enseignant)
        REFERENCES ENSEIGNANTS(id_enseignant)
);

-- Création de la table SEMESTRES
CREATE TABLE SEMESTRES (
    id_semestre INT PRIMARY KEY,
    libelle VARCHAR(100),
    annee_academique INT
);

-- Création de la table PROGRAMMES
CREATE TABLE PROGRAMMES (
    id_programme INT PRIMARY KEY,
    intitule VARCHAR(255),
    id_mention INT,
    CONSTRAINT fk_programmes_mentions FOREIGN KEY (id_mention)
        REFERENCES MENTIONS(id_mention)
);

-- Création de la table MENTIONS
CREATE TABLE MENTIONS (
    id_mention INT PRIMARY KEY,
    nom VARCHAR(255),
    id_domaine INT,
    CONSTRAINT fk_mentions_domaines FOREIGN KEY (id_domaine)
        REFERENCES DOMAINES(id_domaine)
);

-- Création de la table DOMAINES
CREATE TABLE DOMAINES (
    id_domaine INT PRIMARY KEY,
    nom VARCHAR(255)
);

-- Création de la table SCOLARITE
CREATE TABLE SCOLARITE (
    id_scolarite INT PRIMARY KEY,
    id_etudiant INT,
    id_annee_academique INT,
    statut VARCHAR(50),
    CONSTRAINT fk_scolarite_etudiant FOREIGN KEY (id_etudiant)
        REFERENCES ETUDIANTS(id_etudiant),
    CONSTRAINT fk_scolarite_annee FOREIGN KEY (id_annee_academique)
        REFERENCES ANNEES_ACADEMIQUES(id_annee_academique)
);

-- Création de la table ANNEES_ACADEMIQUES
CREATE TABLE ANNEES_ACADEMIQUES (
    id_annee_academique INT PRIMARY KEY,
    annee_debut INT,
    annee_fin INT
);

-- Création de la table MATERIELS
CREATE TABLE MATERIELS (
    id_materiel INT PRIMARY KEY,
    designation VARCHAR(255),
    quantite INT,
    etat VARCHAR(50)
);

-- Création de la table COMMANDES
CREATE TABLE COMMANDES (
    id_commande INT PRIMARY KEY,
    date_commande DATE,
    id_utilisateur INT,
    CONSTRAINT fk_commandes_utilisateur FOREIGN KEY (id_utilisateur)
        REFERENCES UTILISATEURS(id_utilisateur)
);

-- Création de la table LIGNE_COMMANDES
CREATE TABLE LIGNE_COMMANDES (
    id_ligne INT PRIMARY KEY,
    id_commande INT,
    id_materiel INT,
    quantite INT,
    CONSTRAINT fk_ligne_commandes_commande FOREIGN KEY (id_commande)
        REFERENCES COMMANDES(id_commande),
    CONSTRAINT fk_ligne_commandes_materiel FOREIGN KEY (id_materiel)
        REFERENCES MATERIELS(id_materiel)
);

-- Création de la table UTILISATEURS
CREATE TABLE UTILISATEURS (
    id_utilisateur INT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(255),
    role VARCHAR(50)
);

-- Création de la table EMPLOI_DU_TEMPS
CREATE TABLE EMPLOI_DU_TEMPS (
    id_emploi INT PRIMARY KEY,
    id_cours INT,
    id_semestre INT,
    jour VARCHAR(50),
    heure_debut TIME,
    heure_fin TIME,
    CONSTRAINT fk_emploi_cours FOREIGN KEY (id_cours)
        REFERENCES COURS(id_cours),
    CONSTRAINT fk_emploi_semestre FOREIGN KEY (id_semestre)
        REFERENCES SEMESTRES(id_semestre)
);
