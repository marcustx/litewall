<?php session_start();
$_SESSION['extra'] = '';
?>

<!DOCTYPE html>
<html lang="en">

<!-- start header -->
<?php include($_SERVER['DOCUMENT_ROOT']."/header.php"); ?>

<!-- end header -->

<!-- start command  -->

<?php
$DEBUG = 0;

if($_GET){
  if($DEBUG){echo $_GET["filename"] .  "<br>";}
  $fileName = $_GET["filename"];
  $fileContent = file_get_contents("routes/$fileName");
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

$jsonfile = file_get_contents("json/wallcfg.json");
$jsonPOS = json_decode($jsonfile);
$jsonfile = file_get_contents("json/colorcfg.json");
$jsonCOL = json_decode($jsonfile);

$stringCommand = "sudo python3 -c \"import board, neopixel; pixels = neopixel.NeoPixel(board.D18, 132, brightness=1);";
foreach($json as $key=>$value)
{
  if($DEBUG){echo "FileName =" . $key . "<br>";}
  $key = "routes/".$key;
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

<!-- end command -->

<!-- start copyright -->
<?php include($_SERVER['DOCUMENT_ROOT']."/footer.php"); ?>
<!-- end copyright -->

</body>
</html>

