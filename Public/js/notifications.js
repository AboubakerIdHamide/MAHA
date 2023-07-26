$(document).ready(function() {
    function getAllNotifications() {
        return $.parseJSON($.ajax({
            url: "http://localhost/maha/" + controller + "/getAllNotifications",
            dataType: "json",
            async: false,
        }).responseText);
    }

    function removeRedColorToOldNotification(state) {
        if (state == 1)
            return "text-primary";
        return "text-muted";
    }

    function renderNotification() {
        $(".notifications").html("");
        const notifications = getAllNotifications();
        console.log(notifications)
        if (notifications.length === 0) {
            $("#clear-seen").remove();
            $(".notifications").html("<div class='alert alert-info'>Votre Boite de notifications est vide !</div>");
        }
        for (let notification of notifications) {
            $(".notifications").html($(".notifications").html() + `
          <a href="http://localhost/maha/${controller}/coursVideos/${notification.id_user}/${notification.id_formation}" class="row mb-3 bg-white rounded py-3 notification ${notification.etat == 0 ? "seen" : ""}" data-id-notification="${notification.id_notification}">
            <div class="col-1 text-center align-self-center">
                <i class="fa-solid fa-comment fs-1 ${removeRedColorToOldNotification(notification.etat)}"></i>
                <span class="${notification.etat == 1 ? "position-relative" : ""}">
                    <span class="position-absolute top-0 start-0 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                </span>
            </div>
            <div class="col-10">
                <p class="message text-truncate mb-1 ${removeRedColorToOldNotification(notification.etat)}">${notification.commentaire}</p>
                <div class="d-flex align-items-center">
                    <span class="me-2 date-notification ${removeRedColorToOldNotification(notification.etat)}">${notification.created_at}</span>
                    ·
                    <span class="nom-etudiant ms-2 me-2 ${removeRedColorToOldNotification(notification.etat)}">${notification.nomEtudiant.toUpperCase()} ${notification.prenom}</span>
                    ·
                    <span class="ms-2 badge bg-light ${removeRedColorToOldNotification(notification.etat)} formation">${notification.nomFormation} ==> ${notification.nomVideo}</span>
                </div>
            </div>
          </a>
        `);
        }
    }

    renderNotification();

    $(".notification").click(function() {
        const $tags = [$(this).find(".message"), $(this).find(".nom-etudiant"), $(this).find(".fa-comment"), $(this).find(".formation"), $(this).find(".date-notification"), ];

        // hide red ball.
        $(this).find(".position-relative").fadeOut("slow");

        for (let tag of $tags) {
            tag.removeClass("text-primary").addClass("text-muted");
        }
        // before send request test if this notification has not been seen yet
        if (!$(this).hasClass("seen")) {
            const idNotification = $(this).data("idNotification");
            $.ajax({
                url: "http://localhost/maha/" + controller + "/setStateToSeen/" + idNotification,
                success: function(response) {
                    console.log(response);
                },
            });
            const nbrNotifications = Number($(".nbr-notifications").text());
            if (nbrNotifications != 1)
                $(".nbr-notifications").text(nbrNotifications - 1);
            else
                $(".nbr-notifications").fadeOut("slow");
        }

        $(this).addClass("seen");
    });

    $("#clear-seen").click(function() {
        // clear the UI
        const $notifications = $(".notifications");
        $notifications.find(".seen").fadeOut("slow");
        $.ajax({
            url: "http://localhost/maha/" + controller + "/deleteSeenNotifications",
            success: function(response) {
                console.log(response);
            },
        });
    });
});
