<?php
   if (isset($_SESSION['msg_erro']) && $_SESSION['msg_erro'] != '') {
      echo '<div class="alert alert-info alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <strong>Aviso: </strong>' . $_SESSION['msg_erro'] .
            '</div>';
      $_SESSION['msg_erro'] = '';
   }
?>