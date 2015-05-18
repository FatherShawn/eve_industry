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

  public function convertToDatabaseValue($value, AbstractPlatform $platform) {
    if ($value === null) {
      return null;
    }
    if (empty(self::$utc)) {
      self::$utc = new \DateTimeZone('UTC');
    }
    // Current behavior according to comments at php.net is that setting
    // timezone with text name to create DateTimeZone object does not effect
    // timestamp but let's not depend on that...
    $timestamp = $value->getTimeStamp();
    $value->setTimezone(self::$utc);
    $value->setTimestamp($timestamp);
    return $value->format($platform->getDateTimeFormatString());
  }

  public function convertToPHPValue($value, AbstractPlatform $platform)
  {
    if ($value === null) {
      return null;
    }
    if (empty(self::$utc)) {
      self::$utc = new \DateTimeZone('UTC');
    }
    $val = \DateTime::createFromFormat($platform->getDateTimeFormatString(), $value, self::$utc);
    if (!$val) {
      throw ConversionException::conversionFailed($value, $this->getName());
    }
    return $val;
  }
}