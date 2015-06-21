<div class="toolbar_parent">
    <div class="toolbar toolbar_title">
        <h3><?= $site_title; ?></h3>
    </div>
</div>

<?php if (!empty($err)) { ?> 
    <p class="err"><?= $err ?></p>
<?php } ?>


<?php if (!empty($msg)) { ?> 
    <p class="msg"><?= $msg ?></p>
<?php } ?>


<div class="content">
    <form name="Form_check" method="post" action="<?= $site_url ?>admin/index.php?controller=news_management&action=index&page=<?= $page_no ?>&status=<?= $page_status ?>">
        <table class="contentList">
            <thead>
                <tr>
                    <th class="notCenter">Email address</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
            </thead>

            <tbody>

                <?php
                if (!empty($data)) {
                    foreach ($data as $key => $values) {
                        ?>                        
                        <tr>
                            <td class="notCenter"><?= $values['email_address'] ?></td>
                            <td><?= $values['status'] ?></td>
                            <td><?= $values['created'] ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>

                <tfoot>
                    <?php if (!empty($paging)) { ?>
                        <tr>
                            <td colspan="3" class="foot" align="center">
                                <?= $paging ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tfoot>
            <?php } else { ?>
                <tr><td colspan="3"><h2 style="text-align: center;padding: 6px 0;">No email available.</h2></td></tr>
            <?php } ?>
        </table>
    </form>
</div>                