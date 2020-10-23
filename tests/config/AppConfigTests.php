<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$config = include("$root/config/AppConfig.php");
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>config tests</title>
</head>
<body>
Wall rows: <?php echo $config['wall_rows'] ?>
<br />
Wall columns: <?php echo $config['wall_columns'] ?>
</body>
</html>
