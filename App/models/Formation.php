<?php

/**
 *  Model Formation
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
        $query = $this->connect->prepare("
            SELECT 
                COUNT(*) AS total_formations 
            FROM formations
        ");

        $query->execute();
        $response = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $response->total_formations;
        }
        return 0;
    }

    public function insertFormation($dataFormation)
    {
        $query = $this->connect->prepare("
            INSERT INTO formations (id_niveau, id_formateur, id_categorie, nom, image, mass_horaire, prix, description, etat, id_langue) VALUES (:niveau_formation, :id_formateur, :categorie, :nom_formation, :img_formation, :mass_horaire, :prix_formation, :description, :etat_formation, :id_langue)
        ");

        $query->bindParam(":niveau_formation", $dataFormation["niveau_formation"]);
        $query->bindParam(":id_formateur", $dataFormation["id_formateur"]);
        $query->bindParam(":categorie", $dataFormation["categorie"]);
        $query->bindParam(":nom_formation", $dataFormation["nom_formation"]);
        $query->bindParam(":img_formation", $dataFormation["img_formation"]);
        $query->bindParam(":mass_horaire", $dataFormation["masse_horaire"]);
        $query->bindParam(":prix_formation", $dataFormation["prix_formation"]);
        $query->bindParam(":description", $dataFormation["description"]);
        $query->bindParam(":etat_formation", $dataFormation["etat_formation"]);
        $query->bindParam(":id_langue", $dataFormation["id_langue"]);
        $query->execute();

        $lastInsertId = $this->connect->lastInsertId();
        if ($lastInsertId > 0) {
            return $lastInsertId;
        }
        return false;
    }

    public function updateFormation($dataFormation)
    {
        $query = $this->connect->prepare("
            UPDATE formations 
            SET id_niveau=:niveau_formation,
                id_categorie=:categorie,
                nom=:nom_formation,
                prix=:prix_formation,
                description=:description,
                id_langue=:langue,
                etat=:etat_formation
            WHERE id_formation=:id
        ");

        //  validate
        $dataFormation["niveauFormation"] = htmlspecialchars($dataFormation["niveauFormation"]);
        $dataFormation["langue"] = htmlspecialchars($dataFormation["langue"]);
        $dataFormation["categorie"] = htmlspecialchars($dataFormation["categorie"]);
        $dataFormation["titre"] = htmlspecialchars($dataFormation["titre"]);
        $dataFormation["prix"] = htmlspecialchars($dataFormation["prix"]);
        $dataFormation["description"] = htmlspecialchars($dataFormation["description"]);
        $dataFormation["id_formation"] = htmlspecialchars($dataFormation["id_formation"]);

        $query->bindParam(":niveau_formation", $dataFormation["niveauFormation"]);
        $query->bindParam(":langue", $dataFormation["langue"]);
        $query->bindParam(":categorie", $dataFormation["categorie"]);
        $query->bindParam(":nom_formation", $dataFormation["titre"]);
        $query->bindParam(":prix_formation", $dataFormation["prix"]);
        $query->bindParam(":description", $dataFormation["description"]);
        $query->bindParam(":etat_formation", $dataFormation["visibility"]);
        $query->bindParam(":id", $dataFormation["id_formation"]);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    function deleteFormation($id)
    {
        // You Can Add ON DELETE CASCADE
        $query = $this->connect->prepare("
            DELETE FROM formations 
            WHERE id_formation=:id;
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }


    function getFormation($id_formation, $id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT * 
            FROM formations 
            WHERE id_formation=:id_formation 
            AND id_formateur=:id_formateur
        ");

        $query->bindParam(":id_formation", $id_formation);
        $query->bindParam(":id_formateur", $id_formateur);
        $query->execute();
        $formation = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formation;
        }
        return false;
    }

    public function getAllFormationsOfFormateur($id_formateur, $words = '')
    {
        $query = $this->connect->prepare("
            SELECT 
                id_formation,
                nom,
                image,
                DATE(date_creation) AS date_creation,
                prix,
                description,
                jaimes,
                id_langue,
                id_niveau,
                id_categorie,
                fichier_attache,
                etat
            FROM formations f
            JOIN formateurs USING (id_formateur)
            WHERE id_formateur = :id
            AND nom LIKE CONCAT('%', :words, '%');
        ");
        $query->bindParam(":id", $id_formateur);
        $query->bindParam(":words", $words);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function setLike($etudiant_id, $formation_id)
    {
        // like or dislike
        $liked = $this->likedBefore($etudiant_id, $formation_id);
        if ($liked) {
            // dislike
            $query = $this->connect->prepare("
                DELETE FROM jaimes 
                WHERE id_etudiant=:eId 
                AND id_formation=:fId
            ");
        } else {
            // like
            $query = $this->connect->prepare("
                INSERT INTO jaimes(id_etudiant, id_formation) VALUES (:eId,:fId)
            ");
        }
        $query->bindParam(':eId', $etudiant_id);
        $query->bindParam(':fId', $formation_id);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function likedBefore($etudiant_id, $formation_id)
    {
        $query = $this->connect->prepare("
            SELECT * 
            FROM jaimes 
            WHERE id_etudiant=:eId 
            AND id_formation=:fId
        ");

        $query->bindParam(':eId', $etudiant_id);
        $query->bindParam(':fId', $formation_id);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function getLikesOfFormation($formationId)
    {
        $query = $this->connect->prepare("
            SELECT jaimes 
            FROM formations 
            WHERE  id_formation=:formationId
        ");

        $query->bindParam(':formationId', $formationId);
        $query->execute();

        $likes = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $likes;
        }
        return false;
    }

    public function getPopularCourses($offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                DISTINCT formations.id_formation,
                formations.image AS imgFormation,
                formations.mass_horaire,
                categories.nom AS nomCategorie,
                formations.nom AS nomFormation,
                formations.prix,
                formations.description,
                formations.jaimes,
                formateurs.id_formateur,
                formateurs.nom AS nomFormateur,
                formateurs.prenom,
                formateurs.img AS imgFormateur,
                categories.nom AS nomCategorie
            FROM formations, formateurs, categories, inscriptions
            WHERE formations.id_formateur = formateurs.id_formateur
            AND formations.etat = 'public'
            AND categories.id_categorie = formations.id_categorie
            AND inscriptions.payment_state = 'approved'
            ORDER BY formations.jaimes DESC
            LIMIT {$offset}, 10
        ");

        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function getFormationsFormateurById($id)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation,
                formations.image AS imgFormation,
                formations.mass_horaire,
                categories.nom AS nomCategorie,
                formations.nom AS nomFormation,
                formations.prix,
                formations.description,
                formations.jaimes,
                formateurs.id_formateur,
                formateurs.nom AS nomFormateur,
                formateurs.prenom,
                formateurs.img AS imgFormateur
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur AND formations.id_formateur = :id
            AND categories.id_categorie = formations.id_categorie
            AND formations.etat = 'public'
        ");

        $query->bindParam(":id", $id);
        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function getFormationByNomFormateur($q)
    {
        $query = $this->connect->prepare("
            SELECT *
            FROM formations f
            JOIN langues USING (id_langue)
            JOIN niveaux n USING (id_niveau)
            JOIN formateurs USING (id_formateur)
            JOIN categories c USING (id_categorie)
            WHERE nom LIKE CONCAT('%', :q, '%')
            ORDER BY id_formation
        ");

        $q = htmlspecialchars($q);
        $query->bindParam(":q", $q);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function getFormationByNomFormation($q)
    {
        $query = $this->connect->prepare("
            SELECT *
            FROM formations f
            JOIN langues USING (id_langue)
            JOIN niveaux n USING (id_niveau)
            JOIN formateurs USING (id_formateur)
            JOIN categories USING (id_categorie)
            WHERE f.nom LIKE CONCAT('%', :q, '%')
            ORDER BY id_formation
        ");

        $q = htmlspecialchars($q);
        $query->bindParam(":q", $q);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    // ===================================== Insert Into Table Formations =====================


    public function insertIntoTableFilter($type, $num, $arg1, $arg2)
    {
        if ($type == 'all') {
            $query = $this->connect->prepare("
                DELETE FROM tablefilter;
                CALL insertItoTableFilterAll(:nb)
            ");

            $query->bindParam(":nb", $num);
            $query->execute();
        } elseif ($type == 'rech') {
            $query = $this->connect->prepare("
                DELETE FROM tablefilter;
                CALL insertItoTableFilterRech(:nb, :arg)
            ");

            $query->bindParam(":nb", $num);
            $query->bindParam(":arg", $arg1);
            $query->execute();
        } else {
            $query = $this->connect->prepare("
                DELETE FROM tablefilter;
                CALL insertItoTableFilterFilter(:nb, :arg1, :arg2)
            ");

            $query->bindParam(":nb", $num);
            $query->bindParam(":arg1", $arg1);
            $query->bindParam(":arg2", $arg2);
            $query->execute();
        }
    }

    // ===================================== Insert Into Table Formations =====================
    // ========================== Delete From Table Filter ========================== 

    public function deleteFromTableFilter()
    {

        $query = $this->connect->prepare("
            DELETE FROM tablefilter
        ");

        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
    // ========================== Delete From Table Filter ========================== 
    // ================================ Get Formation By Id ================================

    public function getFormationById($id)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation,
                formations.image AS imgFormation,
                formations.mass_horaire,
                categories.nom AS nomCategorie,
                formations.nom AS nomFormation,
                formations.prix,
                formations.description,
                formations.jaimes,
                formateurs.id_formateur,
                formateurs.nom AS nomFormateur,
                formateurs.prenom,
                formateurs.id_categorie AS categorie,
                formateurs.img AS imgFormateur,
                date(formations.date_creation) AS date_creation,
                formations.id_niveau AS niveau,
                formations.id_langue AS langue,
                langues.nom AS nomLangue,
                niveaux.nom AS nomNiveau
            FROM formations, formateurs, categories, langues, niveaux
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.id_categorie
            AND formations.id_langue = langues.id_langue
            AND formations.id_niveau = niveaux.id_niveau
            AND formations.id_formation = :id
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        $formation = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formation;
        }
        return false;
    }

    // =============================== Filter + Trier + Recherche ==================================

    public function countAllFormations()
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(formations.id_formation) AS numbFormations
            FROM formations
        ");

        $query->execute();
        $numbFormations = $query->fetch(PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getAllFormations($offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation,
                formations.image AS imgFormation,
                formations.mass_horaire,
                categories.nom AS nomCategorie,
                formations.nom AS nomFormation,
                formations.prix,
                formations.description,
                formations.jaimes,
                formateurs.id_formateur,
                formateurs.nom AS nomFormateur,
                formateurs.prenom,
                formateurs.img AS imgFormateur
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND formations.etat = 'public'
            AND categories.id_categorie = formations.id_categorie
            ORDER BY formations.jaimes DESC
            LIMIT {$offset}, 10
        ");

        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsFilter($cat, $choi)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(formations.id_formation) AS numbFormations
            FROM formations,categories
            WHERE categories.id_categorie = formations.id_categorie
            AND categories.nom = :categorie
            AND formations.etat = 'public'
            AND (
                formations.nom LIKE '%{$choi}%' 
                OR formations.description LIKE '%{$choi}%'
            );
        ");

        $query->bindParam(":categorie", $cat);
        $query->execute();

        $numbFormations = $query->fetch(PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getFormationsByFilter($cat, $choi, $offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation,
                formations.image AS imgFormation,
                formations.mass_horaire,
                categories.nom AS nomCategorie,
                formations.nom AS nomFormation,
                formations.prix,
                formations.description,
                formations.jaimes,
                formateurs.id_formateur,
                formateurs.nom AS nomFormateur,
                formateurs.prenom,
                formateurs.img AS imgFormateur
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.id_categorie
            AND categories.nom = :categorie
            AND formations.etat = 'public'
            AND (
                formations.nom LIKE '%{$choi}%' 
                OR formations.description LIKE '%{$choi}%'
            )
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":categorie", $cat);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsRech($val)
    {

        $query = $this->connect->prepare("
            SELECT 
                COUNT(formations.id_formation) AS numbFormations
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.id_categorie
            AND formations.etat = 'public'
            AND (
                categories.nom LIKE '%{$val}%'
                OR formateurs.nom LIKE '%{$val}%'
                OR formations.description LIKE '%{$val}%'
                OR formations.nom LIKE '%{$val}%'
                OR formateurs.prenom LIKE '%{$val}%'
            );
        ");

        $query->execute();
        $numbFormations = $query->fetch(PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getFormationsByValRech($val, $offset)
    {
        $query = $this->connect->prepare("
            SELECT formations.id_formation,
                formations.image AS imgFormation,
                formations.mass_horaire,
                categories.nom AS nomCategorie,
                formations.nom AS nomFormation,
                formations.prix,
                formations.description,
                formations.jaimes,
                formateurs.id_formateur,
                formateurs.nom AS nomFormateur,
                formateurs.prenom,
                formateurs.img AS imgFormateur
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.id_categorie
            AND formations.etat_formation = 'public'
            AND (
                categories.nom LIKE '%{$val}%'
                OR formateurs.nom LIKE '%{$val}%'
                OR formations.description LIKE '%{$val}%'
                OR formations.nom LIKE '%{$val}%'
                OR formateurs.prenom LIKE '%{$val}%'
            )
            LIMIT {$offset}, 10
        ");

        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }


    public function getPlusFormationsAmais($offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation,
                formations.image AS imgFormation,
                formations.mass_horaire,
                categories.nom AS nomCategorie,
                formations.nom AS nomFormation,
                formations.prix,
                formations.description,
                formations.jaimes,
                formateurs.id_formateur,
                formateurs.nom AS nomFormateur,
                formateurs.prenom,
                formateurs.img AS imgFormateur
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.id_categorie
            AND formations.etat = 'public'
            ORDER BY formations.jaimes DESC
            LIMIT {$offset}, 10
        ");

        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function getPlusFormationsAcheter($offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation,
                formations.image AS imgFormation,
                formations.mass_horaire,
                categories.nom AS nomCategorie,
                formations.nom AS nomFormation,
                formations.prix,
                formations.description,
                formations.jaimes,
                formateurs.id_formateur,
                formateurs.nom AS nomFormateur,
                formateurs.prenom,
                formateurs.img AS imgFormateur
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.id_categorie
            AND formations.etat = 'public'
            ORDER BY 'numbAcht' DESC
            LIMIT  {$offset}, 10;
        ");

        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsByLangue($id_langue)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(id_formation) AS numbFormations
            FROM formations
            WHERE id_langue = :id_langue
        ");

        $query->bindParam(":id_langue", $id_langue);
        $query->execute();

        $numbFormations = $query->fetch(PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getFormationsByLangue($id_langue, $offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                id_formation,
                f.id_formateur,
                f.img AS imgFormateur,
                fo.image AS imgFormation,
                f.nom AS nomFormateur,
                fo.nom AS nomFormation,
                prix,
                mass_horaire,
                description,
                jaimes,
                id_langue,
                id_niveau,
                fo.id_categorie,
                fichier_attache,
                etat,
                c.nom AS nomCategorie
            FROM formations fo
            JOIN formateurs f USING (id_formateur)
            JOIN categories c ON fo.id_categorie = c.id_categorie
            WHERE id_langue = :langue          
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":langue", $id_langue);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsByNiveau($id_niveau)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(id_formation) AS numbFormations
            FROM formations
            WHERE id_niveau = :id_niveau
        ");

        $query->bindParam(":id_niveau", $id_niveau);
        $query->execute();

        $numbFormations = $query->fetch(PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getFormationsByNiveau($id_niveau, $offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                id_formation,
                f.id_formateur,
                f.img AS imgFormateur,
                fo.image AS imgFormation,
                f.nom AS nomFormateur,
                fo.nom AS nomFormation,
                prix,
                mass_horaire,
                description,
                jaimes,
                id_langue,
                id_niveau,
                fo.id_categorie,
                fichier_attache,
                etat,
                c.nom AS nomCategorie
            FROM formations fo
            JOIN formateurs f USING (id_formateur)
            JOIN categories c ON fo.id_categorie = c.id_categorie
            WHERE id_niveau = :id_niveau
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":id_niveau", $id_niveau);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsByDuree($deb, $fin)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(id_formation) AS numbFormations
            FROM formations
            WHERE mass_horaire 
            BETWEEN TIME(CONCAT('0', :deb, ':00:00')) 
            AND TIME(CONCAT('0', :fin, ':00:00'))
        ");

        $query->bindParam(":deb", $deb);
        $query->bindParam(":fin", $fin);
        $query->execute();

        $numbFormations = $query->fetch(PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function updateFichierAttache($data)
    {
        $query = $this->connect->prepare("
            UPDATE formations 
            SET fichier_attache = :filePath
            WHERE id_formation = :id
        ");

        $query->execute(['filePath' => $data['path'], 'id' => $data['id']]);
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function updateImgFormation($data)
    {
        $query = $this->connect->prepare("
            UPDATE formations 
            SET image = :filePath
            WHERE id_formation = :id
        ");

        $query->execute(['filePath' => $data['path'], 'id' => $data['id']]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function getFormationsByDuree($deb, $fin, $offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                id_formation,
                f.id_formateur,
                f.img AS imgFormateur,
                fo.image AS imgFormation,
                f.nom AS nomFormateur,
                fo.nom AS nomFormation,
                prix,
                mass_horaire,
                description,
                jaimes,
                id_langue,
                id_niveau,
                fo.id_categorie,
                fichier_attache,
                etat,
                c.nom AS nomCategorie
            FROM formations fo
            JOIN formateurs f USING (id_formateur)
            JOIN categories c ON fo.id_categorie = c.id_categorie
            WHERE mass_horaire 
            BETWEEN TIME(CONCAT('0', :deb, ':00:00')) 
            AND TIME(CONCAT('0', :fin, ':00:00'))
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":deb", $deb);
        $query->bindParam(":fin", $fin);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function joinCourse($code)
    {
        $query = $this->connect->prepare("
            SELECT 
                id_formation,
                f.id_formateur,
                f.nom,
                prenom,
                prix
            FROM formateurs f
            JOIN formations USING (id_formateur)
            WHERE BINARY code = :code
        ");

        $query->execute(['code' => htmlspecialchars($code)]);
        $formations = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }
}
