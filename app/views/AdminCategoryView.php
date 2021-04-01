<?php
require_once 'AdminView.php'
?>

<div class="col-md-10 col-12 p-4">

    <?php
    if (isset($data['display_create']) || isset($data['display_edit'])) {
    ?>

        <div class="row">
            <div class="col-12">
                <h1><?php echo isset($data['display_create']) ?  'Crear categoría' :  'Editar categoria' ?></h1>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

                <form action="<?php echo BASE_URL_ROUTE ?>admin/categorias/<?php echo isset($data['category']) ? 'editar-categoria' : 'crear-categoria' ?>" method="POST">

                    <?php
                    if (isset($data['display_edit'])) {
                    ?>
                        <input type="hidden" class="form-control" name="id" value="<?php echo $data['category']['id']; ?>" />
                        <input type="hidden" class="form-control" name="parent_cat_ori" value="<?php echo $data['category']['parent_cat']; ?>" />
                    <?php
                    }
                    ?>

                    <!-- Nombre categoria -->
                    <div class="row form-group">
                        <div class="col-12">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" name="name" id="name" maxlength="80" value="<?php echo isset($data['category']) ? $data['category']['name'] : ''; ?>" />
                        </div>
                    </div>

                    <!-- Descripción categoria -->
                    <div class="row form-group">
                        <div class="col-12">
                            <label for="description">Descripción</label>
                            <textarea name="description" class="form-control" id="description" maxlength="300"><?php echo isset($data['category']) ? trim($data['category']['description']) : ''; ?></textarea>
                        </div>
                    </div>

                    <?php

                    if (!isset($data['category']['has_child']) || $data['category']['has_child'] == 0) {
                    ?>
                        <!-- Nombre categoria -->
                        <div class="row form-group">
                            <div class="col-12">
                                <label for="parent_cat">Categoria padre</label>
                                <select class="form-control" name="parent_cat" id="parent_cat">
                                    <?php

                                    foreach ($data['categories'] as $key => $value) {
                                        if (isset($data['category']) && $data['category']['parent_cat'] === $value['id']) {
                                            echo "<option selected value='" . $value['id'] . "'>" . $value['name'] . "</option>";
                                        } else {
                                            echo "<option value='" . $value['id'] . "'>" . $value['name'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    <?php
                    }

                    ?>


                    <!-- Icono categoria -->
                    <!-- <div class="row form-group">
                        <div class="col-12">
                        
                        </div>
                    </div> -->

                    <div class="row form-group">
                        <div class="col-6">
                            <button type="submit" name="action" class="btn btn-primary btn-block"><?php echo isset($data['display_create']) ?  'Añadir' :  'Editar' ?></button>
                        </div>
                        <div class="col-6">
                            <button type="button" name="back" class="btn btn-primary btn-block">Volver</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>


    <?php
    } else {
    ?>

        <div class="row mb-2">
            <div class="col-md-9 col-12">
                <h1>Categorias</h1>
            </div>
            <div class="col-md-3 col-12">
                <a class="btn btn-primary btn-icon btn-block" href="<?php echo BASE_URL_ROUTE ?>admin/categorias/crear-categoria-form">
                    <i class="fa fa-plus" aria-hidden="true"></i> Crear Categoria
                </a>
            </div>
        </div>

        <?php
        if ($data['num_elems'] == 0) {
        ?>
           <div class="row">
                <div class="col-12">
                    <p>No hay categorias</p>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="row">
                <div class="col-12">
                    <?php include_once 'show-info-message.php'; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table">

                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Padre</th>
                            <th>Icono</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php

                        foreach ($data['categories'] as $key => $value) {
                        ?>
                            <tr>
                                <td><?php echo $value['id']; ?></td>
                                <td><?php echo $value['name']; ?></td>
                                <td><?php echo $value['description']; ?></td>
                                <td><?php echo $value['parent']; ?></td>
                                <td><?php echo $value['icon']; ?></td>
                                <td>
                                    <a class="btn btn-primary btn-icon" href="<?php echo BASE_URL_ROUTE ?>admin/categorias/editar-categoria-form/<?php echo $value['id']; ?>">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td>
                                    <?php
                                    if ($value['has_child'] == 0) {
                                    ?>
                                        <a class="btn btn-danger btn-icon" href="<?php echo BASE_URL_ROUTE ?>admin/categorias/eliminar-categoria/<?php echo $value['id']; ?>">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <?php
                    include_once "pagination-controls.php";
                    ?>
                </div>
            </div>
        <?php
        }
        ?>


    <?php
    }

    ?>


</div>

<?php
require_once 'AdminFooter.php';
?>