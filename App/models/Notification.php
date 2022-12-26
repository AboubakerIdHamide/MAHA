<?php
// class Notifications

class Notification
{
    private $connect;

    public function __construct($database)
    {
        $this->connect = $database;
    }

    public function getNotificationsOfFormateur($id_formateur)
    {
        $request = $this->connect->prepare("
            SELECT
                id_notification, 
                commentaire,
                created_at,
                nom_etudiant as nom,
                prenom_etudiant as prenom,
                nom_video,
                nom_formation,
                etat_notification,
                id_formation,
                id_etudiant as id_user
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN etudiants e ON c.from_user = e.id_etudiant 
            JOIN videos USING (id_video)
            JOIN formations USING (id_formation)
            WHERE c.to_user = :id_formateur
        ");

        $request->bindParam(':id_formateur', $id_formateur);
        $request->execute();
        $notifications = $request->fetchAll(PDO::FETCH_OBJ);
        return $notifications;
    }

    public function getNotificationsOfEtudiant($id_etudiant)
    {
        $request = $this->connect->prepare("
            SELECT
                id_notification, 
                commentaire,
                created_at,
                nom_formateur as nom,
                prenom_formateur as prenom,
                nom_video,
                nom_formation,
                etat_notification,
                id_formation,
                f.id_formateur as id_user
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN formateurs f ON c.from_user = f.id_formateur 
            JOIN videos USING (id_video)
            JOIN formations USING (id_formation)
            WHERE c.to_user = :id_etudiant
        ");

        $request->bindParam(':id_etudiant', $id_etudiant);
        $request->execute();
        $notifications = $request->fetchAll(PDO::FETCH_OBJ);
        return $notifications;
    }

    public function getNewNotificationsOfEtudiant($id_etudiant)
    {
        $request = $this->connect->prepare("
            SELECT
                COUNT(*) AS totalNew
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN formateurs e ON c.from_user = e.id_formateur 
            WHERE c.to_user = :id_etudiant AND etat_notification = 1
        ");

        $request->bindParam(':id_etudiant', $id_etudiant);
        $request->execute();
        $totalNew = $request->fetch(PDO::FETCH_OBJ);
        return $totalNew;
    }

    public function getNewNotificationsOfFormateur($id_formateur)
    {
        $request = $this->connect->prepare("
            SELECT
                COUNT(*) AS totalNew
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN etudiants e ON c.from_user = e.id_etudiant 
            WHERE c.to_user = :id_formateur AND etat_notification = 1
        ");

        $request->bindParam(':id_formateur', $id_formateur);
        $request->execute();
        $totalNew = $request->fetch(PDO::FETCH_OBJ);
        return $totalNew;
    }

    public function setStateToSeen($id_notification)
    {
        $request = $this->connect->prepare("
            UPDATE notifications
            SET etat_notification = 0
            WHERE id_notification = :id_notification
        ");

        $request->bindParam(':id_notification', $id_notification);
        $response = $request->execute();
        return $response;
    }

    public function deleteSeenNotifications()
    {
        $request = $this->connect->prepare("
            DELETE FROM notifications
            WHERE etat_notification = 0
        ");
        $response = $request->execute();
        return $response;
    }
}
