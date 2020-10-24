<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Litewall\LedWall\LedCommandBuilder;

class LedCommandBuilderTest extends TestCase
{
    public function testWallOffCommand(): void
    {
      $ledCommandBuilder = new LedCommandBuilder($this->testConfig());

      $this->assertEquals(
        "sudo python3 -c \"import board, neopixel, time; pixels = neopixel.NeoPixel(board.D18, 132, brightness=1);pixels.fill((0, 0, 0))\"",
        $ledCommandBuilder->wallOff()
      );
    }

    public function testUpdateWallCommand(): void
    {
      $ledCommandBuilder = new LedCommandBuilder($this->testConfig());

      $routeArray = ["A1L", "B2R", "C3M"];

      $this->assertEquals(
        "sudo python3 -c \"import board, neopixel, time; pixels = neopixel.NeoPixel(board.D18, 132, brightness=1);pixels[0] = (255,0,0);pixels[20] = (0,255,0);pixels[24] = (0,0,255);\"",
        $ledCommandBuilder->updateWall($routeArray)
      );
    }

    public function testReplaySequenceCommand(): void
    {
      $ledCommandBuilder = new LedCommandBuilder($this->testConfig());

      $routeArray = ["A1L", "B2R", "C3M"];

      $this->assertEquals(
        "sudo python3 -c \"import board, neopixel, time; pixels = neopixel.NeoPixel(board.D18, 132, brightness=1);pixels[0] = (255,0,0);time.sleep(.7);pixels[20] = (0,255,0);time.sleep(.7);pixels[24] = (0,0,255);time.sleep(.7);\"",
        $ledCommandBuilder->replaySequence($routeArray)
      );
    }

    private function testConfig(): array
    {
      return [
          'wall_columns' => 12,
          'wall_rows' => 11,
          'left_hand_color' => "green",
          'right_hand_color' => "red",
          'match_color' => "blue",
          'neoPixelPin' => "board.D18",
          'neoPixelNumberOfPixels' => "132",
          'neoPixelBrightness' => "1",
          'left_hand_led_rgb' => "(255,0,0)",
          'right_hand_led_rgb' => "(0,255,0)",
          'match_hand_led_rgb' => "(0,0,255)",
          'led_id_map' => array(
            'K1'=>'10','K2'=>'11','K3'=>'32','K4'=>'33','K5'=>'54','K6'=>'55','K7'=>'76','K8'=>'77','K9'=>'98','K10'=>'99','K11'=>'120','K12'=>'121',
            'J1'=>'9', 'J2'=>'12','J3'=>'31','J4'=>'34','J5'=>'53','J6'=>'56','J7'=>'75','J8'=>'78','J9'=>'97','J10'=>'100','J11'=>'119','J12'=>'122',
            'I1'=>'8', 'I2'=>'13','I3'=>'30','I4'=>'35','I5'=>'52','I6'=>'57','I7'=>'74','I8'=>'79','I9'=>'96','I10'=>'101','I11'=>'118','I12'=>'123',
            'H1'=>'7', 'H2'=>'14','H3'=>'29','H4'=>'36','H5'=>'51','H6'=>'58','H7'=>'73','H8'=>'80','H9'=>'95','H10'=>'102','H11'=>'117','H12'=>'124',
            'G1'=>'6', 'G2'=>'15','G3'=>'28','G4'=>'37','G5'=>'50','G6'=>'59','G7'=>'72','G8'=>'81','G9'=>'94','G10'=>'103','G11'=>'116','G12'=>'125',
            'F1'=>'5', 'F2'=>'16','F3'=>'27','F4'=>'38','F5'=>'49','F6'=>'60','F7'=>'71','F8'=>'82','F9'=>'93','F10'=>'104','F11'=>'115','F12'=>'126',
            'E1'=>'4', 'E2'=>'17','E3'=>'26','E4'=>'39','E5'=>'48','E6'=>'61','E7'=>'70','E8'=>'83','E9'=>'92','E10'=>'105','E11'=>'114','E12'=>'127',
            'D1'=>'3', 'D2'=>'18','D3'=>'25','D4'=>'40','D5'=>'47','D6'=>'62','D7'=>'69','D8'=>'84','D9'=>'91','D10'=>'106','D11'=>'113','D12'=>'128',
            'C1'=>'2', 'C2'=>'19','C3'=>'24','C4'=>'41','C5'=>'46','C6'=>'63','C7'=>'68','C8'=>'85','C9'=>'90','C10'=>'107','C11'=>'112','C12'=>'129',
            'B1'=>'1', 'B2'=>'20','B3'=>'23','B4'=>'42','B5'=>'45','B6'=>'64','B7'=>'67','B8'=>'86','B9'=>'89','B10'=>'108','B11'=>'111','B12'=>'130',
            'A1'=>'0', 'A2'=>'21','A3'=>'22','A4'=>'43','A5'=>'44','A6'=>'65','A7'=>'66','A8'=>'87','A9'=>'88','A10'=>'109','A11'=>'110','A12'=>'131'
          ),
          'blink_delay' => ".7"];
    }
}