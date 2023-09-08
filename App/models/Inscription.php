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
            FROM inscriptions i
            JOIN formations AS f ON i.id_formation = f.id_formation
            WHERE i.id_formateur = :id_formateur 
            AND i.id_formation = :id_formation 
            AND payment_state = 'approved' AND etat = 'public'
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

    public function getFormationsOfEtudiant($offset, $numberRecordsPerPage, $id)
    {
        $query = $this->connect->prepare("
            SELECT 
                i.id_formation,
                mass_horaire,
                fore.image,
                c.nom AS nomCategorie,
                fore.nom AS nomFormation,
                description,
                jaimes,
                n.nom AS nomNiveau,
                l.nom AS nomLangue
            FROM inscriptions i
            JOIN formations fore ON i.id_formation = fore.id_formation
            JOIN categories c ON fore.id_categorie = c.id_categorie
            JOIN langues l ON fore.id_langue = l.id_langue
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            WHERE id_etudiant = :id AND payment_state = 'approved'
            LIMIT {$offset}, {$numberRecordsPerPage}
        ");

        $query->bindParam(":id", $id);
        $query->execute();

        $inscriptions = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $inscriptions;
        }
        return [];
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
            return true;
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

    public function getLast7DaysRevenus($id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT
                DATE_FORMAT(date_list.date_to_check, '%d/%m') AS date_inscription,
                IFNULL(TRUNCATE(SUM(i.prix), 2), 0) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM (
                SELECT CURDATE() - INTERVAL n DAY AS date_to_check
                FROM (
                    SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2
                    UNION ALL SELECT 3 UNION ALL SELECT 4
                    UNION ALL SELECT 5 UNION ALL SELECT 6
                ) numbers
                WHERE n BETWEEN 0 AND 6
            ) date_list
            LEFT JOIN (
                SELECT 
                    id_formateur,
                    id_formation,
                    prix,
                    DATE(date_inscription) AS date_inscription
                FROM inscriptions
                WHERE id_formateur = :id_formateur
            ) AS i ON date_list.date_to_check = i.date_inscription
            GROUP BY date_list.date_to_check
            ORDER BY date_list.date_to_check
        ");

        $query->execute(['id_formateur' => $id_formateur]);
        $inscriptions = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            $earning = [];
            $last7Days = [];

            foreach ($inscriptions as $inscription) {
                array_push($earning, $inscription->montantTotal);
                array_push($last7Days, $inscription->date_inscription);
            }

            return [
                "earning" => $earning,
                "last7Days" => $last7Days
            ];
        }
        return [];
    }

    public function getTransactions($id_formateur, $offset = 0, $sort = 'date_inscription DESC', $filter = '')
    {
        $query = $this->connect->prepare("
            SELECT
                nom,
                i.id_formation,
                UPPER(DATE_FORMAT(date_inscription, '%d %b %Y')) AS date_inscription,
                i.prix,
                id_inscription,
                image
            FROM inscriptions i
            JOIN formations AS f USING(id_formation)
            WHERE i.id_formateur = :id_formateur 
            AND payment_state = 'approved'
            {$filter}
            ORDER BY {$sort}
            LIMIT {$offset}, 4
        ");

        $query->execute(['id_formateur' => $id_formateur]);
        $transactions = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $transactions;
        }
        return [];
    }

    public function countTransactionsOfFormateur($id_formateur, $filter)
    {
        $query = $this->connect->prepare("
            SELECT
                COUNT(i.id_formation) AS totalTransations
            FROM inscriptions i
            JOIN formations AS f USING(id_formation)
            WHERE i.id_formateur = :id_formateur AND payment_state = 'approved'
            {$filter}
        ");

        $query->execute(['id_formateur' => $id_formateur]);
        $total = $query->fetch(\PDO::FETCH_OBJ)->totalTransations;
        if ($query->rowCount() > 0) {
            return $total; 
        }
        return 0;
    }

    public function getSalesToday($id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT
                nom,
                i.id_formation,
                COUNT(i.id_formation) AS numberSales
            FROM inscriptions i
            JOIN formations AS f USING(id_formation)
            WHERE i.id_formateur = :id_formateur AND DATE(date_inscription) = CURDATE()
            GROUP BY id_formation
            ORDER BY numberSales DESC
        ");

        $query->execute(['id_formateur' => $id_formateur]);
        $sales = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $sales;
        }
        return [];
    }

    public function getEarningsThisYear($id_formateur, $year)
    {
        $query = $this->connect->prepare("
            SELECT
                MONTHNAME(date_list.date_to_check) AS mois,
                IFNULL(TRUNCATE(SUM(i.prix), 2), 0) AS montantTotal
            FROM (
                SELECT 
                    :fist_year_day + INTERVAL n MONTH AS date_to_check
                FROM (
                  SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2
                  UNION ALL SELECT 3 UNION ALL SELECT 4
                  UNION ALL SELECT 5 UNION ALL SELECT 6
                  UNION ALL SELECT 7 UNION ALL SELECT 8
                  UNION ALL SELECT 9 UNION ALL SELECT 10
                  UNION ALL SELECT 11
                ) numbers
                WHERE n BETWEEN 0 AND 11
            ) date_list
            LEFT JOIN (
                SELECT 
                    prix,
                    date_inscription
                FROM inscriptions
                WHERE id_formateur = :id_formateur
            ) AS i ON DATE_FORMAT(date_list.date_to_check, '%Y-%m') = DATE_FORMAT(i.date_inscription, '%Y-%m')
            GROUP BY date_list.date_to_check
        ");

        $query->execute([
            'fist_year_day' => $year,
            'id_formateur' => $id_formateur
        ]);

        $earnings = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            $revenus = [];
            $months = [];

            foreach ($earnings as $earning) {
                array_push($months, $earning->mois);
                array_push($revenus, $earning->montantTotal);
            }

            return [
                'earning' => $revenus,
                'months' => $months
            ];
        }
        return [];
    }

    public function countAllCoursesThatHaveSubscribers($id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT
                COUNT(DISTINCT id_formation) AS totalFormations
            FROM inscriptions 
            WHERE id_formateur = :id_formateur
            GROUP BY id_formateur
        ");

        $query->execute(['id_formateur' => $id_formateur]);
        $total = $query->fetch(\PDO::FETCH_OBJ)->totalFormations;
        if ($query->rowCount() > 0) {
            return $total; 
        }
        return 0;
    }

    public function getSalesOfAllTime($id_formateur, $offset = 0)
    {
        $query = $this->connect->prepare("
            SELECT
                i.id_formation,
                nom,
                image,
                COUNT(i.id_formation) AS sales,
                TRUNCATE(SUM(i.prix), 2) AS revenue,
                TRUNCATE(SUM(i.prix) * (SELECT platform_pourcentage FROM admins) / 100, 2) AS fees
            FROM inscriptions i
            JOIN formations AS f USING(id_formation)
            WHERE i.id_formateur = :id_formateur
            GROUP BY id_formation
            ORDER BY sales DESC
            LIMIT {$offset}, 4
        ");

        $query->execute(['id_formateur' => $id_formateur]);
        $sales = $query->fetchAll(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $sales;
        }
        return [];
    }

    public function getTotalRevenueFormateur($id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT
                TRUNCATE(SUM(prix), 2) AS totalRevenue
            FROM inscriptions 
            WHERE id_formateur = :id_formateur
        ");

        $query->execute(['id_formateur' => $id_formateur]);
        $total = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $total;
        }
        return 0;
    }

    public function getMyCourse($id_etudiant, $id_formation)
    {
        $query = $this->connect->prepare("
            SELECT
                fore.id_formation,
                fore.image,
                fore.nom AS nomFormation,
                IF(TIME_FORMAT(mass_horaire, '%H') > 0, 
                    CONCAT(TIME_FORMAT(mass_horaire, '%H'), 'H ', TIME_FORMAT(mass_horaire, '%i'), 'Min'), 
                    TIME_FORMAT(mass_horaire, '%iMin')
                ) AS mass_horaire,
                fichier_attache,
                description,
                f.img AS imgFormateur,
                f.nom AS nomFormateur,
                f.prenom AS prenomFormateur,
                jaimes,
                n.nom AS nomNiveau,
                a.id_video,
                j.id_etudiant AS isLiked
            FROM inscriptions i
            JOIN formateurs f ON i.id_formateur = f.id_formateur
            JOIN formations fore ON i.id_formation = fore.id_formation
            JOIN niveaux n ON fore.id_niveau = n.id_niveau
            JOIN apercus a ON i.id_formation = a.id_formation
            LEFT JOIN jaimes j ON i.id_etudiant = j.id_etudiant AND i.id_formation = j.id_formation
            WHERE i.id_etudiant = :id_etudiant
            AND payment_state = 'approved'
            AND i.id_formation = :id_formation
        ");

        $query->execute([
            'id_etudiant' => $id_etudiant,
            'id_formation' => $id_formation
        ]);

        $formation = $query->fetch(\PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $formation;
        }
        return false;
    }
}
