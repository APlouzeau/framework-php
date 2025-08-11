$(document).ready(function () {
    $("form").on("submit", function (e) {
        e.preventDefault();
        let nickName = $("input[name='nickName']").val();
        let email = $("input[name='email']").val();
        let password = $("input[name='password']").val();
        let confirmPassword = $("input[name='confirmPassword']").val();

        $.ajax({
            url: "/register",
            type: "post",
            data: {
                nickName: nickName,
                email: email,
                password: password,
                confirmPassword: confirmPassword,
            },
            dataType: "json",
            success: function (results) {
                let ajaxResponse = document.querySelector(".ajaxResponse");
                if (results.code === 0) {
                    ajaxResponse.innerHTML = '<span style="color:red">' + results.message + "</span>";
                } else {
                    ajaxResponse.innerHTML =
                        '<span style="color:green">' + (results.message || "Inscription réussie !") + "</span>";
                }
            },
            error: function (request, error) {
                let ajaxResponse = document.querySelector(".ajaxResponse");
                ajaxResponse.innerHTML = '<span style="color:red">Erreur lors de la requête.</span>';
                console.error("Error: " + error);
                console.error("Request: ", request);
            },
        });
    });
});
