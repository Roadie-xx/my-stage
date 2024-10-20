<?php

namespace App\Services;

class Random
{
    private static $randomSeed = 0;

    public static function setSeed(int $seed = 0): int 
    {
		self::$randomSeed = abs($seed) % 9999999 + 1;

		return self::getRandomNumber();
	}

    public static function getRandomNumber(int $min = 0, int $max = 9999999): int 
    {
		if (self::$randomSeed === 0) {
            self::setSeed(mt_rand());
        }

		self::$randomSeed = (self::$randomSeed * 125) % 2796203;
		
        return self::$randomSeed % ($max - $min + 1) + $min;
	}
}