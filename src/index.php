<?php session_start();
$_SESSION['extra'] = '';
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$config = include("$root/config/appconfig.php");
$alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
?>

<!DOCTYPE html>
<html lang="en">

<!-- start header -->
<?php include($_SERVER['DOCUMENT_ROOT']."/templates/header.php"); ?>

<!-- end header -->

<!-- start command  -->

<?php
$DEBUG = 0;

if($_GET){
  if($DEBUG){echo $_GET["filename"] .  "<br>";}
  $fileName = $_GET["filename"];
  $fileContent = file_get_contents("../resources/routes/$fileName");
  $myJSON = "{\"" . $fileName . "\":" . $fileContent."}" ;
  parseData();
}
else {$myJSON = '{"routename2":["A1L", "B1R", "C1M"]}';}

if($_REQUEST['RED'])   { echo `sudo python3 led_red.py`; }
if($_REQUEST["GREEN"]) { echo `sudo python3 led_green.py`; }
if($_REQUEST["OFF"] )  { echo `sudo python3 led_off.py`; }
if($_REQUEST["TEST"])  { echo `sudo python3 -c "import board, neopixel; pixels = neopixel.NeoPixel(board.D18, 132, brightness=1); pixels[11] = (0,255,0); pixels[8] = (255,0,0);"`; }
//if($_REQUEST["STRAND"]){ echo `sudo python3 strandtest.py`; }
if($_REQUEST["TEST2"]) { parseData(); }


function parseData(){
global $myJSON;
global $DEBUG;
$json = json_decode($myJSON, true);

$jsonfile = file_get_contents("../config/wallcfg.json");
$jsonPOS = json_decode($jsonfile);
$jsonfile = file_get_contents("../config/colorcfg.json");
$jsonCOL = json_decode($jsonfile);

$stringCommand = "sudo python3 -c \"import board, neopixel; pixels = neopixel.NeoPixel(board.D18, 132, brightness=1);";
foreach($json as $key=>$value)
{
  if($DEBUG){echo "FileName =" . $key . "<br>";}
  $key = "../resources/routes/".$key;
  if($DEBUG){echo "NewName =" . $key . "<br>";}
  $newValues = json_encode($value);
  if($DEBUG){echo "VALUES =" . $newValues . "<br>";}
  $myFile = fopen($key, "w") or die ("Unable to Open File");
  fwrite($myFile, $newValues );
  fclose($myFile);
  foreach ($value as $values)
  {
    $output = str_split($values, 2);
    $val = $output[0];
    $col = $output[1];
    $position = $jsonPOS->$val;
    $color    = $jsonCOL->$col;
    if($DEBUG){echo "Values = " . $values . " position:" . $position . " Color = " . $color . "<br>";}
    $stringCommand .= "pixels[".$position."] = ".$color.";";
  }
}
$stringCommand .= "\"";
if($DEBUG) {echo "$stringCommand";}
echo `$stringCommand`;
}

?>

<section class="mb-8">
  <div class="col-md-8">
    <p class="section-leader">
      <h4>Make a selection</h4>
      <form method="post">
        <input type="submit" name="RED" value="RED"><br/>
        <input type="submit" name="GREEN" value="GREEN"><br/>
  <!--      <input type="submit" name="STRAND" value="STRAND"><br/> -->
        <input type="submit" name="TEST" value="Test"><br/>
        <input type="submit" name="TEST2" value="Test2"><br/>
        <input type="submit" name="OFF" value="OFF"><br/>
      </form>
    </p>
  </div>
</section>

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
<!-- end command -->

<!-- start copyright -->
<?php include($_SERVER['DOCUMENT_ROOT']."/templates/footer.php"); ?>
<!-- end copyright -->

</body>
</html>
