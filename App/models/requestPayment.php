<?php

/**
 * class requestPayment
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
}
