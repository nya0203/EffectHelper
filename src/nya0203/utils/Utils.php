<?php

declare(strict_types=1);

namespace nya0203\utils;

class Utils implements RotationTypes {
    public static function random(float|int $min, float|int $max): float {
        $max -= $min;
        $value = mt_rand() / mt_getrandmax();
        return $value * $max + $min;
    }

    public static function getRotationMatrix(int $rotationType, int|float $angle): array {
        $rotationType = max(self::ROTATION_ROLL, min(self::ROTATION_PITCH, $rotationType));
        $angle = deg2rad($angle);
        $cos = cos($angle);
        $sin = sin($angle);
        $matrix = [];
        switch($rotationType) {
            case self::ROTATION_ROLL :
                $matrix = [[1, 0 ,0],[0, $cos, -$sin],[0, $sin, $cos]];
                break;
            case self::ROTATION_YAW :
                $matrix = [[$cos, 0, $sin],[0, 1, 0],[-$sin, 0, $cos]];
                break;
            case self::ROTATION_PITCH :
                $matrix = [[$cos, -$sin, 0],[$sin, $cos, 0],[0, 0, 1]];
                break;
        }
        return $matrix;
    }
}