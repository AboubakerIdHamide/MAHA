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
        $request = $this->connect->prepare("
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
        $request->bindParam(':etat_request', $etat);
        $request->execute();
        $requestPayments = $request->fetchAll(PDO::FETCH_OBJ);
        return $requestPayments;
    }

    public function setState($etat_request, $id_payment)
    {
        $request = $this->connect->prepare("
            UPDATE request_payment 
            SET etat_request = :etat_request
            WHERE id_payment = :id_payment
        ");

        $etat_request = htmlspecialchars($etat_request);
        $id_payment = htmlspecialchars($id_payment);
        $request->bindParam(":etat_request", $etat_request);
        $request->bindParam(":id_payment", $id_payment);

        $response = $request->execute();
        return $response;
    }

    public function insertRequestPayment($id_formateur, $request_prix)
    {
        $request = $this->connect->prepare("
            INSERT INTO request_payment(id_formateur, request_prix)	
			VALUES (:id_formateur, :request_prix)
        ");

        $request->bindParam(':id_formateur', $id_formateur);
        $request->bindParam(':request_prix', $request_prix);
        $response = $request->execute();
        return $response;
    }

    public function getRequestsOfFormateur($id_formateur)
    {
        $request = $this->connect->prepare("
            SELECT 
                *
            FROM request_payment
            WHERE id_formateur = :id_formateur
        ");
        $request->bindParam(':id_formateur', $id_formateur);
        $request->execute();
        $requestPayments = $request->fetchAll(PDO::FETCH_OBJ);
        return $requestPayments;
    }

    public function deleteRequest($id_req)
    {
        $request = $this->connect->prepare("
            DELETE FROM request_payment 
            WHERE id_payment = :id_req
        ");

        $request->bindParam(":id_req", $id_req);
        $response = $request->execute();
        return $response;
    }
}
