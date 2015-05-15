<?php
/**
 * @file
 * A custom type to force UTC in the cache
 * 
 * http://docs.doctrine-project.org/en/latest/cookbook/working-with-datetime.html
 * Author: Shawn P. Duncan
 * Date: 5/15/15
 * Time: 6:06 PM
 */


namespace AppBundle\Type;

use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;

class PhealCacheTimeType extends DateTimeType {
  static private $utc = null;

  public function convertToDatabaseValue($value, AbstractPlatform $platform)
  {
    if ($value === null) {
      return null;
    }


    return $value->format($platform->getDateTimeFormatString(),
      (self::$utc) ? self::$utc : (self::$utc = new \DateTimeZone('UTC'))
    );
  }

  public function convertToPHPValue($value, AbstractPlatform $platform)
  {
    if ($value === null) {
      return null;
    }

    $val = \DateTime::createFromFormat(
      $platform->getDateTimeFormatString(),
      $value,
      (self::$utc) ? self::$utc : (self::$utc = new \DateTimeZone('UTC'))
    );
    if (!$val) {
      throw ConversionException::conversionFailed($value, $this->getName());
    }
    return $val;
  }
}