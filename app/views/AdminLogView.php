<?php
require_once 'AdminView.php';

?>

<div class="col-md-10 col-12 p-4">


    <div class="row mb-2">
        <div class="col-md-9 col-12">
            <h1>Gestión Log</h1>
        </div>
        <div class="col-md-3 col-12">
            <a class="btn btn-danger btn-icon btn-block" href="<?php echo BASE_URL_ROUTE ?>admin/log/delete-log">
                <i class="fa fa-trash" aria-hidden="true"></i> Borrar contenido Log
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <table class="table">
                <tr>
                    <th>Tipo</th>
                    <th>Fecha</th>
                    <th>Origen</th>
                    <th>Mensaje</th>
                </tr>
                <?php
                foreach ($data["lines"] as $key => $value) {
                    echo "<tr>";
                    if ($value['type'] === INFO_LOG) {
                        echo "<td>INFO</td>";
                    } else if ($value['type'] === ERROR_LOG) {
                        echo "<td>ERROR</td>";
                    }
                    echo "<td>" . $value['date'] . "</td>";
                    echo "<td>" . $value['origin'] . "</td>";
                    echo "<td>" . $value['message'] . "</td>";
                    echo "</tr>";
                }

                ?>
            </table>


        </div>
    </div>


</div>

<?php
require_once 'AdminFooter.php';
?>