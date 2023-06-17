<?php

/**
 * Model requestPayment
 */

class requestPayment
{
    private $connect;

    public function __construct($database)
    {
        $this->connect = $database;
    }

    public function getRequestsPaymentsByState($etat)
    {
        $query = $this->connect->prepare("
            SELECT 
                id_payment,
                id_formateur,
                request_prix,
                date_request,
                etat_request,
                nom_formateur,
                prenom_formateur,
                paypalMail,
                img_formateur
            FROM request_payment
            JOIN formateurs USING (id_formateur)
            WHERE etat_request = :etat_request
        ");
        $query->bindParam(':etat_request', $etat);
        $query->execute();
        $queryPayments = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $queryPayments;
        }
        return [];
    }

    public function setState($etat_request, $id_payment)
    {
        $query = $this->connect->prepare("
            UPDATE request_payment 
            SET etat_request = :etat_request
            WHERE id_payment = :id_payment
        ");

        $etat_request = htmlspecialchars($etat_request);
        $id_payment = htmlspecialchars($id_payment);
        $query->bindParam(":etat_request", $etat_request);
        $query->bindParam(":id_payment", $id_payment);
        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function insertRequestPayment($id_formateur, $request_prix)
    {
        $query = $this->connect->prepare("
            INSERT INTO request_payment(id_formateur, request_prix)	VALUES (:id_formateur, :request_prix)
        ");

        $query->bindParam(':id_formateur', $id_formateur);
        $query->bindParam(':request_prix', $request_prix);
        $query->execute();
        $lastInsertId = $this->connect->lastInsertId();
        if ($lastInsertId > 0) {
            return $lastInsertId;
        }
        return false;
    }

    public function getRequestsOfFormateur($id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT *
            FROM request_payment
            WHERE id_formateur = :id_formateur
        ");

        $query->bindParam(':id_formateur', $id_formateur);
        $query->execute();
        $queryPayments = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $queryPayments;
        }
        return [];
    }

    public function deleteRequest($id_req)
    {
        $query = $this->connect->prepare("
            DELETE FROM request_payment 
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
