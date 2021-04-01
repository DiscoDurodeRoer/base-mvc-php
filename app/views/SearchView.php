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

        if ($data['has_results']) {
        ?>

            <table class="table">
                <?php

                foreach ($data['topics'] as $key => $value) {
                    echo "<tr>";

                    echo "<td><a href='/base-mvc-php/reply/" . $value['id'] . "'>" . $value['title'] . "</a></td>";
              
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