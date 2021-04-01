<?php


include_once 'header.php';

?>

<div class="row">
    <div class="col-12">

        <div class="row">
            <div class="col-12">
                <?php include 'breadcumb.php'; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <div class="row">
                    <div class="col-12 mt-2">
                        <h1><?php echo $data['category']['name']; ?></h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-9">

                        <h2><?php echo $data['category']['description']; ?></h2>
                    </div>
                </div>

                <?php
                if (count($data['category']['child']) === 0) {
                ?>
                    <div class="row">
                        <div class="col-12">
                            <p>No hay categorias hijas.</p>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="row">
                        <div class="col-12">
                            <table class="table">
                                <tbody>

                                    <?php

                                    foreach ($data['category']['child'] as $key_child => $child) {

                                        echo "<tr>";
                                    ?>
                                        <td>
                                            
                                        </td>
                                <?php
                                        echo "</tr>";
                                    }
                                }


                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

            </div>
        </div>

    </div>
</div>



<?php

include_once 'footer.php';

?>