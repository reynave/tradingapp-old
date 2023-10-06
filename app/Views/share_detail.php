<style>
    html,
    body {
        background-color: #000 !important;
    }

    body {
        margin-top: 1rem;
    }

    .table {
        border: 1px solid #333;
    }

    .table td {
        background-color: #000 !important;
        border-color: #333;
        color: #fff;
    }

    a {
        color: #fff;
    }

    .slick-prev {
        z-index: 999;
        left: -25px;
    }

    .slick-prev:before {
        color: #fff;
        font-size: 30px;
    }

    .slick-next:before {
        color: #fff;
        font-size: 30px;
    }

    @media screen and (max-width: 600px) {
        .theader {
            display: none;
        }

        table tr {

            display: block;
            margin-bottom: .625em;
        }

        table td {
            display: block;
            text-align: right;

        }

        table td::before {
            content: attr(data-label);
            float: left;
        }


    }
</style>
<div class="container text-white ">
    <div class=" sticky-top bg-black" style="margin-top: -2px;"> 
        <div class="row">
            <div class=" offset-1 col-10  text-center ">
                <h1> <?= $h1 ?>  </h1>
            </div>
            <div class="col-1 align-self-center text-end">
                <a href="javascript:;"
                    onclick="copyToClipboard('<?= base_url() . 'd/' . $journal['url'] . '/' . $journal_detail_id ; ?>')"
                    class=" text-white   me-1" data-bs-toggle="tooltip" data-bs-title="Share">
                    <i class="bi bi-share fs-4"></i>
                </a>
            </div>
        </div>

    </div>
    <div class="row">

        <div class="col-12 text-center mb-2">

            <div class="mb-4">
                <a href="<?= $url ?>">
                    <?= $title ?>
                </a>

            </div>

            <div>

                <table class="table table-sm ">
                    <tr class="theader">
                        <?php
                        foreach ($items as $row) {
                            if ($row['iType'] != 'image' || $row['hide'] == true) {
                                ?>
                                <td>
                                    <small><b>
                                            <?php echo strtoupper($row['name']); ?>
                                        </b></small>
                                </td>
                                <?php
                            }
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        foreach ($items as $row) {
                            if ($row['iType'] != 'image' || $row['hide'] == true) {
                                ?>
                                <td data-label="<?php echo strtoupper($row['name']); ?>">
                                    <?php echo $row['value']; ?>&nbsp;
                                </td>
                                <?php
                            }
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-12 ">

            <div class="dt">
                <?php foreach ($images as $rec) { ?>
                    <div>
                        <img src="<?php echo $rec['path'] . $rec['fileName']; ?>" width="100%"
                            alt="<?php echo $rec['caption'] . ' ' . $rec['column']; ?>">
                    </div>
                <?php } ?>
            </div>
        </div>


    </div>
</div>