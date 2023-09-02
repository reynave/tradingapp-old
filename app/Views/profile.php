<?=  view('app_global/nav') ?>

<div class="container mb-3">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <img src="<?= $detail['picture']; ?>" class="rounded-circle my-4" style="width: 150px;">
            <h1 class="fs-4">
                <?= ucwords($username) ?> <i class="bi bi-patch-check-fill text-info"></i>
            </h1>
            <div><span class="badge bg-dark"><?= ucwords( $detail['party']);?></span></div>
        </div>

        <div class="col-12">
            <div class="d-flex justify-content-center" id="myTab" role="tablist">
                <div class="me-2">
                    <a href="javascript:;" onclick="location.href='#journal'" class="btn btn-light active"
                        data-bs-toggle="tab" data-bs-target="#journal-tab-pane">Journals</a>
                </div>
                <div class="me-2">
                    <a href="javascript:;" onclick="location.href='#trade'" class="btn btn-light" data-bs-toggle="tab"
                        data-bs-target="#trade-tab-pane"> Real Trade</a>
                </div>
                <div class="mx-2">
                    <a href="javascript:;" onclick="location.href='#bookmark'" class="btn btn-light"
                        data-bs-toggle="tab" data-bs-target="#bookmark-tab-pane">Bookmark</a>
                </div>
                <!-- <div class="mx-2">
                    <a href="javascript:;" onclick="location.href='#team'" class="btn btn-light" data-bs-toggle="tab"
                        data-bs-target="#team-tab-pane">Team</a>
                </div> -->
                <div class="mx-2">
                    <a href="javascript:;" onclick="location.href='#about'" class="btn btn-light" data-bs-toggle="tab"
                        data-bs-target="#about-tab-pane">About</a>
                </div>
            </div>
        </div>

        <div class="col-12 my-4">
            <div class="center-line my-2">
                <div class="line"></div>
                <div class="mx-3"><small>My Journal</small></div>
                <div class="line"></div>
            </div>
        </div>

    </div>
</div>


<div class="tab-content mb-6" id="myTabContent">
    <div class="tab-pane fade show active" id="journal-tab-pane" role="tabpanel" aria-labelledby="journal-tab"
        tabindex="0">

        <div class="container">
            <div class="row g-5">
                <?php foreach ($journal as $row) { ?>
                    <div class="col-4 mb-3">
                        <a href="<?= base_url() . 'shared/' . $row['url'] . "/" . url_title($row['name']) ?>">
                            <img src="<?= $row['image'] ?>" class="w-100 rounded">
                            <div class="py-2">
                                <?= $row['name'] ?>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>

    <div class="tab-pane fade" id="trade-tab-pane" role="tabpanel" aria-labelledby="trade-tab" tabindex="0">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center my-5">
                    <strong> <i class="bi bi-lock"></i> LOCK</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="bookmark-tab-pane" role="tabpanel" aria-labelledby="bookmark-tab" tabindex="0">
        <div class="container">
            <div class="row">
            <div class="col-12 text-center my-5">
                    <strong> <i class="bi bi-lock"></i> LOCK</strong>
                </div>
            </div>
        </div>
    </div>


    <div class="tab-pane fade" id="team-tab-pane" role="tabpanel" aria-labelledby="team-tab" tabindex="0">

        <div class="container">
            <div class="row">
                <div class="col-12">
                    team-tab-pane
                </div>
            </div>
        </div>
    </div>


    <div class="tab-pane fade" id="about-tab-pane" role="tabpanel" aria-labelledby="about-tab" tabindex="0">
        <div class="content-md mb-5">
            <div class="container">
                <div class="row">
                    <div class="col-7 ">
                        <div class="mb-3">
                            <strong>About Us</strong>
                        </div>
                        <div>
                            <?= $detail['description']?>
                        </div>
                    </div>
                    <div class="col-5 ">
                        <div class="mb-5">
                            <div class="mb-3">
                                <strong>Team</strong>
                            </div>
                            <div class="list">
                                <?php foreach($team as $rec) { ?>
                                    <img src="<?= $rec['picture']?>" class="rounded-circle me-2 mb-2" width="50" data-bs-toggle="tooltip" data-bs-title="<?= ucwords($rec['username'])?>">
                                <?php } ?>
                            </div>
                        </div>

                        <div>
                            <div class="mb-3">
                                <div class="mb-3">
                                    <strong>Social Media</strong>
                                </div>
                                <div>
                                    <i class="bi bi-facebook me-2 fs-4"></i> facebook
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>