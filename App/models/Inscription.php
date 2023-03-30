<?php

// class Inscription

class Inscription
{
    private $connect;

    public function __construct($database)
    {
        $this->connect = $database;
    }

    public function insertInscription($dataInscription)
    {
        $request = $this->connect->prepare(
            "INSERT INTO 
            inscriptions(id_formation, id_etudiant, id_formateur, date_inscription, prix, transaction_info, payment_id, payment_state, approval_url) 
            VALUES (:id_formation, :id_etudiant, :id_formateur, :date_inscription, :prix, :transaction_info, :payment_id, :payment_state, :approval_url)"
        );

        $request->bindParam(':id_formation', $dataInscription['id_formation']);
        $request->bindParam(':id_etudiant', $dataInscription['id_etudiant']);
        $request->bindParam(':id_formateur', $dataInscription['id_formateur']);
        $request->bindParam(':prix', $dataInscription['prix']);
        $request->bindParam(':transaction_info', $dataInscription['transaction_info']);
        $request->bindParam(':payment_id', $dataInscription['payment_id']);
        $request->bindParam(':payment_state', $dataInscription['payment_state']);
        $request->bindParam(':date_inscription', $dataInscription['date_inscription']);
        $request->bindParam(':approval_url', $dataInscription['approval_url']);
        $response = $request->execute();

        return $response;
    }

    public function getInscription($id_formation, $id_etudiant, $id_formateur)
    {
        $request = $this->connect->prepare("SELECT * FROM inscriptions WHERE id_formation = :id_formation and id_etudiant = :id_etudiant and id_formateur = :id_formateur and payment_state != 'created'");
        $request->bindParam(':id_formation', $id_formation);
        $request->bindParam(':id_etudiant', $id_formation);
        $request->bindParam(':id_formateur', $id_formation);
        $request->execute();
        $etudiant = $request->fetch();
        return $etudiant;
    }

