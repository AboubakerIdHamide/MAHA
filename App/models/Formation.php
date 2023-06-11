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
            ( niveau_formation, id_formateur, categorie, nom_formation, image_formation, mass_horaire,  prix_formation, description, etat_formation, id_langue, code_formation)VALUES
            (:niveau_formation, :id_formateur, :categorie, :nom_formation, :img_formation, :mass_horaire, :prix_formation, :description, :etat_formation, :id_langue, :code_formation);");

        $request->bindParam(":niveau_formation", $dataFormation["niveau_formation"]);
        $request->bindParam(":id_formateur", $dataFormation["id_formateur"]);
        $request->bindParam(":categorie", $dataFormation["categorie"]);
        $request->bindParam(":nom_formation", $dataFormation["nom_formation"]);
        $request->bindParam(":img_formation", $dataFormation["img_formation"]);
        $request->bindParam(":mass_horaire", $dataFormation["masse_horaire"]);
        $request->bindParam(":prix_formation", $dataFormation["prix_formation"]);
        $request->bindParam(":description", $dataFormation["description"]);
        $request->bindParam(":etat_formation", $dataFormation["etat_formation"]);
        $request->bindParam(":id_langue", $dataFormation["id_langue"]);
        $request->bindParam(":code_formation", $dataFormation["code_formation"]);

        $response = $request->execute();

        if ($response)
            return $this->connect->lastInsertId();
        return $response;
    }

    public function updateFormation($dataFormation)
    {
        $request = $this->connect->prepare("UPDATE formations 
            SET 
            niveau_formation=:niveau_formation,
            categorie=:categorie,
            nom_formation=:nom_formation,
            prix_formation=:prix_formation,
            description=:description,
            id_langue=:langue,
            etat_formation=:etat_formation,
            code_formation=:code_formation
            WHERE  id_formation=:id");

        // Generate formation code if private
        if ($dataFormation["visibility"] == "private") {
            $code_formation = bin2hex(random_bytes(20));
            $isValideCode = $this->isValideCode($code_formation);
            // if the code already used generate other one
            while (!$isValideCode) {
                $code_formation = bin2hex(random_bytes(20));
                $isValideCode = $this->isValideCode($code_formation);
            }
            $dataFormation["code_formation"] = $code_formation;
        } else {
            $dataFormation["code_formation"] = null;
        }


        //  validate
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
        $request->bindParam(":etat_formation", $dataFormation["visibility"]);
        $request->bindParam(":code_formation", $dataFormation["code_formation"]);
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
                    categorie,
                    fichier_attache AS file,
                    etat_formation,
                    code_formation
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

    public function setLike($etudiant_id, $formation_id)
    {
        // like or dislike
        $liked = $this->likedBefore($etudiant_id, $formation_id);
        if ($liked) {
            // dislike
            $req = $this->connect->prepare("DELETE FROM likes WHERE etudiant_id=:eId AND formation_id=:fId");
        } else {
            // like
            $req = $this->connect->prepare("INSERT INTO likes(etudiant_id, formation_id) VALUES (:eId,:fId)");
        }
        $req->bindParam(':eId', $etudiant_id);
        $req->bindParam(':fId', $formation_id);
        $res = $req->execute();
        return $res;
    }

    public function likedBefore($etudiant_id, $formation_id)
    {
        $req = $this->connect->prepare("SELECT * FROM likes WHERE etudiant_id=:eId AND formation_id=:fId");
        $req->bindParam(':eId', $etudiant_id);
        $req->bindParam(':fId', $formation_id);
        $req->execute();
        $res = $req->fetch();
        if (!empty($res)) {
            return true;
        }
        return false;
    }

    public function getLikesOfFormation($formationId)
    {
        $req = $this->connect->prepare("SELECT likes FROM formations WHERE  id_formation=:formationId");
        $req->bindParam(':formationId', $formationId);
        $req->execute();
        $res = $req->fetch(PDO::FETCH_OBJ);
        return $res;
    }

    public function getPopularCourses()
    {
        $request = $this->connect->prepare("SELECT DISTINCT formations.id_formation as 'IdFormation',
                    formations.image_formation as 'imgFormation',
                    formations.mass_horaire as 'duree',
                    categories.nom_categorie as 'categorie',
                    formations.nom_formation as 'nomFormation',
                    formations.prix_formation as 'prix',
                    formations.description as 'description',
                    formations.likes as 'likes',
                    formateurs.id_formateur as 'IdFormteur',
                    formateurs.nom_formateur as 'nomFormateur',
                    formateurs.prenom_formateur as 'prenomFormateur',
                    formateurs.img_formateur as 'imgFormateur'
            from formations, formateurs,categories, inscriptions
            where formations.id_formateur = formateurs.id_formateur
            and formations.etat_formation = 'public'
            and categories.id_categorie = formations.categorie
            and inscriptions.payment_state = 'approved'
            order by formations.likes desc
            limit 0,12;
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
                    categories.nom_categorie as 'categorie',
                    formations.nom_formation as 'nomFormation',
                    formations.prix_formation as 'prix',
                    formations.description as 'description',
                    formations.likes as 'likes',
                    formateurs.id_formateur as 'IdFormteur',
                    formateurs.nom_formateur as 'nomFormateur',
                    formateurs.prenom_formateur as 'prenomFormateur',
                    formateurs.img_formateur as 'imgFormateur'
            from formations, formateurs, categories
            where formations.id_formateur = formateurs.id_formateur and formations.id_formateur = :id
            and categories.id_categorie = formations.categorie
            and formations.etat_formation = 'public'
            ;
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

    // ===================================== Insert Into Table Formations =====================


    public function insertIntoTableFilter($type, $num, $arg1, $arg2)
    {

        if ($type == 'all') {
            $request = $this->connect->prepare("delete from tablefilter;
                                call insertItoTableFilterAll(:nb);
            ");
            $request->bindParam(":nb", $num);
            $request->execute();
        }
        if ($type == 'rech') {
            $request = $this->connect->prepare("delete from tablefilter;
                                    call insertItoTableFilterRech(:nb, :arg);
            ");
            $request->bindParam(":nb", $num);
            $request->bindParam(":arg", $arg1);

            $request->execute();
        }
        if ($type == 'filter') {
            $request = $this->connect->prepare("delete from tablefilter;
                        call insertItoTableFilterFilter(:nb, :arg1, :arg2);
            ");
            $request->bindParam(":nb", $num);
            $request->bindParam(":arg1", $arg1);
            $request->bindParam(":arg2", $arg2);
            $request->execute();
        }
    }

    // ===================================== Insert Into Table Formations =====================
    // ========================== Delete From Table Filter ========================== 

    public function deleteFromTableFilter()
    {

        $request = $this->connect->prepare("delete from tablefilter;");

        $request->execute();
    }
    // ========================== Delete From Table Filter ========================== 
    // ================================ Get Formation By Id ================================

    public function getFormationById($id)
    {
        $request = $this->connect->prepare("SELECT formations.id_formation as 'IdFormation',
                    formations.image_formation as 'imgFormation',
                    formations.mass_horaire as 'duree',
                    categories.nom_categorie as 'categorie',
                    formations.nom_formation as 'nomFormation',
                    formations.prix_formation as 'prix',
                    formations.description as 'description',
                    formations.likes as 'likes',
                    formateurs.id_formateur as 'IdFormteur',
                    formateurs.nom_formateur as 'nomFormateur',
                    formateurs.prenom_formateur as 'prenomFormateur',
                    formateurs.specialiteId as 'specialiteId',
                    formateurs.img_formateur as 'imgFormateur',
                    date(formations.date_creation_formation) as 'dateCreationFormation',
                    formations.niveau_formation as 'IdNiv',
                    formations.id_langue as 'IdLang'
            from formations, formateurs,categories
            where formations.id_formateur = formateurs.id_formateur
            and categories.id_categorie = formations.categorie
            and formations.id_formation = :id;
        ");
        $request->bindParam(":id", $id);
        $request->execute();
        $response = $request->fetch();
        return $response;
    }

    // =============================== Filter + Trier + Recherche ==================================

    public function countAllFormations()
    {
        $request = $this->connect->prepare("SELECT count(formations.id_formation) as 'numbFormations'
            from formations;
        ");
        $request->execute();
        $response = $request->fetch();
        return $response;
    }

    public function getPlusPopilairesFormations($offset)
    {
        $numbDeb = intval($offset);

        $request = $this->connect->prepare("SELECT formations.id_formation as 'IdFormation',
                    formations.image_formation as 'imgFormation',
                    formations.mass_horaire as 'duree',
                    categories.nom_categorie as 'categorie',
                    formations.nom_formation as 'nomFormation',
                    formations.prix_formation as 'prix',
                    formations.description as 'description',
                    formations.likes as 'likes',
                    formateurs.id_formateur as 'IdFormteur',
                    formateurs.nom_formateur as 'nomFormateur',
                    formateurs.prenom_formateur as 'prenomFormateur',
                    formateurs.img_formateur as 'imgFormateur'
            from formations, formateurs,categories
            where formations.id_formateur = formateurs.id_formateur
            and formations.etat_formation = 'public'
            and categories.id_categorie = formations.categorie
            order by formations.likes desc
            limit  {$numbDeb}, 10;
        ");
        // $request->bindParam(":numbDeb", $numbDeb);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function countFormationsFilter($cat, $choi)
    {
        $request = $this->connect->prepare("SELECT count(formations.id_formation) as 'numbFormations'
            from formations,categories
            where categories.id_categorie = formations.categorie
            and categories.nom_categorie = :categorie
            and formations.etat_formation = 'public'
            and (
                formations.nom_formation like '%{$choi}%' 
                or formations.description like '%{$choi}%'
            );
        ");
        $request->bindParam(":categorie", $cat);
        $request->execute();
        $response = $request->fetch();
        return $response;
    }

    public function getFormationsByFilter($cat, $choi, $offset)
    {
        $numbDeb = intval($offset);

        $request = $this->connect->prepare("SELECT formations.id_formation as 'IdFormation',
                    formations.image_formation as 'imgFormation',
                    formations.mass_horaire as 'duree',
                    categories.nom_categorie as 'categorie',
                    formations.nom_formation as 'nomFormation',
                    formations.prix_formation as 'prix',
                    formations.description as 'description',
                    formations.likes as 'likes',
                    formateurs.id_formateur as 'IdFormteur',
                    formateurs.nom_formateur as 'nomFormateur',
                    formateurs.prenom_formateur as 'prenomFormateur',
                    formateurs.img_formateur as 'imgFormateur'
            from formations, formateurs,categories
            where formations.id_formateur = formateurs.id_formateur
            and categories.id_categorie = formations.categorie
            and categories.nom_categorie = :categorie
            and formations.etat_formation = 'public'
            and (
                formations.nom_formation like '%{$choi}%' 
                or formations.description like '%{$choi}%'
            )
            limit  {$numbDeb} , 10;
        ");
        $request->bindParam(":categorie", $cat);
        // $request->bindParam(":offset", $offset);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function countFormationsRech($val)
    {

        $request = $this->connect->prepare("SELECT count(formations.id_formation) as 'numbFormations'
            from formations, formateurs,categories
            where formations.id_formateur = formateurs.id_formateur
            and categories.id_categorie = formations.categorie
            and formations.etat_formation = 'public'
            and (
                categories.nom_categorie like '%{$val}%'
                or formateurs.nom_formateur like '%{$val}%'
                or formations.description like '%{$val}%'
                or formations.nom_formation like '%{$val}%'
                or formateurs.prenom_formateur like '%{$val}%'
            );
        ");
        $request->execute();
        $response = $request->fetch();
        return $response;
    }


    public function getFormationsByValRech($val, $offset)
    {
        $numbDeb = intval($offset);

        $request = $this->connect->prepare("SELECT formations.id_formation as 'IdFormation',
                formations.image_formation as 'imgFormation',
                formations.mass_horaire as 'duree',
                categories.nom_categorie as 'categorie',
                formations.nom_formation as 'nomFormation',
                formations.prix_formation as 'prix',
                formations.description as 'description',
                formations.likes as 'likes',
                formateurs.id_formateur as 'IdFormteur',
                formateurs.nom_formateur as 'nomFormateur',
                formateurs.prenom_formateur as 'prenomFormateur',
                formateurs.img_formateur as 'imgFormateur'
            from formations, formateurs,categories
            where formations.id_formateur = formateurs.id_formateur
            and categories.id_categorie = formations.categorie
            and formations.etat_formation = 'public'
            and (
                categories.nom_categorie like '%{$val}%'
                or formateurs.nom_formateur like '%{$val}%'
                or formations.description like '%{$val}%'
                or formations.nom_formation like '%{$val}%'
                or formateurs.prenom_formateur like '%{$val}%'
            )
            limit  {$numbDeb} , 10;
        ");
        // $request->bindParam(":offset", $offset);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }


    public function getPlusFormationsAmais($offset)
    {
        $numbDeb = intval($offset);

        $request = $this->connect->prepare("SELECT formations.id_formation as 'IdFormation',
                    formations.image_formation as 'imgFormation',
                    formations.mass_horaire as 'duree',
                    categories.nom_categorie as 'categorie',
                    formations.nom_formation as 'nomFormation',
                    formations.prix_formation as 'prix',
                    formations.description as 'description',
                    formations.likes as 'likes',
                    formateurs.id_formateur as 'IdFormteur',
                    formateurs.nom_formateur as 'nomFormateur',
                    formateurs.prenom_formateur as 'prenomFormateur',
                    formateurs.img_formateur as 'imgFormateur'
            from formations, formateurs,categories
            where formations.id_formateur = formateurs.id_formateur
            and categories.id_categorie = formations.categorie
            and formations.etat_formation = 'public'
            order by formations.likes desc
            limit  {$numbDeb} , 10;
        ");
        // $request->bindParam(":offset", $offset);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function getPlusFormationsAchter($offset)
    {
        $numbDeb = intval($offset);

        $request = $this->connect->prepare("SELECT formations.id_formation as 'IdFormation',
                    formations.image_formation as 'imgFormation',
                    formations.mass_horaire as 'duree',
                    categories.nom_categorie as 'categorie',
                    formations.nom_formation as 'nomFormation',
                    formations.prix_formation as 'prix',
                    formations.description as 'description',
                    formations.likes as 'likes',
                    formateurs.id_formateur as 'IdFormteur',
                    formateurs.nom_formateur as 'nomFormateur',
                    formateurs.prenom_formateur as 'prenomFormateur',
                    formateurs.img_formateur as 'imgFormateur'
            from formations, formateurs,categories
            where formations.id_formateur = formateurs.id_formateur
            and categories.id_categorie = formations.categorie
            and formations.etat_formation = 'public'
            order by 'numbAcht' desc
            limit  {$numbDeb} , 10;
        ");
        // $request->bindParam(":offset", $offset);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function countFormationsByLangage($lang)
    {
        $request = $this->connect->prepare("SELECT count(IdFormation) as 'numbFormations'
            from tablefilter
            where idLangage = :langage;
        ");
        $request->bindParam(":langage", $lang);
        $request->execute();
        $response = $request->fetch();
        return $response;
    }

    public function getFormationsByLangage($lang, $offset)
    {
        $numbDeb = intval($offset);

        $request = $this->connect->prepare("SELECT IdFormation as 'IdFormation',
                    imgFormation as 'imgFormation',
                    duree as 'duree',
                    idCategore as 'idCategore',
                    categorie as 'categorie',
                    nomFormation as 'nomFormation',
                    prix as 'prix',
                    `description` as 'description',
                    likes as 'likes',
                    IdFormteur as 'IdFormteur',
                    nomFormateur as 'nomFormateur',
                    prenomFormateur as 'prenomFormateur',
                    specialiteId as 'specialiteId',
                    specialite as 'specialite',
                    imgFormateur as 'imgFormateur',
                    numbAcht as 'numbAcht',
                    dateCreationFormation as 'dateCreationFormation',
                    idLangage as 'idLangage',
                    langageFormation as 'langageFormation',
                    idNiv as 'idNiv',
                    niveauFormation as 'niveauFormation'
            from tablefilter
            where idLangage = :langage
            limit  {$numbDeb} , 10;
        ");
        $request->bindParam(":langage", $lang);
        // $request->bindParam(":offset", $offset);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function countFormationsByNiveau($niv)
    {
        $request = $this->connect->prepare("SELECT count(IdFormation) as 'numbFormations'
            from tablefilter
            where idNiv = :nivau;
        ");
        $request->bindParam(":nivau", $niv);
        $request->execute();
        $response = $request->fetch();
        return $response;
    }

    public function getFormationsByNivau($niv, $offset)
    {
        $numbDeb = intval($offset);

        $request = $this->connect->prepare("SELECT IdFormation as 'IdFormation',
                    imgFormation as 'imgFormation',
                    duree as 'duree',
                    idCategore as 'idCategore',
                    categorie as 'categorie',
                    nomFormation as 'nomFormation',
                    prix as 'prix',
                    `description` as 'description',
                    likes as 'likes',
                    IdFormteur as 'IdFormteur',
                    nomFormateur as 'nomFormateur',
                    prenomFormateur as 'prenomFormateur',
                    specialiteId as 'specialiteId',
                    specialite as 'specialite',
                    imgFormateur as 'imgFormateur',
                    numbAcht as 'numbAcht',
                    dateCreationFormation as 'dateCreationFormation',
                    idLangage as 'idLangage',
                    langageFormation as 'langageFormation',
                    idNiv as 'idNiv',
                    niveauFormation as 'niveauFormation'
            from tablefilter
            where idNiv = :nivau
            limit  {$numbDeb} , 10;
        ");
        $request->bindParam(":nivau", $niv);
        // $request->bindParam(":offset", $offset);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function countFormationsByDuree($deb, $fin)
    {
        $request = $this->connect->prepare("SELECT count(IdFormation) as 'numbFormations'
            from tablefilter
            where duree BETWEEN time(concat('0', :deb, ':00:00')) and time(concat('0', :fin, ':00:00'));
        ");
        $request->bindParam(":deb", $deb);
        $request->bindParam(":fin", $fin);
        $request->execute();
        $response = $request->fetch();
        return $response;
    }

    public function updateFichierAttache($data)
    {
        $request = $this->connect->prepare("
            UPDATE formations 
            SET fichier_attache = :filePath
            WHERE id_formation = :id
        ");
        $response = $request->execute(['filePath' => $data['path'], 'id' => $data['id']]);
        return $response;
    }

    public function updateImgFormation($data)
    {
        $request = $this->connect->prepare("
            UPDATE formations 
            SET image_formation = :filePath
            WHERE id_formation = :id
        ");
        $response = $request->execute(['filePath' => $data['path'], 'id' => $data['id']]);
        return $response;
    }

    public function getFormationsByDuree($deb, $fin, $offset)
    {
        $numbDeb = intval($offset);

        $request = $this->connect->prepare("SELECT IdFormation as 'IdFormation',
                    imgFormation as 'imgFormation',
                    duree as 'duree',
                    idCategore as 'idCategore',
                    categorie as 'categorie',
                    nomFormation as 'nomFormation',
                    prix as 'prix',
                    `description` as 'description',
                    likes as 'likes',
                    IdFormteur as 'IdFormteur',
                    nomFormateur as 'nomFormateur',
                    prenomFormateur as 'prenomFormateur',
                    specialiteId as 'specialiteId',
                    specialite as 'specialite',
                    imgFormateur as 'imgFormateur',
                    numbAcht as 'numbAcht',
                    dateCreationFormation as 'dateCreationFormation',
                    idLangage as 'idLangage',
                    langageFormation as 'langageFormation',
                    idNiv as 'idNiv',
                    niveauFormation as 'niveauFormation'
            from tablefilter
            where duree BETWEEN time(concat('0', :deb, ':00:00')) and time(concat('0', :fin, ':00:00'))
            limit  {$numbDeb} , 10;
        ");
        $request->bindParam(":deb", $deb);
        $request->bindParam(":fin", $fin);
        // $request->bindParam(":offset", $offset);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    // checking code of formation is already used
    public function isValideCode($code)
    {
        $request = $this->connect->prepare("SELECT code_formation FROM formations WHERE code_formation=:code");
        $request->bindParam(":code", $code);
        $request->execute();
        $response = $request->fetch();
        if (!empty($response)) {
            return false;
        }
        return true;
    }

    public function joinCourse($code)
    {
        $query = $this->connect->prepare("
        SELECT 
            id_formation,
            id_formateur  
        FROM formations
        WHERE BINARY code_formation = :code");

        $query->execute(['code' => htmlspecialchars($code)]);
        $formation = $query->fetch(PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formation;
        }

        return false;
    }
}
