<?php

include_once 'header.php';

?>

<div class="row">
    <div class="col-12">
        <h1>Resultado búsqueda</h1>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <?php

        if (isset($data['has_results']) && $data['has_results']) {
        ?>

            <table class="table">
                <?php

                foreach ($data['data'] as $key => $value) {
                    echo "<tr>";

                    echo "<td><a href='" . PATH_SEARCH . $value[FIELD_ID_SEARCH] . "'>" . $value[FIELD_SEARCH] . "</a></td>";
              
                    echo "</tr>";
                }
                ?>
            </table>
        <?php
        } else {
        ?>
            <p>No hay resultados</p>
        <?php
        }
        ?>

    </div>
</div>



<?php

include_once 'footer.php';

?>