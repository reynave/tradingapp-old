<nav class="navbar fixed-top navbar-expand-sm bg-blur">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url();?>"><img src="<?= base_url();?>assets/icon/mirrel.png" width="120"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03"
            aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample03">
            <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                <li class="nav-item">
                    <a class="nav-link active mx-md-3" aria-current="page" href="#">Unlocking Trader Success,
                        Together</a>
                </li>
            </ul>
            <div class="d-flex"> 
                <!-- <a href="<?= base_url()?>signin" id="singin" class="btn btn-dark px-4">SIGN IN</a> -->
                <a href="<?= $_ENV['HOME_APP']?>" id="signed" class="btn btn-info px-4 text-white " style="display:none;">GO TO APP</a>
                
            </div>
        </div>
    </div>
</nav>