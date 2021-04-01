<?php
if (isset($data['show_message_info'])) {
?>
    <div class="row">
        <div class="col-12">
            <div class="alert <?php echo $data['success'] ? 'alert-success' : 'alert-danger' ?> <?php echo isset($data['text-center']) && $data['text-center'] ? 'text-center' : '' ?>" role="alert">
                <?php
                if (is_array($data['message'])) {
                ?>
                    <ul>
                        <?php
                        foreach ($data['message'] as $key => $value) {
                        ?>
                            <li><?php echo $value; ?></li>
                        <?php
                        }
                        ?>
                    </ul>
                <?php
                } else {
                ?>
                    <p><?php echo $data['message']; ?></p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php
}
?>