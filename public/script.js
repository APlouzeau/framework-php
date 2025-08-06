$(document).ready(function () {
    $("#sendMessage").on("click", function () {
        const message = $("#messageInput").val().trim(); // Supprime les espaces
        if (validateMessage(message)) {
            createMessage(message);
        } else {
            showError("Le message doit contenir entre 1 et 500 caractères !");
        }
    });

    $("#messageInput").on("keydown", function (event) {
        if (event.key === "Enter") {
            // Utilisation de === (strict)
            event.preventDefault();
            $("#sendMessage").click();
        }
    });

    // Fonction de validation avec critères stricts
    function validateMessage(message) {
        return message.length > 0 && message.length <= 500;
    }

    // Fonction d'affichage d'erreur améliorée
    function showError(errorMessage) {
        // Remplace alert() par un meilleur système
        console.error("Erreur de validation:", errorMessage);

        // Affichage visuel de l'erreur (optionnel)
        const errorDiv = $("#errorMessage");
        if (errorDiv.length) {
            errorDiv.text(errorMessage).show();
            setTimeout(() => errorDiv.hide(), 3000);
        } else {
            alert(errorMessage); // Fallback si pas d'élément d'erreur
        }
    }

    // Fonction d'échappement HTML pour prévenir XSS
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function createMessage(message) {
        $.ajax({
            url: "/ajaxMessage",
            type: "POST",
            async: true,
            data: { message: message },
            dataType: "json",
            timeout: 5000, // Timeout de 5 secondes
            success: function (results) {
                // Validation de la réponse serveur
                if (!results || typeof results !== "object") {
                    showError("Réponse serveur invalide");
                    return;
                }

                const resultsValues = Object.values(results);

                // Validation des données reçues
                if (resultsValues.length < 2) {
                    showError("Données incomplètes reçues du serveur");
                    return;
                }

                // Échappement HTML pour prévenir XSS
                const safeMessage = escapeHtml(String(resultsValues[0] || ""));
                const safeUserId = escapeHtml(String(resultsValues[1] || ""));

                $("#postsContainer").append(`
          <div class="post">
            <p>${safeMessage}</p>
            <span>Posté par l'utilisateur ID: ${safeUserId}</span>
          </div>
        `);

                $("#messageInput").val("");
            },
            error: function (xhr, status, error) {
                // Gestion d'erreur améliorée avec plus de détails
                console.error("Erreur AJAX:", {
                    status: status,
                    error: error,
                    responseText: xhr.responseText,
                });

                let errorMessage = "Erreur lors de l'envoi du message";

                if (status === "timeout") {
                    errorMessage = "Délai d'attente dépassé. Veuillez réessayer.";
                } else if (xhr.status === 403) {
                    errorMessage = "Accès non autorisé. Veuillez vous reconnecter.";
                } else if (xhr.status === 500) {
                    errorMessage = "Erreur serveur. Veuillez réessayer plus tard.";
                }

                showError(errorMessage);
            },
        });
    }
});