    public function countApprenantsOfFormation($id_formateur, $id_formation)
    {
        $request = $this->connect->prepare("
            SELECT COUNT(*) AS total_apprenants FROM inscriptions 
            WHERE id_formateur = :id_formateur 
            AND id_formation = :id_formation and payment_state != 'created'
        ");
        $request->bindParam(":id_formateur", $id_formateur);
        $request->bindParam(":id_formation", $id_formation);
        $request->execute();
        $response = $request->fetch();
        return $response;
    }

    // public function getApprenantsByFormateur($id_formateur)
    // {
    //     $request = $this->connect->prepare("
    //         SELECT COUNT(*) AS total_apprenants FROM inscriptions 
    //         WHERE id_formateur = :id_formateur
    //     ");
    //     $request->bindParam(':id_formateur', $id_formateur);
    //     $request->execute();
    //     $data = $request->fetch(PDO::FETCH_OBJ);
    //     return $data;
    // }

    public function deteleInscription($id_inscription)
    {
        $request = $this->connect->prepare("
            DELETE FROM inscriptions
		    WHERE id_inscription = :id_inscription
        ");
        $request->bindParam(':id_inscription', $id_inscription);
        $response = $request->execute();
        return $response;
    }

    public function getInscriptionByEtudiant($idEtudiant)
    {
        $request = $this->connect->prepare("
            SELECT * FROM inscriptions
            JOIN etudiants e USING(id_etudiant)
            JOIN formateurs USING(id_formateur)
            JOIN formations USING(id_formation)
            WHERE e.id_etudiant=:id_etudiant and payment_state != 'created'
        ");
        $request->bindParam(":id_etudiant", $idEtudiant);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function getInscriptionOfOneFormation($id_formation, $id_etudiant, $id_formateur)
    {
        $request = $this->connect->prepare("
            SELECT * FROM inscriptions i
            JOIN etudiants  USING(id_etudiant)
            JOIN formateurs USING(id_formateur)
            JOIN formations USING(id_formation)
            WHERE i.id_formation = :id_formation 
            and i.id_etudiant = :id_etudiant 
            and i.id_formateur = :id_formateur
            and i.payment_state != 'created'
        ");
        $request->bindParam(':id_formation', $id_formation);
        $request->bindParam(':id_etudiant', $id_etudiant);
        $request->bindParam(':id_formateur', $id_formateur);
        $request->execute();
        $etudiant = $request->fetch(PDO::FETCH_OBJ);
        return $etudiant;
    }

    // public function deteleInscription($id_inscription)
    // {
    //     $request = $this->connect->prepare("
    //         DELETE FROM inscriptions
    // 	    WHERE id_inscription = :id_inscription
    //     ");

    //     $id_inscription = htmlspecialchars($id_inscription);
    //     $request->bindParam(':id_inscription', $id_inscription);
    //     $response = $request->execute();
    //     return $response;
    // }

    public function getFormationsOfStudent($id_etudiant)
    {
        $request = $this->connect->prepare("
            SELECT
                id_inscription, 
                nom_formateur,
                prenom_formateur,
                img_formateur,
                nom_formation,
                date_inscription,
                nom_etudiant,
                prenom_etudiant,
                id_formation
            FROM inscriptions i
            JOIN formations USING (id_formation)
            JOIN etudiants USING (id_etudiant)
            JOIN formateurs f ON i.id_formateur = f.id_formateur
            WHERE id_etudiant = :id_etudiant
            and payment_state != 'created'
        ");
        $request->bindParam(":id_etudiant", $id_etudiant);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    //================ For Paypal Payment and Validation ==================

    public function checkIfAlready($idEtudiant, $idFormation)
    {
        $request = $this->connect->prepare("
            SELECT * FROM inscriptions 
            WHERE id_etudiant = :id_etudiant
            AND id_formation = :id_formation
        ");

        $request->bindParam(':id_etudiant', $idEtudiant);
        $request->bindParam(':id_formation', $idFormation);
        $request->execute();
        $response = $request->fetch(PDO::FETCH_OBJ);
        return $response;
    }

    public function getInscriptionByPaymentID($paymentID)
    {
        $request = $this->connect->prepare("
            SELECT * FROM inscriptions
            WHERE payment_id = :payment_id
        ");


        $request->bindParam(":payment_id", $paymentID);
        $request->execute();
        $response = $request->fetch(PDO::FETCH_OBJ);
        return $response;
    }

    public function updateInscriptionByPaymentID($paymentID, $paymentState)
    {
        $request = $this->connect->prepare("
            UPDATE inscriptions
            SET payment_state = :payment_state
            WHERE payment_id = :payment_id
        ");
        $request->bindParam(":payment_id", $paymentID);
        $request->bindParam(":payment_state", $paymentState);
        $response = $request->execute();
        return $response;
    }

    public function getTotalApprenantsParJour($idFormateur)
    {
        $request = $this->connect->prepare("
            SELECT 
                DATE(date_inscription) AS dateInscription,
                COUNT(*) AS `inscriptions`,
                SUM(prix) AS totalRevenue
            FROM inscriptions 
            WHERE id_formateur = :id_formateur
            GROUP BY DATE(date_inscription)
        ");


        $request->bindParam(":id_formateur", $idFormateur);
        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function top5BestSellersTodayOrYesterday($periode)
    {
        switch ($periode) {
            case 'today':
                $periode = date('Y-m-d');
                break;
            case 'yesterday':
                $periode = date('Y-m-d',strtotime("-1 days"));
                break;
            default:
                exit;
                break;
        }

        $request = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom_formateur, ' ', f.prenom_formateur) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE DATE(i.date_inscription) = :periode
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $request->execute(['periode' => $periode]);
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function top5BestSellersLastWeek()
    {
        $request = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom_formateur, ' ', f.prenom_formateur) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE YEARWEEK(i.date_inscription, 1) = YEARWEEK( CURDATE() - INTERVAL 1 WEEK, 1)
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function top5BestSellersLastMonth()
    {
        $request = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom_formateur, ' ', f.prenom_formateur) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE MONTH(i.date_inscription) = MONTH(NOW()) - 1
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function top5BestSellersLast3Months()
    {
        $request = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom_formateur, ' ', f.prenom_formateur) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE MONTH(i.date_inscription) = MONTH(NOW()) - 1
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }
    public function top5BestSellersLastYear()
    {
        $request = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom_formateur, ' ', f.prenom_formateur) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE YEAR(i.date_inscription) = YEAR(NOW() - INTERVAL 1 YEAR)
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $request->execute();
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function top5BestSellersBetween2Days($debut, $fin)
    {
        $request = $this->connect->prepare("
            SELECT 
                CONCAT(f.nom_formateur, ' ', f.prenom_formateur) AS nomComplet,
                SUM(i.prix) AS montantTotal,
                COUNT(i.id_formation) AS nbrFormation
            FROM inscriptions i
            JOIN formateurs f USING (id_formateur)
            WHERE i.date_inscription BETWEEN :debut AND :fin
            GROUP BY i.id_formateur
            ORDER BY montantTotal DESC
            LIMIT 5
        ");

        $request->execute(['debut' => $debut, 'fin' => $fin]);
        $response = $request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }
}
