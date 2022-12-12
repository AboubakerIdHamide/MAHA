<?php

/**
 * class Model Formation
 */


class Formation
{
    private $connect;

    public function __construct($database)
    {
        $this->connect = $database;
    }

    public function countFormations()
    {
        $request = $this->connect->prepare("SELECT COUNT(*) AS total_formations FROM formations");
        $request->execute();
        $response = $request->fetch(PDO::FETCH_OBJ);
        return $response->total_formations;
    }

    public function insertFormation($dataFormation)
    {
        $request = $this->connect->prepare("INSERT INTO formations
            ( niveau_formation, id_formateur, categorie, nom_formation, image_formation, mass_horaire,  prix_formation, description)VALUES
            (:niveau_formation, :id_formateur, :categorie, :nom_formation, :img_formation, :mass_horaire, :prix_formation, :description);");

        $request->bindParam(":niveau_formation", $dataFormation["niveau_formation"]);
        $request->bindParam(":id_formateur", $dataFormation["id_formateur"]);
        $request->bindParam(":categorie", $dataFormation["categorie"]);
        $request->bindParam(":nom_formation", $dataFormation["nom_formation"]);
        $request->bindParam(":img_formation", $dataFormation["img_formation"]);
        $request->bindParam(":mass_horaire", $dataFormation["masse_horaire"]);
        $request->bindParam(":prix_formation", $dataFormation["prix_formation"]);
        $request->bindParam(":description", $dataFormation["description"]);

        $response = $request->execute();

        if ($response)
            return $this->connect->lastInsertId();
        return $response;
    }

    public function updateFormation($dataFormation)
    {
        $request = $this->connect->prepare("UPDATE formations 
            SET niveau_formation=:niveau_formation, categorie=:categorie, nom_formation=:nom_formation, prix_formation=:prix_formation, description=:description, id_langue=:langue 
            WHERE  id_formation=:id");

        $dataFormation["niveauFormation"] = htmlspecialchars($dataFormation["niveauFormation"]);
        $dataFormation["langue"] = htmlspecialchars($dataFormation["langue"]);
        $dataFormation["categorie"] = htmlspecialchars($dataFormation["categorie"]);
        $dataFormation["titre"] = htmlspecialchars($dataFormation["titre"]);
        $dataFormation["prix"] = htmlspecialchars($dataFormation["prix"]);
        $dataFormation["description"] = htmlspecialchars($dataFormation["description"]);
        $dataFormation["id_formation"] = htmlspecialchars($dataFormation["id_formation"]);

        $request->bindParam(":niveau_formation", $dataFormation["niveauFormation"]);
        $request->bindParam(":langue", $dataFormation["langue"]);
        $request->bindParam(":categorie", $dataFormation["categorie"]);
        $request->bindParam(":nom_formation", $dataFormation["titre"]);
        $request->bindParam(":prix_formation", $dataFormation["prix"]);
        $request->bindParam(":description", $dataFormation["description"]);
        $request->bindParam(":id", $dataFormation["id_formation"]);

        $response = $request->execute();
        return $response;
    }

    function deleteFormation($id)
    {
        $request = $this->connect->prepare("
                SET foreign_key_checks = 0;
                DELETE FROM formations WHERE id_formation=:id;
                SET foreign_key_checks = 1;");
        $request->bindParam(":id", $id);

        $response = $request->execute();
        return $response;
    }


    function getFormation($id_formation, $id_formateur)
    {
        $request = $this->connect->prepare("SELECT * FROM formations WHERE id_formation=:id_formation AND id_formateur=:id_formateur");
        $request->bindParam(":id_formation", $id_formation);
        $request->bindParam(":id_formateur", $id_formateur);
        $request->execute();
        $response = $request->fetch();
        return $response;
    }

    function getAllFormations()
    {
        $request = $this->connect->prepare("
            SELECT 
                *
            FROM formations f
            JOIN langues USING (id_langue)
            JOIN niveaux n ON f.niveau_formation = n.id_niveau
            JOIN formateurs USING (id_formateur)
            JOIN categories c ON f.categorie = c.id_categorie
            ORDER BY id_formation
        ");
        $request->execute();
        $formations = $request->fetchAll(PDO::FETCH_OBJ);
        return $formations;
    }

    // fichiers_att AS zipFile
    public function getAllFormationsOfFormateur($id_formateur, $words = '')
    {
        $request = $this->connect->prepare("
            SELECT 
                id_formation AS id,
                nom_formation AS titre,
                image_formation AS miniature,
                DATE(date_creation_formation) AS dateUploaded,
                prix_formation AS prix,
                description,
                likes,
                id_langue AS langue,
                niveau_formation AS niveauFormation,
                categorie
            FROM formations f
            JOIN formateurs USING (id_formateur)
            WHERE id_formateur = :id
            AND nom_formation LIKE CONCAT('%', :words, '%');
        ");
        $request->bindParam(":id", $id_formateur);
        $request->bindParam(":words", $words);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }
    public function getPupalaireCourses()
    {
        $request = $this->connect->prepare("
            SELECT formations.id_formation as 'IdFormation',
                    formations.image_formation as 'imgFormation',
                    formations.mass_horaire as 'duree',
                    formations.categorie as 'categorie',
                    formations.nom_formation as 'nomFormation',
                    formations.prix_formation as 'prix',
                    formations.description as 'description',
                    formations.likes as 'likes',
                    formateurs.id_formateur as 'IdFormteur',
                    formateurs.nom_formateur as 'nomFormateur',
                    formateurs.prenom_formateur as 'prenomFormateur',
                    formateurs.img_formateur as 'imgFormateur'
            FROM formations, formateurs
            WHERE formations.id_formateur = formateurs.id_formateur
            GROUP BY formations.likes 
            ORDER BY formations.likes desc
            LIMIT 1,10
        ");
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }
    public function getFormationsFormateurById($id)
    {
        $request = $this->connect->prepare("
            SELECT formations.id_formation as 'IdFormation',
                formations.image_formation as 'imgFormation',
                formations.mass_horaire as 'duree',
                formations.categorie as 'categorie',
                formations.nom_formation as 'nomFormation',
                formations.prix_formation as 'prix',
                formations.description as 'description',
                formations.likes as 'likes',
                formateurs.id_formateur as 'IdFormteur',
                formateurs.nom_formateur as 'nomFormateur',
                formateurs.prenom_formateur as 'prenomFormateur',
                formateurs.img_formateur as 'imgFormateur'
            FROM formations, formateurs
            WHERE formations.id_formateur = :id
        ");
        $request->bindParam(":id", $id);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function getFormationByNomFormateur($q)
    {
        $request = $this->connect->prepare("
            SELECT 
            *
            FROM formations f
            JOIN langues USING (id_langue)
            JOIN niveaux n ON f.niveau_formation = n.id_niveau
            JOIN formateurs USING (id_formateur)
            JOIN categories c ON f.categorie = c.id_categorie
            WHERE nom_formateur LIKE CONCAT('%', :q,'%')
            ORDER BY id_formation
        ");
        $q = htmlspecialchars($q);
        $request->bindParam(":q", $q);
        $request->execute();
        $formations = $request->fetchAll(PDO::FETCH_OBJ);
        return $formations;
    }

    public function getFormationByNomFormation($q)
    {
        $request = $this->connect->prepare("
            SELECT 
            *
            FROM formations f
            JOIN langues USING (id_langue)
            JOIN niveaux n ON f.niveau_formation = n.id_niveau
            JOIN formateurs USING (id_formateur)
            JOIN categories c ON f.categorie = c.id_categorie
            WHERE f.nom_formation LIKE CONCAT('%', :q,'%')
            ORDER BY id_formation
        ");
        $q = htmlspecialchars($q);
        $request->bindParam(":q", $q);
        $request->execute();
        $formations = $request->fetchAll(PDO::FETCH_OBJ);
        return $formations;
    }
}
