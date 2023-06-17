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
        return false;
    }

    public function insertFormation($dataFormation)
    {
        $query = $this->connect->prepare("
            INSERT INTO formations (niveau_formation, id_formateur, categorie, nom_formation, image_formation, mass_horaire,  prix_formation, description, etat_formation, id_langue, code_formation) VALUES (:niveau_formation, :id_formateur, :categorie, :nom_formation, :img_formation, :mass_horaire, :prix_formation, :description, :etat_formation, :id_langue, :code_formation)
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
        $query->bindParam(":code_formation", $dataFormation["code_formation"]);
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
            SET niveau_formation=:niveau_formation,
                categorie=:categorie,
                nom_formation=:nom_formation,
                prix_formation=:prix_formation,
                description=:description,
                id_langue=:langue,
                etat_formation=:etat_formation
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
            SET foreign_key_checks = 0;
            DELETE FROM formations 
            WHERE id_formation=:id;
            SET foreign_key_checks = 1;
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
        // PDO::FETCH_OBJ
        $formation = $query->fetch();
        if ($query->rowCount() > 0) {
            return $formation;
        }
        return false;
    }

    function getAllFormations()
    {
        $query = $this->connect->prepare("
            SELECT *
            FROM formations f
            JOIN langues USING (id_langue)
            JOIN niveaux n ON f.niveau_formation = n.id_niveau
            JOIN formateurs USING (id_formateur)
            JOIN categories c ON f.categorie = c.id_categorie
            ORDER BY id_formation
        ");

        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return false;
    }

    public function getAllFormationsOfFormateur($id_formateur, $words = '')
    {
        $query = $this->connect->prepare("
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
                categorie,
                fichier_attache AS file,
                etat_formation
            FROM formations f
            JOIN formateurs USING (id_formateur)
            WHERE id_formateur = :id
            AND nom_formation LIKE CONCAT('%', :words, '%');
        ");
        $query->bindParam(":id", $id_formateur);
        $query->bindParam(":words", $words);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return false;
    }

    public function setLike($etudiant_id, $formation_id)
    {
        // like or dislike
        $liked = $this->likedBefore($etudiant_id, $formation_id);
        if ($liked) {
            // dislike
            $query = $this->connect->prepare("
                DELETE FROM likes 
                WHERE etudiant_id=:eId 
                AND formation_id=:fId
            ");
        } else {
            // like
            $query = $this->connect->prepare("
                INSERT INTO likes(etudiant_id, formation_id) VALUES (:eId,:fId)
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
            FROM likes 
            WHERE etudiant_id=:eId 
            AND formation_id=:fId
        ");

        $query->bindParam(':eId', $etudiant_id);
        $query->bindParam(':fId', $formation_id);
        $query->execute();

        // PDO::FETCH_OBJ (variable $likes for what ?)
        $likes = $query->fetch();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function getLikesOfFormation($formationId)
    {
        $query = $this->connect->prepare("
            SELECT likes 
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

    public function getPopularCourses()
    {
        $query = $this->connect->prepare("
            SELECT 
                DISTINCT formations.id_formation AS IdFormation,
                formations.image_formation AS imgFormation,
                formations.mass_horaire AS duree,
                categories.nom_categorie AS categorie,
                formations.nom_formation AS nomFormation,
                formations.prix_formation AS prix,
                formations.description AS description,
                formations.likes AS likes,
                formateurs.id_formateur AS IdFormteur,
                formateurs.nom_formateur AS nomFormateur,
                formateurs.prenom_formateur AS prenomFormateur,
                formateurs.img_formateur AS imgFormateur
            FROM formations, formateurs,categories, inscriptions
            WHERE formations.id_formateur = formateurs.id_formateur
            AND formations.etat_formation = 'public'
            AND categories.id_categorie = formations.categorie
            AND inscriptions.payment_state = 'approved'
            ORDER BY formations.likes DESC
            LIMIT 0,12
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
                formations.id_formation AS IdFormation,
                formations.image_formation AS imgFormation,
                formations.mass_horaire AS duree,
                categories.nom_categorie AS categorie,
                formations.nom_formation AS nomFormation,
                formations.prix_formation AS prix,
                formations.description AS description,
                formations.likes AS likes,
                formateurs.id_formateur AS IdFormteur,
                formateurs.nom_formateur AS nomFormateur,
                formateurs.prenom_formateur AS prenomFormateur,
                formateurs.img_formateur AS imgFormateur
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur and formations.id_formateur = :id
            AND categories.id_categorie = formations.categorie
            AND formations.etat_formation = 'public'
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
            JOIN niveaux n ON f.niveau_formation = n.id_niveau
            JOIN formateurs USING (id_formateur)
            JOIN categories c ON f.categorie = c.id_categorie
            WHERE nom_formateur LIKE CONCAT('%', :q,'%')
            ORDER BY id_formation
        ");

        $q = htmlspecialchars($q);
        $query->bindParam(":q", $q);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return false;
    }

    public function getFormationByNomFormation($q)
    {
        $query = $this->connect->prepare("
            SELECT *
            FROM formations f
            JOIN langues USING (id_langue)
            JOIN niveaux n ON f.niveau_formation = n.id_niveau
            JOIN formateurs USING (id_formateur)
            JOIN categories c ON f.categorie = c.id_categorie
            WHERE f.nom_formation LIKE CONCAT('%', :q,'%')
            ORDER BY id_formation
        ");

        $q = htmlspecialchars($q);
        $query->bindParam(":q", $q);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return false;
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
                formations.id_formation AS IdFormation,
                formations.image_formation AS imgFormation,
                formations.mass_horaire AS duree,
                categories.nom_categorie AS categorie,
                formations.nom_formation AS nomFormation,
                formations.prix_formation AS prix,
                formations.description AS description,
                formations.likes AS likes,
                formateurs.id_formateur AS IdFormteur,
                formateurs.nom_formateur AS nomFormateur,
                formateurs.prenom_formateur AS prenomFormateur,
                formateurs.specialiteId AS specialiteId,
                formateurs.img_formateur AS imgFormateur,
                date(formations.date_creation_formation) AS dateCreationFormation,
                formations.niveau_formation AS IdNiv,
                formations.id_langue AS IdLang
            FROM formations, formateurs,categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.categorie
            AND formations.id_formation = :id
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        // PDO::FETCH_OBJ
        $formation = $query->fetch();
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
        $numbFormations = $query->fetch();
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return false;
    }

    public function getPlusPopilairesFormations($offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation AS IdFormation,
                formations.image_formation AS imgFormation,
                formations.mass_horaire AS duree,
                categories.nom_categorie AS categorie,
                formations.nom_formation AS nomFormation,
                formations.prix_formation AS prix,
                formations.description AS description,
                formations.likes AS likes,
                formateurs.id_formateur AS IdFormteur,
                formateurs.nom_formateur AS nomFormateur,
                formateurs.prenom_formateur AS prenomFormateur,
                formateurs.img_formateur AS imgFormateur
            FROM formations, formateurs,categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND formations.etat_formation = 'public'
            AND categories.id_categorie = formations.categorie
            ORDER BY formations.likes DESC
            LIMIT {$offset},10
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
            WHERE categories.id_categorie = formations.categorie
            AND categories.nom_categorie = :categorie
            AND formations.etat_formation = 'public'
            AND (
                formations.nom_formation LIKE '%{$choi}%' 
                OR formations.description LIKE '%{$choi}%'
            );
        ");

        $query->bindParam(":categorie", $cat);
        $query->execute();

        $numbFormations = $query->fetch();
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return false;
    }

    public function getFormationsByFilter($cat, $choi, $offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation AS IdFormation,
                formations.image_formation AS imgFormation,
                formations.mass_horaire AS duree,
                categories.nom_categorie AS categorie,
                formations.nom_formation AS nomFormation,
                formations.prix_formation AS prix,
                formations.description AS description,
                formations.likes AS likes,
                formateurs.id_formateur AS IdFormteur,
                formateurs.nom_formateur AS nomFormateur,
                formateurs.prenom_formateur AS prenomFormateur,
                formateurs.img_formateur AS imgFormateur
            FROM formations, formateurs,categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.categorie
            AND categories.nom_categorie = :categorie
            AND formations.etat_formation = 'public'
            AND (
                formations.nom_formation LIKE '%{$choi}%' 
                or formations.description LIKE '%{$choi}%'
            )
            LIMIT {$offset},10
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
            AND categories.id_categorie = formations.categorie
            AND formations.etat_formation = 'public'
            AND (
                categories.nom_categorie LIKE '%{$val}%'
                or formateurs.nom_formateur LIKE '%{$val}%'
                or formations.description LIKE '%{$val}%'
                or formations.nom_formation LIKE '%{$val}%'
                or formateurs.prenom_formateur LIKE '%{$val}%'
            );
        ");

        $query->execute();
        // PDO::FETCH_OBJ
        $numbFormations = $query->fetch();
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return false;
    }

    public function getFormationsByValRech($val, $offset)
    {
        $query = $this->connect->prepare("
            SELECT formations.id_formation AS 'IdFormation',
                formations.image_formation AS 'imgFormation',
                formations.mass_horaire AS 'duree',
                categories.nom_categorie AS 'categorie',
                formations.nom_formation AS 'nomFormation',
                formations.prix_formation AS 'prix',
                formations.description AS 'description',
                formations.likes AS 'likes',
                formateurs.id_formateur AS 'IdFormteur',
                formateurs.nom_formateur AS 'nomFormateur',
                formateurs.prenom_formateur AS 'prenomFormateur',
                formateurs.img_formateur AS 'imgFormateur'
            FROM formations, formateurs,categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.categorie
            AND formations.etat_formation = 'public'
            AND (
                categories.nom_categorie like '%{$val}%'
                or formateurs.nom_formateur like '%{$val}%'
                or formations.description like '%{$val}%'
                or formations.nom_formation like '%{$val}%'
                or formateurs.prenom_formateur like '%{$val}%'
            )
            LIMIT {$offset},10
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
                formations.id_formation AS IdFormation,
                formations.image_formation AS imgFormation,
                formations.mass_horaire AS duree,
                categories.nom_categorie AS categorie,
                formations.nom_formation AS nomFormation,
                formations.prix_formation AS prix,
                formations.description AS description,
                formations.likes AS likes,
                formateurs.id_formateur AS IdFormteur,
                formateurs.nom_formateur AS nomFormateur,
                formateurs.prenom_formateur AS prenomFormateur,
                formateurs.img_formateur AS imgFormateur
            FROM formations, formateurs,categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.categorie
            AND formations.etat_formation = 'public'
            ORDER BY formations.likes DESC
            LIMIT {$offset},10
        ");

        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function getPlusFormationsAchter($offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                formations.id_formation AS IdFormation,
                formations.image_formation AS imgFormation,
                formations.mass_horaire AS duree,
                categories.nom_categorie AS categorie,
                formations.nom_formation AS nomFormation,
                formations.prix_formation AS prix,
                formations.description AS description,
                formations.likes AS likes,
                formateurs.id_formateur AS IdFormteur,
                formateurs.nom_formateur AS nomFormateur,
                formateurs.prenom_formateur AS prenomFormateur,
                formateurs.img_formateur AS imgFormateur
            from formations, formateurs,categories
            where formations.id_formateur = formateurs.id_formateur
            and categories.id_categorie = formations.categorie
            and formations.etat_formation = 'public'
            order by 'numbAcht' desc
            limit  {$offset} , 10;
        ");

        $query->execute();
        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsByLangage($lang)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(IdFormation) AS numbFormations
            FROM tablefilter
            WHERE idLangage = :langage
        ");

        $query->bindParam(":langage", $lang);
        $query->execute();

        // PDO::FETCH_OBJ
        $numbFormations = $query->fetch();
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return false;
    }

    public function getFormationsByLangage($lang, $offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                IdFormation AS IdFormation,
                imgFormation AS imgFormation,
                duree AS duree,
                idCategore AS idCategore,
                categorie AS categorie,
                nomFormation AS nomFormation,
                prix AS prix,
                `description` AS description,
                likes AS likes,
                IdFormteur AS IdFormteur,
                nomFormateur AS nomFormateur,
                prenomFormateur AS prenomFormateur,
                specialiteId AS specialiteId,
                specialite AS specialite,
                imgFormateur AS imgFormateur,
                numbAcht AS numbAcht,
                dateCreationFormation AS dateCreationFormation,
                idLangage AS idLangage,
                langageFormation AS langageFormation,
                idNiv AS idNiv,
                niveauFormation AS niveauFormation
            FROM tablefilter
            WHERE idLangage = :langage
            LIMIT {$offset},10
        ");

        $query->bindParam(":langage", $lang);
        $query->execute();

        $formations = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsByNiveau($niv)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(IdFormation) AS numbFormations
            FROM tablefilter
            WHERE idNiv = :nivau;
        ");

        $query->bindParam(":nivau", $niv);
        $query->execute();

        // PDO::FETCH_OBJ
        $numbFormations = $query->fetch();
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return false;
    }

    public function getFormationsByNivau($niv, $offset)
    {
        $query = $this->connect->prepare("
            SELECT 
                IdFormation,
                imgFormation,
                duree',
                idCategore,
                categorie,
                nomFormation,
                prix,
                description,
                likes,
                IdFormteur,
                nomFormateur,
                prenomFormateur,
                specialiteId,
                specialite,
                imgFormateur,
                numbAcht,
                dateCreationFormation,
                idLangage,
                langageFormation,
                idNiv,
                niveauFormation
            FROM tablefilter
            WHERE idNiv = :nivau
            LIMIT {$offset},10
        ");

        $query->bindParam(":nivau", $niv);
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
                COUNT(IdFormation) AS numbFormations
            FROM tablefilter
            WHERE duree 
            BETWEEN TIME(CONCAT('0', :deb, ':00:00')) 
            AND TIME(CONCAT('0', :fin, ':00:00'))
        ");

        $query->bindParam(":deb", $deb);
        $query->bindParam(":fin", $fin);
        $query->execute();

        // PDO::FETCH_OBJ
        $numbFormations = $query->fetch();
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return false;
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
            SET image_formation = :filePath
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
                IdFormation,
                imgFormation,
                duree,
                idCategore,
                categorie,
                nomFormation,
                prix,
                description,
                likes,
                IdFormteur,
                nomFormateur,
                prenomFormateur,
                specialiteId,
                specialite,
                imgFormateur,
                numbAcht,
                dateCreationFormation,
                idLangage,
                langageFormation,
                idNiv,
                niveauFormation
            FROM tablefilter
            WHERE duree 
            BETWEEN TIME(CONCAT('0', :deb, ':00:00')) 
            AND TIME(CONCAT('0', :fin, ':00:00'))
            LIMIT {$offset},10
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
                formateurs.id_formateur,
                nom_formateur,
                prenom_formateur
            FROM formateurs
            JOIN formations ON formateurs.id_formateur = formations.id_formateur
            WHERE BINARY code_formateur = :code
        ");

        $query->execute(['code' => htmlspecialchars($code)]);
        $formations = $query->fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formations;
        }
        return false;
    }
}
