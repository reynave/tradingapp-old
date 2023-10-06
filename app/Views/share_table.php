<?= view('app_global/nav'); ?>
 
<?= view('app_global/board_header'); ?>
 
<div class="container mb-5">
    <table id="dtjournal" class="display nowrap dtable" style="width:100%">
        <thead>
            <tr>
                <th style="max-width: 20px;">#</th>
                <?php foreach ($items[0] as $row) { ?>
                    <th>
                        <?= $row['name']; ?>
                    </th>
                <?php } ?>
                <th>
                    Share Link
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            foreach ($items as $row) {
                echo '<tr>';
                ?>
                <td>
                    <?= $i; ?>
                </td>
                <?php
                foreach ($row as $col) {
                    $id = $col['id'];
                    ?>
                    <td class="<?= ($col['iType'] == 'number' || $col['iType'] == 'formula') ? 'text-end' : ''; ?>">
                     <?php
                        if ($col['iType'] == 'number' || $col['iType'] == 'formula') {
                            echo number_format((float) $col['value']);
                        } else {
                            echo $col['value'];
                        }
                        ?>
                    </td> 
                    <?php 
                }?>
                <td>
                    <a target="_blank" href="<?= base_url();?>d/<?= $journal['url']?>/<?= $id?>"><i class="bi bi-link-45deg"></i> Share link</a>
                </td>
                <?php
                $i++;
                echo ' </tr>';
            }
            ?>
             
        </tbody>

    </table>
</div>