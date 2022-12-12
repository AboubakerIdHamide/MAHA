<?php

// class Inscription

class Inscription{
    private $connect;

    public function __construct($database){
        $this->connect = $database;
    }

    public function insertInscription($dataInscription){
        $request = $this->connect->prepare("INSERT INTO 
            inscriptions(id_formation, id_etudiant, id_formateur, date_inscription) 
            VALUES (:id_formation, :id_etudiant, :id_formateur)"
        );

        $request->bindParam(':id_formation', $dataInscription['id_formation']);
        $request->bindParam(':id_etudiant', $dataInscription['id_etudiant']);
        $request->bindParam(':id_formateur', $dataInscription['id_formateur']);
        $response = $request->execute();

        return $response;
    }
    
    public function getInscription($id_formation, $id_etudiant, $id_formateur){
        $request = $this->connect->prepare("SELECT * FROM inscriptions WHERE id_formation = :id_formation and id_etudiant = :id_etudiant and id_formateur = :id_formateur");
        $request->bindParam(':id_formation', $id_formation);
        $request->bindParam(':id_etudiant', $id_formation);
        $request->bindParam(':id_formateur', $id_formation);
        $request->execute();
        $etudiant = $request->fetch();
        return $etudiant;
    }

    public function countApprenantsOfFormation($id_formateur, $id_formation)
    {
        $request= $this->connect->prepare("
            SELECT COUNT(*) AS total_apprenants FROM inscriptions 
            WHERE id_formateur = :id_formateur 
            AND id_formation = :id_formation
        ");
        $request->bindParam(":id_formateur", $id_formateur);
        $request->bindParam(":id_formation", $id_formation);
        $request->execute();
        $response=$request->fetch();
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

    public function deteleInscription($id_formation, $id_etudiant, $id_formateur){
			$request = $this->connect->prepare("DELETE FROM inscriptions
		                    WHERE id_formation = :id_formation and id_etudiant = :id_etudiant and id_formateur = :id_formateur"
            );
            $request->bindParam(':id_formation', $id_formation);
            $request->bindParam(':id_etudiant', $id_formation);
            $request->bindParam(':id_formateur', $id_formation);
			$response = $request->execute();
			return $response;
	}

    public function getInscriptionByEtudiant($idEtudiant)
    {
        $request= $this->connect->prepare("
            SELECT * FROM inscriptions
            JOIN etudiants e USING(id_etudiant)
            JOIN formateurs USING(id_formateur)
            JOIN formations USING(id_formation)
            WHERE e.id_etudiant=:id_etudiant
        ");
        $request->bindParam(":id_etudiant", $idEtudiant);
        $request->execute();
        $response=$request->fetchAll(PDO::FETCH_OBJ);
        return $response;
    }

    public function getInscriptionOfOneFormation($id_formation, $id_etudiant, $id_formateur){
        $request = $this->connect->prepare("
            SELECT * FROM inscriptions i
            JOIN etudiants  USING(id_etudiant)
            JOIN formateurs USING(id_formateur)
            JOIN formations USING(id_formation)
            WHERE i.id_formation = :id_formation 
            and i.id_etudiant = :id_etudiant 
            and i.id_formateur = :id_formateur"
        );
        $request->bindParam(':id_formation', $id_formation);
        $request->bindParam(':id_etudiant', $id_etudiant);
        $request->bindParam(':id_formateur', $id_formateur);
        $request->execute();
        $etudiant = $request->fetch(PDO::FETCH_OBJ);
        return $etudiant;
    }
}
