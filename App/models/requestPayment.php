<?php

/**
 * Model queryPayment
 */

class queryPayment
{
    private $connect;

    public function __construct($database)
    {
        $this->connect = $database;
    }

    public function getquerysPaymentsByState($etat)
    {
        $query = $this->connect->prepare("
            SELECT 
                id_payment,
                id_formateur,
                query_prix,
                date_query,
                etat_query,
                nom_formateur,
                prenom_formateur,
                paypalMail,
                img_formateur
            FROM query_payment
            JOIN formateurs USING (id_formateur)
            WHERE etat_query = :etat_query
        ");
        $query->bindParam(':etat_query', $etat);
        $query->execute();
        $queryPayments = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $queryPayments;
        }
        return false;
    }

    public function setState($etat_query, $id_payment)
    {
        $query = $this->connect->prepare("
            UPDATE query_payment 
            SET etat_query = :etat_query
            WHERE id_payment = :id_payment
        ");

        $etat_query = htmlspecialchars($etat_query);
        $id_payment = htmlspecialchars($id_payment);
        $query->bindParam(":etat_query", $etat_query);
        $query->bindParam(":id_payment", $id_payment);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function insertqueryPayment($id_formateur, $query_prix)
    {
        $query = $this->connect->prepare("
            INSERT INTO query_payment(id_formateur, query_prix)	VALUES (:id_formateur, :query_prix)
        ");

        $query->bindParam(':id_formateur', $id_formateur);
        $query->bindParam(':query_prix', $query_prix);
        $query->execute();
        $lastInsertId = $this->connect->lastInsertId();
        if ($lastInsertId > 0) {
            return $lastInsertId;
        }
        return false;
    }

    public function getquerysOfFormateur($id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT *
            FROM query_payment
            WHERE id_formateur = :id_formateur
        ");

        $query->bindParam(':id_formateur', $id_formateur);
        $query->execute();
        $queryPayments = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $queryPayments;
        }
        return false;
    }

    public function deletequery($id_req)
    {
        $query = $this->connect->prepare("
            DELETE FROM query_payment 
            WHERE id_payment = :id_req
        ");

        $query->bindParam(":id_req", $id_req);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
