<?php

namespace Litewall\LedWall;

use Exception;

class RouteValidator
{

    private $_appConfig;

    public function __construct(array $appConfig)
    {
        $this->_appConfig = $appConfig;
    }

    public function isValidRoute($routeArray): bool
    {
        if (is_array($routeArray) == false) {
            return false;
        }

        foreach ($routeArray as $hold) {
            $length = strlen($hold);

            $holdArray = str_split($hold, ($length - 1));

            $holdPosition = $holdArray[0];  //A1

            $holdHand = $holdArray[1];  //R,L,M

            if (array_key_exists($holdPosition, $this->_appConfig["led_id_map"]) == false) {
                throw new Exception("Hold position " . $holdPosition . " not found in led_id_map");
            }

            if (strlen($holdHand) > 1) {
                throw new Exception($holdHand . " is not a valid hand char.  Must be L, R or M");
            }

            if (strpos("LRM", $holdHand ) === false) {
                throw new Exception($holdHand . " is not a valid hand char.  Must be L, R or M");
            }
        }

        return true;
    }
}