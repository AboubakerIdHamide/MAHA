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
                nom_etudiant,
                prenom_etudiant,
                nom_video,
                nom_formation,
                etat_notification
            FROM notifications n
            JOIN commentaires USING (id_commentaire)
            JOIN etudiants USING (id_etudiant)
            JOIN videos USING (id_video)
            JOIN formations USING (id_formation)
            JOIN formateurs USING (id_formateur)
            WHERE id_formateur = :id_formateur
        ");

        $request->bindParam(':id_formateur', $id_formateur);
        $request->execute();
        $notifications = $request->fetchAll(PDO::FETCH_OBJ);
        return $notifications;
    }

    public function getNewNotificationsOfFormateur($id_formateur)
    {
        $request = $this->connect->prepare("
            SELECT 
                COUNT(*) AS totalNew
            FROM notifications n
            JOIN commentaires USING (id_commentaire)
            JOIN etudiants USING (id_etudiant)
            JOIN videos USING (id_video)
            JOIN formations USING (id_formation)
            JOIN formateurs USING (id_formateur)
            WHERE id_formateur = :id_formateur AND etat_notification = 1
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
