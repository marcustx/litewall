<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$config = include("$root/config/appconfig.php");
$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Litewall</title>
  <!-- Bootstrap CSS -->
  <style>
    .L{
      background-color: <?php echo $config["left_hand_color"] ?>
    }

    .R{
      background-color: <?php echo $config["right_hand_color"] ?>
    }

    .M{
      background-color: <?php echo $config["match_color"] ?>
    }
  </style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
  <div class="table-responsive">
  <table class="table table-dark table-striped table-bordered table-hover">
      <thead class="">
        <tr>
          <th>#</th>
          <?php
          $column = 1;
          while ($column <= $config["wall_columns"]) { ?>
          <th id="col-<?php echo $column; ?>"><?php echo $column; ?></th>
          <?php $column++;
        } ?>
        </tr>
      </thead>
      <tbody>
        <?php
        $column = 1;
        $row = $config["wall_rows"];

        while ($row > 0) {
          $rowLetter = substr($alphabet, $row-1, 1);
          ?>
          <tr>
            <th scope="row"><?php echo $rowLetter; ?></th>
            <?php while ($column <= $config["wall_columns"]) { ?>
            <td id="<?php echo $rowLetter . $column ?>" class="climbing-hold" data-toggle="modal" data-target="#holdModal" data-climbing-hold="<?php echo $rowLetter . $column ?>"></td>
            <?php $column++;
          } ?>
          </tr>
        <?php
          $row--;
          $column = 1;
        } ?>
      </tbody>

  </table>
</div>

<div class="modal fade" id="holdModal" tabindex="-1" role="dialog" aria-labelledby="holdModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn btn-info btn-lg">
            <input type="radio" name="options" id="Left" autocomplete="off" value="L">Left
          </label>
          <label class="btn btn-info btn-lg">
            <input type="radio" name="options" id="Match" autocomplete="off" value="M">Match
          </label>
          <label class="btn btn-info btn-lg">
            <input type="radio" name="options" id="Right" autocomplete="off" value="R">Right
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <input id="climbingHoldId" type="hidden" value=""></input>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-route">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
  <script src="main.js" type="text/javascript"></script>
</body>
</html>
