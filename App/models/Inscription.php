<?php

/**
 *  Model Inscription
 */

namespace App\Models;

use App\Libraries\Database;

class Inscription
{
    private $connect;

    public function __construct()
    {
        $this->connect = Database::getConnection();
    }

    public function create($inscription)
    {
        $query = $this->connect->prepare("
            INSERT INTO inscriptions(id_formation, id_etudiant, id_formateur, date_inscription, prix, transaction_info, payment_id, payment_state, approval_url) VALUES (:id_formation, :id_etudiant, :id_formateur, :date_inscription, :prix, :transaction_info, :payment_id, :payment_state, :approval_url)
        ");

        $query->bindParam(':id_formation', $inscription['id_formation']);
        $query->bindParam(':id_etudiant', $inscription['id_etudiant']);
        $query->bindParam(':id_formateur', $inscription['id_formateur']);
        $query->bindParam(':prix', $inscription['prix']);
        $query->bindParam(':transaction_info', $inscription['transaction_info']);
        $query->bindParam(':payment_id', $inscription['payment_id']);
        $query->bindParam(':payment_state', $inscription['payment_state']);
        $query->bindParam(':date_inscription', $inscription['date_inscription']);
        $query->bindParam(':approval_url', $inscription['approval_url']);
        $query->execute();

        $lastInsertId = $this->connect->lastInsertId();
        if ($lastInsertId > 0) {
            return $lastInsertId;
        }
        return false;
    }

    public function countApprenantsOfFormation($id_formateur, $id_formation)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(*) AS total_apprenants 
            FROM inscriptions 
            WHERE id_formateur = :id_formateur 
            AND id_formation = :id_formation 
            AND payment_state = 'approved'
        ");

        $query->bindParam(":id_formateur", $id_formateur);
        $query->bindParam(":id_formation", $id_formation);
        $query->execute();

        $total_apprenants = $query->fetch(\PDO::FETCH_OBJ)->total_apprenants;
        if ($query->rowCount() > 0) {
            return $total_apprenants;
        }
        return 0;
    }

