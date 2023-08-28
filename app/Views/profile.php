<?= $header; ?>
<style>
    body {
        background-color: #f0f2f5;
    }
</style>
<div class="global-height content-sm mt-xl">
    <div class="container">
        <div class="row">
            <div class="col-3">

                <h1 class="fs-4">
                    <?= $username; ?> <i class="bi bi-patch-check-fill"></i>
                </h1>
                <div class="text-center">
                    <img src="<?= $user['detail']['picture']; ?>" class="rounded-circle w-10075 my-4">
                    <div>
                        <strong>
                            <?= $username; ?>
                        </strong>
                    </div>
                     
                    <div class="me-2"><a href="" class="fs-4"><i class="bi bi-youtube"></i></a></div>
                    
                </div>

                <div> 
                    <div class="my-1">
                        <?= $user['detail']['description']; ?>
                    </div>

                </div>

            </div>

            <div class="col-9">
                <div class="">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="center-line my-2">
                                <div class="line"></div>
                                <div class="mx-3"><small>My Journal</small></div>
                                <div class="line"></div>
                            </div>
                        </div>
                        <?php foreach ($user['journal'] as $row) { ?>
                            <div class="col-4 mb-3">
                                <div class="border shadow-sm bg-white p-1">
                                    <a href="<?= base_url().'shared/'.$row['url']."/".url_title($row['name']) ?>">
                                        <img src="<?= $row['image'] ?>" class="w-100">
                                        <div class="py-2">
                                            <?= $row['name'] ?>
                                        </div> 
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


</div>