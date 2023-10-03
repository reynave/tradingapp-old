<?php echo $header; ?>

<div class="container ">
    <div class="row g-2">
        <div class="col-12 text-center my-5">
            <h1>Simple, Flexible Pricing</h1>
        </div>

    </div>
</div>
<div class="contentWidth mb-5">
    <div class="container">
        <div class="row">

            <?php
            $i = 0;
            foreach ($pricing as $p) { ?>
                <div class="col-12 col-md-4">
                    <div class="border shadow p-4 border-top-<?= $p['color'] ?> rounded priceTableHeight">
                        <h2 class="text-color-<?= $p['color'] ?>">
                            <?= $p['level'] ?>
                        </h2>
                        <div>
                            <strong class="display-3 font-poppins-bold text-color-<?= $p['color'] ?>">$
                                <?= $p['price'] ?>
                            </strong>
                            <strong class="fs-3 ">/
                                <?= $p['billed'] ?>
                            </strong>
                        </div>

                        <div class="d-grid my-4">
                            <button class="btn btn-lg btn-outline-dark mb-2" <?php if ($i > 0)
                                echo 'disabled'; ?> onclick="location.href='<?php echo base_url() ?>signin'">Get Started</button>
                            <div class="text-center">
                                <strong>
                                    <?= $p['specialNote'] ?>
                                </strong>
                            </div>

                            <div class="text-center"> Cancel anytime </div>
                        </div>

                        <hr>
                        <div class="my-2"><strong class="fs-5">
                                <?= $p['levelPlus']; ?>
                            </strong> </div>
                        <div class="price-list">
                            <?php foreach ($p['items'] as $row) { ?>
                                <div><img src="./assets/icon/done-dark.png" height="18">
                                    <?= $row ?>
                                </div>
                            <?php } ?>
                        </div>


                    </div>
                </div>
                <?php
                $i++;
            } ?>

        </div>
    </div>
</div>