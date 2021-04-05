<?php
   session_start();
?>
<html>
<head>
	<meta charset="iso-8859-1">
	<title>Controle Financeiro - Interno</title>

    <link href="estilo.css" type="text/css" rel="stylesheet">
</head>

<body>
	<div id="principal">
      <?php
         echo $_SESSION['erro'];
         echo '<br><br>';
      ?>
   </div>
</body>
</html>