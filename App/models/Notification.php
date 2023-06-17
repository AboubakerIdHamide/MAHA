<?php

/**
 *  Model Notifications
 */

class Notification
{
    private $connect;

    public function __construct($database)
    {
        $this->connect = $database;
    }

    public function getNotificationsOfFormateur($id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT
                id_notification, 
                commentaire,
                created_at,
                nom_etudiant AS nom,
                prenom_etudiant AS prenom,
                nom_video,
                nom_formation,
                etat_notification,
                id_formation,
                id_etudiant AS id_user
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN etudiants e ON c.from_user = e.id_etudiant 
            JOIN videos USING (id_video)
            JOIN formations USING (id_formation)
            WHERE c.to_user = :id_formateur
        ");

        $query->bindParam(':id_formateur', $id_formateur);
        $query->execute();
        $notifications = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $notifications;
        }
        return false;
    }

    public function getNotificationsOfEtudiant($id_etudiant)
    {
        $query = $this->connect->prepare("
            SELECT
                id_notification, 
                commentaire,
                created_at,
                nom_formateur AS nom,
                prenom_formateur AS prenom,
                nom_video,
                nom_formation,
                etat_notification,
                id_formation,
                f.id_formateur AS id_user
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN formateurs f ON c.from_user = f.id_formateur 
            JOIN videos USING (id_video)
            JOIN formations USING (id_formation)
            WHERE c.to_user = :id_etudiant
        ");

        $query->bindParam(':id_etudiant', $id_etudiant);
        $query->execute();
        $notifications = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $notifications;
        }
        return false;
    }

    public function getNewNotificationsOfEtudiant($id_etudiant)
    {
        $query = $this->connect->prepare("
            SELECT
                COUNT(*) AS totalNew
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN formateurs e ON c.from_user = e.id_formateur 
            WHERE c.to_user = :id_etudiant AND etat_notification = 1
        ");

        $query->bindParam(':id_etudiant', $id_etudiant);
        $query->execute();
        $totalNew = $query->fetch(PDO::FETCH_OBJ);
        return $totalNew;
    }

    public function getNewNotificationsOfFormateur($id_formateur)
    {
        $query = $this->connect->prepare("
            SELECT
                COUNT(*) AS totalNew
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN etudiants e ON c.from_user = e.id_etudiant 
            WHERE c.to_user = :id_formateur AND etat_notification = 1
        ");

        $query->bindParam(':id_formateur', $id_formateur);
        $query->execute();
        $totalNew = $query->fetch(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $totalNew;
        }
        return false;
    }

    public function setStateToSeen($id_notification)
    {
        $query = $this->connect->prepare("
            UPDATE notifications
            SET etat_notification = 0
            WHERE id_notification = :id_notification
        ");

        $query->bindParam(':id_notification', $id_notification);
        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }

    public function deleteSeenNotifications()
    {
        $query = $this->connect->prepare("
            DELETE FROM notifications
            WHERE etat_notification = 0
        ");

        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
