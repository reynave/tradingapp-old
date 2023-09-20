<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mirrel.com Login</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link  href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&family=Poppins:wght@400;500;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link href="<?= base_url() ?>assets/signin/style.css" rel="stylesheet">
    <script src="https://accounts.google.com/gsi/client" async></script>

</head>

<body>
    <div class="wrapper">
        <div class="bg-white login py-5 px-3 shadow rounded border">

            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">

                        <img src="<?= base_url() ?>/assets/img/mirrel.png" class="w-75">
                        <div class="mb-3">
                            by <b>Trader</b> for trader
                        </div>
                    </div>

                    <div class="col-12 mt-3 text-center">
                        <h4>Welcome</h4>
                        <h5 class="mb-4">Unlocking Trader Success, Together</h5>
                    </div>

                    <div class="col-12">
                        <div class="signin-content text-center  mt-1">
                            <div class="mb-3 text-center">
                                <div id="g_id_onload"
                                    data-client_id="480785640282-pri4rt3btbv7gtv0f68r0aoj96v44559.apps.googleusercontent.com"
                                    data-context="signin" data-ux_mode="popup" data-callback="handleCredentialResponse"
                                    data-nonce="" data-itp_support="true">
                                </div>

                                <div class="g_id_signin" data-type="standard" data-shape="rectangular"
                                    data-theme="outline" data-text="signin_with" data-size="large"
                                    data-logo_alignment="left" data-width="100%">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="center-line my-3">
                            <div class="line"></div>
                            <div class="mx-3"><small>Or Manual Sign In With</small></div>
                            <div class="line"></div>
                        </div>
                    </div>

                    <div class="col-12   ">
                        <div class="form-signin text-center">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" placeholder="name@example.com">
                                <label for="email">Email address</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password">
                                <label for="password">Password</label>
                            </div>

                            <div class="d-grid">
                                <button type="button" id="submit-btn" class="btn btn-lg btn-dark rounded-0">Continue</a>
                            </div>
                            <div class="py-2">
                                <div class="warning" id="email-error"></div>
                                <div class="warning" id="password-error"></div>
                                <div class="warning" id="warning-message"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>

    <script src="<?= base_url() ?>assets/plugin/md5.min.js"></script>
    <script src="<?= base_url() ?>signin/config.js"></script>
    <script src="<?= base_url() ?>assets/signin/app.js"></script>
    <script>
        document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +
            ':35729/livereload.js?snipver=1"></' + 'script>')
    </script>
</body>

</html>