    public function delete($id)
    {
        $query = $this->connect->prepare("
            DELETE FROM inscriptions
		    WHERE id_inscription = :id
        ");

        $query->bindParam(':id', $id);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function countInscriptionsOfEtudiant($id)
    {
        $query = $this->connect->prepare("
            SELECT 
                COUNT(*) AS total_inscription
            FROM inscriptions
            WHERE id_etudiant = :id
        ");

        $query->bindParam(':id', $id);
        $query->execute();

        $response = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $response->total_inscription;
        }
        return false;
    }

    public function getInscriptionsOfEtudiant($id)
    {
        $query = $this->connect->prepare("
            SELECT 
                i.id_formation,
                i.id_formateur,
                i.id_etudiant,
                mass_horaire,
                image,
                c.nom AS nomCategorie,
                fore.prix,
                fore.nom AS nomFormation,
                description,
                f.img AS imgFormateur,
                f.nom AS nomFormateur,
                f.prenom AS prenomFormateur,
                jaimes
            FROM inscriptions i
            JOIN etudiants e ON i.id_etudiant = e.id_etudiant
            JOIN formateurs f ON i.id_formateur = f.id_formateur
            JOIN formations fore ON i.id_formation = fore.id_formation
            JOIN categories c ON fore.id_categorie = c.id_categorie
            WHERE e.id_etudiant=:id AND payment_state = 'approved'
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        $inscriptions = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $inscriptions;
        }
        return [];
    }

    public function getInscriptionOfOneFormation($id_formation, $id_etudiant, $id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT
                f.id_formateur,
                f.nom AS nomFormateur,
                f.prenom AS prenomFormateur,
                f.img AS imgFormateur,
                f.id_categorie AS formateurCategorie,
                fo.id_formation,
                fo.nom AS nomFormation, 
                fo.id_categorie AS formationCategorie,
                mass_horaire,
                image,
                fichier_attache,
                jaimes,
                e.id_etudiant,
                e.nom AS nomEtudiant,
                e.prenom AS prenomEtudiant,
                e.img AS imgEtudiant,
                id_langue AS langue,
                id_niveau AS niveau
            FROM inscriptions i
            JOIN etudiants e USING(id_etudiant)
            JOIN formateurs f USING(id_formateur)
            JOIN formations fo USING(id_formation)
            WHERE i.id_formation = :id_formation 
            AND i.id_etudiant = :id_etudiant 
            AND i.id_formateur = :id_formateur
            AND i.payment_state = 'approved'
        ");
        $query->bindParam(':id_formation', $id_formation);
        $query->bindParam(':id_etudiant', $id_etudiant);
        $query->bindParam(':id_formateur', $id_formateur);
        $query->execute();

        $inscription = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $inscription;
        }
        return false;
    }

    public function getFormationsOfStudent($id_etudiant)
    {
        $query = $this->connect->prepare("
            SELECT
                id_inscription, 
                f.nom AS nomFormateur,
                f.prenom AS prenomFormateur,
                f.img AS imgFormateur,
                formations.nom AS nomFormation,
                date_inscription,
                e.nom AS nomEtudiant,
                e.prenom AS prenomEtudiant,
                id_formation
            FROM inscriptions i
            JOIN formations USING (id_formation)
            JOIN etudiants e USING (id_etudiant)
            JOIN formateurs f ON i.id_formateur = f.id_formateur
            WHERE id_etudiant = :id_etudiant
            AND payment_state = 'approved'
        ");

        $query->bindParam(":id_etudiant", $id_etudiant);
        $query->execute();

        $inscriptions = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $inscriptions;
        }
        return [];
    }

    //================ For Paypal Payment and Validation ==================

    public function checkIfAlready($idEtudiant, $idFormation)
    {
        $query = $this->connect->prepare("
            SELECT 
                payment_state,
                approval_url
            FROM inscriptions 
            WHERE id_etudiant = :id_etudiant
            AND id_formation = :id_formation
        ");

        $query->bindParam(':id_etudiant', $idEtudiant);
        $query->bindParam(':id_formation', $idFormation);
        $query->execute();

        $inscriptions = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $inscriptions;
        }
        return false;
    }

    public function getInscriptionByPaymentID($paymentID)
    {
        $query = $this->connect->prepare("
            SELECT * 
            FROM inscriptions
            WHERE payment_id = :payment_id
        ");

        $query->bindParam(":payment_id", $paymentID);
        $query->execute();

        $inscription = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $inscription;
        }
        return false;
    }

    public function updateInscriptionByPaymentID($paymentID, $paymentState)
    {
        $query = $this->connect->prepare("
            UPDATE inscriptions
            SET payment_state = :payment_state
            WHERE payment_id = :payment_id
        ");

        $query->bindParam(":payment_id", $paymentID);
        $query->bindParam(":payment_state", $paymentState);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function getTotalApprenantsParJour($idFormateur)
    {
        $query = $this->connect->prepare("
            SELECT 
                DATE(date_inscription) AS date_inscription,
                COUNT(*) AS inscriptions,
                SUM(prix) AS totalRevenue
            FROM inscriptions 
            WHERE id_formateur = :id_formateur
            GROUP BY DATE(date_inscription)
        ");

        $query->bindParam(":id_formateur", $idFormateur);
        $query->execute();

        $inscriptions = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $inscriptions;
        }
        return [];
    }

    public function top5BestSellersTodayOrYesterday($periode)
    {
        switch ($periode) {
            case 'today':
                $periode = date('Y-m-d');
                break;
            case 'yesterday':
                $periode = date('Y-m-d', strtotime("-1 days"));
                break;
            default:
                exit;
                break;
        }

        $query = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom, ' ', f.prenom) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE DATE(i.date_inscription) = :periode
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $query->execute(['periode' => $periode]);
        $formateurs = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formateurs;
        }
        return [];
    }

    public function top5BestSellersLastWeek()
    {
        $query = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom, ' ', f.prenom) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE YEARWEEK(i.date_inscription, 1) = YEARWEEK( CURDATE() - INTERVAL 1 WEEK, 1)
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $query->execute();
        $formateurs = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formateurs;
        }
        return [];
    }

    public function top5BestSellersLastMonth()
    {
        $query = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom, ' ', f.prenom) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE MONTH(i.date_inscription) = MONTH(NOW()) - 1
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $query->execute();
        $formateurs = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formateurs;
        }
        return [];
    }

    public function top5BestSellersLast3Months()
    {
        $query = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom, ' ', f.prenom) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE MONTH(i.date_inscription) = MONTH(NOW()) - 1
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $query->execute();
        $formateurs = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formateurs;
        }
        return [];
    }
    
    public function top5BestSellersLastYear()
    {
        $query = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom, ' ', f.prenom) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE YEAR(i.date_inscription) = YEAR(NOW() - INTERVAL 1 YEAR)
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $query->execute();
        $formateurs = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formateurs;
        }
        return [];
    }

    public function top5BestSellersBetween2Days($debut, $fin)
    {
        $query = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom, ' ', f.prenom) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE i.date_inscription BETWEEN :debut AND :fin
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $query->execute(['debut' => $debut, 'fin' => $fin]);
        $formateurs = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formateurs;
        }
        return [];
    }
}
