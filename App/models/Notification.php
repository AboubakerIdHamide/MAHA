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
                e.nom AS nomEtudiant,
                prenom,
                v.nom AS nomVideo,
                f.nom AS nomFormation,
                n.etat,
                id_formation,
                id_etudiant AS id_user
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN etudiants e ON c.from_user = e.id_etudiant 
            JOIN videos v USING (id_video)
            JOIN formations f USING (id_formation)
            WHERE c.to_user = :id_formateur
        ");

        $query->bindParam(':id_formateur', $id_formateur);
        $query->execute();
        $notifications = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $notifications;
        }
        return [];
    }

    public function getNotificationsOfEtudiant($id_etudiant)
    {
        $query = $this->connect->prepare("
            SELECT
                id_notification, 
                commentaire,
                created_at,
                f.nom AS nomFormateur,
                prenom,
                v.nom AS nomVideo,
                fo.nom AS nomFormation,
                n.etat,
                id_formation,
                f.id_formateur AS id_user
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN formateurs f ON c.from_user = f.id_formateur 
            JOIN videos v USING (id_video)
            JOIN formations fo USING (id_formation)
            WHERE c.to_user = :id_etudiant
        ");

        $query->bindParam(':id_etudiant', $id_etudiant);
        $query->execute();
        $notifications = $query->fetchAll(PDO::FETCH_OBJ);
        if ($query->rowCount() > 0) {
            return $notifications;
        }
        return [];
    }

    public function getNewNotificationsOfEtudiant($id_etudiant)
    {
        $query = $this->connect->prepare("
            SELECT
                COUNT(*) AS totalNew
            FROM notifications n
            JOIN commentaires c USING (id_commentaire)
            JOIN formateurs e ON c.from_user = e.id_formateur 
            WHERE c.to_user = :id_etudiant AND etat = 1
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
            WHERE c.to_user = :id_formateur AND etat = 1
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
            SET etat = 0
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
            WHERE etat = 0
        ");

        $query->execute();
        if ($query->rowCount() > 0) {
            return true;
        }
        return false;
    }
}
