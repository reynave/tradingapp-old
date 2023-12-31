<div class="container mb-5 pt-4">
    <div class="row">
        <div class="col-10">
            <div class="d-flex">
                <div>
                    <img src="<?= $journal['image']; ?>" width="150" class="p-2 rounded">
                </div>
                <div class="align-self-center px-2">

                    <h1 class="fs-5">
                        <?= $journal['name']; ?>
                    </h1>
                    <div>
                        <div class="input-group border px-2 rounded">
                            <div class="me-2">
                                <small> <i class="bi bi-share"></i></small>
                            </div>
                            <input style="min-width: 400px;" type="text" class="form-control form-control-sm border-0 p-0 d-inline shadow-none"
                                value="<?= base_url() . 'shared/' . $journal['url'] . '/'.url_title($journal['name']); ?>" readonly>
                        </div>
                    </div>
                    <div class="d-flex mb-1">
                        <div class="align-self-center">
                            <img src="<?php echo $_ENV['API_APP'].'uploads/picture/'.$journal['picture']; ?>" width="34" class="p-1 rounded-circle">
                            <a href="<?= base_url() . $journal['username'] ?>">
                                <small>
                                    <?= ucwords($journal['username']); ?>
                                </small>
                            </a>
                            <?php if ($journal['icon'] != '') { ?>
                                <img src="<?= base_url() . 'assets/icon/' . $journal['icon']; ?>"
                                    title="<?= $journal['plan']; ?>" class="mx-1" width="20">
                            <?php } ?>

                        </div> 
                        
                        <div class="align-self-center mx-3"> | </div>
                        <div class="align-self-center">
                            <small> Since
                                <?= date("Y-M-d", strtotime($journal['input_date'])) ?>
                            </small>
                        </div>
                        <!-- <div class="align-self-center mx-3"> | </div>
                        <div class="align-self-center">
                             <span></span>
                        </div> -->
                    </div>



                </div>

            </div>

        </div>
        <div class="col-2 text-end align-self-center">
            <a href="" class="btn btn-sm rounded btn-light border me-1" data-bs-toggle="tooltip"
                data-bs-title="Reports"><i class="bi bi-flag fs-5"></i></a>

            <a href="javascript:;"
                onclick="copyToClipboard('<?= base_url() . 'shared/' . $journal['url'] . '/'.url_title($journal['name'] ); ?>')"
                class="btn btn-sm rounded btn-light border me-1" data-bs-toggle="tooltip" data-bs-title="Share"><i
                    class="bi bi-share fs-5"></i></a>

            <a href="" class="btn btn-sm rounded btn-light border me-1" data-bs-toggle="tooltip"
                data-bs-title="Save to my Bookmark"><i class="bi bi-bookmark fs-5"></i></a>


        </div>
    </div>
</div>


<div class="container mb-3">
    <div class="row mb-2">
        <div class="col-12">
            <ul class="nav nav-tabs journal-slick">
                <?php
                foreach ($tabs as $row) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $journalTableViewId == $row['id'] ? "active" : "" ?> "
                            aria-current="<?= $row['name']; ?>" href="?tab=<?= $row['id']; ?>"><?= $row['name']; ?></a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>