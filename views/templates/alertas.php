<?php

    foreach ($alertas as $key => $mensajes):
        foreach($mensajes as $mensaje) :

?>
            <div class="alert <?php echo $key; ?>">
                <?php echo $mensaje; ?>
            </div>

<?php
endforeach;
endforeach;
?>