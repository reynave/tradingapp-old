function handleCredentialResponse(res) {
    console.log(res);
    if (res['clientId'] == clientId) {
        let data = res['credential'];
        console.log("clientId valid");
        $.ajax({
            type: "POST",
            url: api + "login/auth0",
            data: {
                data: res['credential']
            },
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                localStorage.setItem("app.mirrel.com", data['token']);
                setTimeout(() => {
                    location.href = home + "/login?id=" + data['accountTokenId'];
                }, 500)
            },
            error: function (e) {
                console.log(e.responseJSON.message);
                console.log(e);
            }

        });



    } else {
        console.log("clientId not valid");
    }
}
function encryptToMD5(input) {
    // Import library MD5.js 
    // Enkripsi input menjadi MD5
    var encrypted = MD5(input);

    return encrypted;
}
$(document).ready(function () {
    $("#submit-btn").click(function () {
        // Mengambil nilai inputan email dan password
        var email = $("#email").val();
        var password = $("#password").val();

        // Reset pesan error dan peringatan
        $("#email-error").text("");
        $("#password-error").text("");
        $("#warning-message").text("");

        // Validasi email tidak boleh kosong dan harus sesuai format email
        if (email === "") {
            $("#email-error").text("Email wajib diisi.");
        } else if (!isValidEmail(email)) {
            $("#email-error").text("Format email tidak valid.");
        }

        // Validasi password tidak boleh kosong
        if (password === "") {
            $("#password-error").text("Password wajib diisi.");
        }

        // Tampilkan pesan peringatan jika tidak valid
        if ((email === "" || !isValidEmail(email)) || password === "") {
            $("#warning-message").text("Harap isi semua kolom dengan benar.");
        } else {
            var encryptedPassword = encryptToMD5(password);
            const body = { email: email, password: encryptedPassword };
            console.log(body);

            $.ajax({
                type: "POST",
                url: api + "login/signIn",
                data: body,
                success: function (data) {
                    // Handle respons dari server di sini
                    console.log(data);
                    if (data['error'] == false) {
                        localStorage.setItem("app.mirrel.com", data['token']);

                        setTimeout(() => {
                            location.href = home + "login?id=" + data['accountTokenId'];
                        }, 500)
                    }
                    $("#warning-message").text(data['post']);

                },
                dataType: 'json'
            });
        }
    });

    // Fungsi untuk validasi format email
    function isValidEmail(email) {
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailRegex.test(email);
    }
});
