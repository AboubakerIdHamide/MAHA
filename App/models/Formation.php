<?php

/**
 *  Model Formation
 */

namespace App\Models;

use App\Libraries\Database;

class Formation
{
    private $connect;

    public function __construct()
    {
        $this->connect = Database::getConnection();
    }

    public function count($etat = 'public')
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(*) AS total_formations 
            FROM formations
            WHERE etat = '{$etat}'
        ");

        $query->execute();
        $response = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $response->total_formations;
        }
        return 0;
    }

    public function create($formation)
    {
        $query = $this->connect->prepare("
            INSERT INTO formations (id_niveau, id_formateur, id_categorie, nom, image, mass_horaire, prix, description, etat, id_langue, is_published) VALUES (:id_niveau, :id_formateur, :id_categorie, :nom, :image, :mass_horaire, :prix, :description, :etat, :id_langue, :is_published)
        ");

        $query->bindValue(":id_niveau", $formation["id_niveau"]);
        $query->bindValue(":id_formateur", $formation["id_formateur"]);
        $query->bindValue(":id_categorie", $formation["id_categorie"]);
        $query->bindValue(":nom", $formation["nom"]);
        $query->bindValue(":image", $formation["image"]);
        $query->bindValue(":mass_horaire", $formation["masse_horaire"]);
        $query->bindValue(":prix", $formation["prix"]);
        $query->bindValue(":description", $formation["description"]);
        $query->bindValue(":etat", $formation["etat"]);
        $query->bindValue(":id_langue", $formation["id_langue"]);
        $query->bindValue(":is_published", empty($formation["is_published"]) ? null : date('Y-m-d H:i:s'));
        $query->execute();

        $lastInsertId = $this->connect->lastInsertId();
        if ($lastInsertId > 0) {
            return $lastInsertId;
        }
        return false;
    }

    public function update($formation)
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

        $query->bindParam(":niveau_formation", $formation["niveauFormation"]);
        $query->bindParam(":langue", $formation["langue"]);
        $query->bindParam(":categorie", $formation["categorie"]);
        $query->bindParam(":nom_formation", $formation["titre"]);
        $query->bindParam(":prix_formation", $formation["prix"]);
        $query->bindParam(":description", $formation["description"]);
        $query->bindParam(":etat_formation", $formation["visibility"]);
        $query->bindParam(":id", $formation["id_formation"]);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
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

    public function getFormation($id_formation, $id_formateur)
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

        $formation = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formation;
        }
        return false;
    }

    public function getFormationsOfFormateur($id)
    {
        $query = $this->connect->prepare("
            SELECT 
                id_formation,
                fore.nom AS nomFormation,
                fore.slug,
                fore.image,
                fore.slug,
                DATE(fore.date_creation) AS date_creation,
                mass_horaire,
                prix,
                description,
                jaimes,
                n.nom AS nomNiveau,
                c.id_categorie,
                c.nom AS nomCategorie
            FROM formations fore
            JOIN formateurs f USING (id_formateur)
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            WHERE id_formateur = :id_formateur
            AND etat = 'public'
            ORDER BY fore.date_creation DESC
        ");

        $query->bindParam(":id_formateur", $id);
        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function setLike($etudiant_id, $formation_id)
    {
        // like or dislike
        $liked = $this->isLikedBefore($etudiant_id, $formation_id);
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

    public function isLikedBefore($etudiant_id, $formation_id)
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

    public function getLikes($id)
    {
        $query = $this->connect->prepare("
            SELECT jaimes 
            FROM formations 
            WHERE  id_formation=:id
        ");

        $query->bindParam(':id', $id);
        $query->execute();

        $jaimes = $query->fetch(\PDO::FETCH_OBJ)->jaimes;
        if ($query->rowCount() > 0) {
            return $jaimes;
        }
        return 0;
    }

    public function getPopularCourses()
    {
        $query = $this->connect->prepare("
            SELECT
                fore.id_formation,
                fore.slug,
                fore.image AS imgFormation,
                mass_horaire,
                fore.nom AS nomFormation,
                fore.date_creation,
                COUNT(id_inscription) AS total_inscriptions,
                fore.prix,
                jaimes,
                description,
                f.id_formateur,
                f.nom AS nomFormateur,
                f.prenom,
                f.img AS imgFormateur,
                c.id_categorie,
                c.nom AS nomCategorie,
                l.id_langue,
                l.nom AS nomLangue,
                n.id_niveau,
                n.nom AS nomNiveau,
                n.icon AS iconNiveau
            FROM formations fore
            LEFT JOIN inscriptions i ON fore.id_formation = i.id_formation
            JOIN formateurs f ON fore.id_formateur = f.id_formateur
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN langues l ON fore.id_langue = l.id_langue
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            WHERE fore.etat = 'public'
            GROUP BY id_formation, fore.nom, jaimes
            ORDER BY GREATEST(COUNT(id_inscription), jaimes) DESC
            LIMIT 10
        ");

        $query->execute();
        $formations = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function whereNomFormateur($nomFormateur)
    {
        $query = $this->connect->prepare("
            SELECT
                fore.id_formation,
                image AS imgFormation,
                mass_horaire,
                fore.nom AS nomFormation,
                fore.date_creation,
                prix,
                description,
                jaimes,
                description,
                f.id_formateur,
                f.nom AS nomFormateur,
                f.prenom,
                f.img AS imgFormateur,
                c.id_categorie,
                c.nom AS nomCategorie,
                l.id_langue,
                l.nom AS nomLangue,
                n.id_niveau,
                n.nom AS nomNiveau
            FROM formations fore
            JOIN formateurs f ON fore.id_formateur = f.id_formateur
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN langues l ON fore.id_langue = l.id_langue
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            WHERE fore.etat = 'public'
            AND f.nom LIKE CONCAT('%', :nomFormateur, '%')
        ");

        $query->bindParam(":nomFormateur", $nomFormateur);
        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function whereNom($nom)
    {
        $query = $this->connect->prepare("
            SELECT
                fore.id_formation,
                image AS imgFormation,
                mass_horaire,
                fore.nom AS nomFormation,
                fore.date_creation,
                prix,
                description,
                jaimes,
                description,
                f.id_formateur,
                f.nom AS nomFormateur,
                f.prenom,
                f.img AS imgFormateur,
                c.id_categorie,
                c.nom AS nomCategorie,
                l.id_langue,
                l.nom AS nomLangue,
                n.id_niveau,
                n.nom AS nomNiveau
            FROM formations fore
            JOIN formateurs f ON fore.id_formateur = f.id_formateur
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN langues l ON fore.id_langue = l.id_langue
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            WHERE fore.etat = 'public'
            AND fore.nom LIKE CONCAT('%', :q, '%')
        ");

        $query->bindParam(":nom", $nom);
        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function find($id)
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
                niveaux.nom AS nomNiveau,
                niveaux.icon AS iconNiveau
            FROM formations, formateurs, categories, langues, niveaux
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.id_categorie
            AND formations.id_langue = langues.id_langue
            AND formations.id_niveau = niveaux.id_niveau
            AND formations.id_formation = :id
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        $formation = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formation;
        }
        return false;
    }

    public function getPublic($offset = 0)
    {
        $query = $this->connect->prepare("
            SELECT
                fore.id_formation,
                image AS imgFormation,
                mass_horaire,
                fore.nom AS nomFormation,
                fore.date_creation,
                prix,
                description,
                jaimes,
                description,
                f.id_formateur,
                f.nom AS nomFormateur,
                f.prenom,
                f.img AS imgFormateur,
                c.id_categorie,
                c.nom AS nomCategorie,
                l.id_langue,
                l.nom AS nomLangue,
                n.id_niveau,
                n.nom AS nomNiveau
            FROM formations fore
            JOIN formateurs f ON fore.id_formateur = f.id_formateur
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN langues l ON fore.id_langue = l.id_langue
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            WHERE fore.etat = 'public'
            ORDER BY fore.jaimes DESC
            LIMIT {$offset}, 10
        ");

        $query->execute();
        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function all()
    {
        $query = $this->connect->prepare("
            SELECT
                fore.id_formation,
                image AS imgFormation,
                mass_horaire,
                fore.nom AS nomFormation,
                fore.date_creation,
                prix,
                description,
                jaimes,
                description,
                f.id_formateur,
                f.nom AS nomFormateur,
                f.prenom,
                f.img AS imgFormateur,
                c.id_categorie,
                c.nom AS nomCategorie,
                l.id_langue,
                l.nom AS nomLangue,
                n.id_niveau,
                n.nom AS nomNiveau
            FROM formations fore
            JOIN formateurs f ON fore.id_formateur = f.id_formateur
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN langues l ON fore.id_langue = l.id_langue
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
        ");

        $query->execute();
        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsFilter($categorie, $q)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(id_formation) AS numbFormations
            FROM formations, categories
            WHERE categories.id_categorie = formations.id_categorie
            AND categories.nom = :categorie
            AND formations.etat = 'public'
            AND (
                formations.nom LIKE '%:q%' 
                OR formations.description LIKE '%:q%'
            );
        ");

        $query->bindParam(":categorie", $categorie);
        $query->bindParam(":q", $q);
        $query->execute();

        $numbFormations = $query->fetch(\PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getFormationsByFilter($categorie, $q, $offset)
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
                formations.nom LIKE '%:q%' 
                OR formations.description LIKE '%:q%'
            )
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":categorie", $categorie);
        $query->bindParam(":q", $q);
        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFormationsSearched($q)
    {

        $query = $this->connect->prepare("
            SELECT 
                COUNT(formations.id_formation) AS numbFormations
            FROM formations, formateurs, categories
            WHERE formations.id_formateur = formateurs.id_formateur
            AND categories.id_categorie = formations.id_categorie
            AND formations.etat = 'public'
            AND (
                categories.nom LIKE '%:q%'
                OR formateurs.nom LIKE '%:q%'
                OR formations.description LIKE '%:q%'
                OR formations.nom LIKE '%:q%'
                OR formateurs.prenom LIKE '%:q%'
            )
        ");

        $query->bindParam(":q", $q);
        $query->execute();

        $numbFormations = $query->fetch(\PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getFormationsSearched($q, $offset)
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
            AND (
                categories.nom LIKE '%:q%'
                OR formateurs.nom LIKE '%:q%'
                OR formations.description LIKE '%:q%'
                OR formations.nom LIKE '%:q%'
                OR formateurs.prenom LIKE '%:q%'
            )
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":q", $q);
        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function mostLiked($offset)
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
        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function mostBought($offset)
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
            LIMIT  {$offset}, 10
        ");

        $query->execute();
        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countByLangue($id)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(id_formation) AS numbFormations
            FROM formations
            WHERE id_langue = :id
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        $numbFormations = $query->fetch(\PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getByLangue($id, $offset)
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
            WHERE id_langue = :id          
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countByNiveau($id)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(id_formation) AS numbFormations
            FROM formations
            WHERE id_niveau = :id
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        $numbFormations = $query->fetch(\PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getByNiveau($id, $offset)
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
            WHERE id_niveau = :id
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countByDuration($debut, $fin)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(id_formation) AS numbFormations
            FROM formations
            WHERE mass_horaire 
            BETWEEN TIME(CONCAT('0', :debut, ':00:00')) 
            AND TIME(CONCAT('0', :fin, ':00:00'))
        ");

        $query->bindParam(":debut", $debut);
        $query->bindParam(":fin", $fin);
        $query->execute();

        $numbFormations = $query->fetch(\PDO::FETCH_OBJ)->numbFormations;
        if ($query->rowCount() > 0) {
            return $numbFormations;
        }
        return 0;
    }

    public function getByDuration($debut, $fin, $offset)
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
            BETWEEN TIME(CONCAT('0', :debut, ':00:00')) 
            AND TIME(CONCAT('0', :fin, ':00:00'))
            LIMIT {$offset}, 10
        ");

        $query->bindParam(":debut", $debut);
        $query->bindParam(":fin", $fin);
        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function updateFile($formation)
    {
        $query = $this->connect->prepare("
            UPDATE formations 
            SET fichier_attache = :filePath
            WHERE id_formation = :id
        ");

        $query->execute([
            'filePath' => $formation['path'], 
            'id' => $formation['id']
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function updateImage($formation)
    {
        $query = $this->connect->prepare("
            UPDATE formations 
            SET image = :filePath
            WHERE id_formation = :id
        ");

        $query->execute([
            'filePath' => $formation['path'], 
            'id' => $formation['id']
        ]);

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function join($code)
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

        $query->execute([
            'code' => htmlspecialchars($code)
        ]);

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);

        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function whereSlug($slug)
    {
        $query = $this->connect->prepare("
            SELECT 
                f.id_formation,
                f.image AS imgFormation,
                DATE_FORMAT(f.mass_horaire, '%H:%i') AS mass_horaire,
                cf.nom AS nomCategorieFormation,
                f.nom AS nomFormation,
                f.prix,
                f.description,
                f.jaimes,
                fo.id_formateur,
                fo.nom AS nomFormateur,
                fo.prenom,
                fo.slug AS slugFormateur,
                cf_formateurs.nom AS nomCategorieFormateur,
                fo.img AS imgFormateur,
                DATE(f.date_creation) AS date_creation,
                f.id_niveau AS niveau,
                f.id_langue AS langue,
                l.nom AS nomLangue,
                n.nom AS nomNiveau,
                n.icon AS iconNiveau
            FROM formations f
            JOIN formateurs fo ON f.id_formateur = fo.id_formateur
            JOIN categories cf ON cf.id_categorie = f.id_categorie
            JOIN categories cf_formateurs ON cf_formateurs.id_categorie = fo.id_categorie
            JOIN langues l ON f.id_langue = l.id_langue
            JOIN niveaux n ON f.id_niveau = n.id_niveau
            WHERE f.slug = :slug
        ");

        $query->bindParam(":slug", $slug);
        $query->execute();

        $formation = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formation;
        }
        return false;
    }

    public function filter($filter, $offset = 1, $sort)
    {
        $query = $this->connect->prepare("
            SELECT
                fore.id_formation,
                fore.slug,
                fore.image AS imgFormation,
                mass_horaire,
                fore.nom AS nomFormation,
                fore.date_creation,
                prix,
                jaimes,
                description,
                f.id_formateur,
                f.nom AS nomFormateur,
                f.prenom,
                f.img AS imgFormateur,
                c.id_categorie,
                c.nom AS nomCategorie,
                l.id_langue,
                l.nom AS nomLangue,
                n.id_niveau,
                n.nom AS nomNiveau,
                n.icon AS iconNiveau,
                insc.total_inscriptions
            FROM formations fore
            JOIN formateurs f ON fore.id_formateur = f.id_formateur
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN langues l ON fore.id_langue = l.id_langue
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            LEFT JOIN (
                SELECT
                    f.id_formation,
                    COUNT(i.id_formation) AS total_inscriptions
                FROM formations f
                LEFT JOIN inscriptions i ON f.id_formation = i.id_formation
                GROUP BY f.id_formation
            ) AS insc ON fore.id_formation = insc.id_formation
            WHERE fore.etat = 'public'
            {$filter}
            ORDER BY insc.total_inscriptions {$sort} DESC
            LIMIT {$offset}, 10
        ");

        $query->execute();

        $formations = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formations;
        }
        return [];
    }

    public function countFiltred($filter)
    {
        $query = $this->connect->prepare("
            SELECT
                COUNT(fore.id_formation) AS total_filtred
            FROM formations fore
            JOIN formateurs f ON fore.id_formateur = f.id_formateur
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN langues l ON fore.id_langue = l.id_langue
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            WHERE fore.etat = 'public'
            {$filter}
        ");

        $query->execute();

        $response = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $response->total_filtred;
        }
        return [];
    }

    public function groupByCategorie()
    {
        $query = $this->connect->prepare("
            SELECT
                c.nom,
                COALESCE(COUNT(f.id_categorie), 0) AS total_formations
            FROM categories c
            LEFT JOIN formations f USING (id_categorie)
            WHERE COALESCE(f.etat, 'public') = 'public'
            GROUP BY c.id_categorie, c.nom
        ");

        $query->execute();

        $categories = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $categories;
        }
        return [];
    }

    public function groupByLangue()
    {
        $query = $this->connect->prepare("
            SELECT
                l.nom,
                COALESCE(COUNT(f.id_langue), 0) AS total_formations
            FROM langues l
            LEFT JOIN formations f USING (id_langue)
            WHERE COALESCE(f.etat, 'public') = 'public'
            GROUP BY l.id_langue, l.nom
        ");

        $query->execute();

        $categories = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $categories;
        }
        return [];
    }

    public function groupByNiveau()
    {
        $query = $this->connect->prepare("
            SELECT
                n.nom,
                COALESCE(COUNT(f.id_niveau), 0) AS total_formations
            FROM niveaux n
            LEFT JOIN formations f USING (id_niveau)
            WHERE COALESCE(f.etat, 'public') = 'public'
            GROUP BY n.id_niveau, n.nom
        ");

        $query->execute();

        $categories = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $categories;
        }
        return [];
    }

    public function groupByDuration()
    {
        $query = $this->connect->prepare("
            CALL group_formation_by_duration()
        ");

        $query->execute();

        $categories = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $categories;
        }
        return [];
    }
}     
