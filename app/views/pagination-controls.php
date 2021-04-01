
            <?php

if($data['last_page'] > 1){
    ?>
    <!-- Controles paginacion -->
    <div class="row">
        <div class="col-12 text-center mb-3 mt-3">
            <?php
                
                // Boton anterior

                // Si pag es mayor que 1, ponemos un enlace al anterior
                if ($data['pag'] > 1) {
                ?>
                    <a href="<?php echo $data['url_base']; ?>/<?php echo $data['pag'] - 1; ?>">
                        <button class="btn btn-primary">
                            <i class="fa fa-long-arrow-left" aria-hidden="true"></i>        
                        </button>
                    </a>
                <?php
                // Sino deshabilito el botón
                } else {
                ?>
                    <button class="btn btn-primary" disabled>
                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i>    
                    </button>
                <?php
                }

                // Numeros de pagina

                // Primera pagina
                ?>
                <a href="<?php echo $data['url_base']; ?>/1">
                    <button class="btn btn-primary <?php if($data['pag'] == 1){ echo 'active'; } ?>">
                        1   
                    </button>
                </a>

                <?php
                
                if( ($data['pag'] - 2) >= 1 ){
                    if(($data['pag'] - 2) == 1){
                        ?>
                        <a href="<?php echo $data['url_base']; ?>/2">
                            <button class="btn btn-primary <?php if($data['pag'] == 2){ echo 'active'; } ?>">
                                2  
                            </button>
                        </a>
                        <?php
                    }else{
                        for ($i=$data['pag'] - 2; $i <= $data['pag'] - 1; $i++) { 
                            ?>
                            <a href="<?php echo $data['url_base']; ?>/<?php echo $i;?>">
                                <button class="btn btn-primary <?php if($data['pag'] == $i){ echo 'active'; } ?>">
                                    <?php echo $i; ?>
                                </button>
                            </a>
                            <?php
                        }
                    }
                }

                if($data['pag'] != 1 && $data['pag'] != $data['last_page']){
                    ?>
                    <a href="<?php echo $data['url_base']; ?>/<?php echo $data['pag'];?>">
                        <button class="btn btn-primary active">
                            <?php echo $data['pag']; ?>
                        </button>
                    </a>
                    <?php
                }
                
                if(($data['pag'] + 2) <= $data['last_page']){
                    if(($data['pag'] + 2) == $data['last_page']){
                        // <?php if($data['pag'] == 2){ echo 'active'; }
                        ?>
                        <a href="<?php echo $data['url_base']; ?>/<?php echo $data['last_page'] - 1; ?>">
                            <button class="btn btn-primary ">
                                <?php echo $data['last_page'] - 1; ?>  
                            </button>
                        </a>
                        <?php
                    }else{
                        for ($i=$data['pag'] + 1; $i <= $data['pag'] + 2; $i++) { 
                            ?>
                            <a href="<?php echo $data['url_base']; ?>/<?php echo $i;?>">
                                <button class="btn btn-primary <?php if($data['pag'] == $i){ echo 'active'; } ?>">
                                    <?php echo $i; ?>
                                </button>
                            </a>
                            <?php
                        }
                    }
                }

                ?>

                
                <a href="<?php echo $data['url_base']; ?>/<?php echo $data['last_page']; ?>">
                    <button class="btn btn-primary <?php if($data['pag'] == $data['last_page']){ echo 'active'; } ?>">
                        <?php echo $data['last_page']; ?>   
                    </button>
                </a>

                <?php
                
                
                // Boton siguiente

                // Si el numero de registros actual es superior al maximo
                if (($data['pag'] * NUM_ITEMS_PAG) < $data['num_elems']) {
                ?>
                    <a href="<?php echo $data['url_base']; ?>/<?php echo $data['pag'] + 1; ?>">
                        <button class="btn btn-primary">
                            <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                        </button>
                    </a>
                <?php
                // Sino deshabilito el botón
                } else {
                ?>
                    <button class="btn btn-primary" disabled>
                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    </button>
                <?php
                }
                ?>
        </div>
    </div>
    <?php
}

?>