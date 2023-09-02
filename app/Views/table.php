<?= view('app_global/nav'); ?>

 
<?= view('app_global/board_header'); ?>



<div class="container mb-5">
    <table id="dtjournal" class="display nowrap dtable" style="width:100%">
        <thead>
            <tr>
                <th style="max-width: 20px;">#</th>
                <?php foreach ($headers as $row) { ?>
                    <th>
                        <?= $row['value']; ?>
                    </th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($detail as $row) {
                echo '<tr>';
                ?>
                <td>
                    <?= $i; ?>
                </td>
                <?php
                foreach ($row as $col) {
                    ?>
                    <td class="<?= ($col['iType'] == 'number' || $col['iType'] == 'formula') ? 'text-end' : ''; ?>"> <?php
                                if ($col['iType'] == 'number' || $col['iType'] == 'formula') {
                                    echo number_format((float) $col['value']);
                                } else {
                                    echo $col['value'];
                                }
                                ?>         <?= $col['suffix'] ?> </td>
                    <?php

                }
                $i++;
                echo ' </tr>';
            }
            ?>
        </tbody>

    </table>
</div>