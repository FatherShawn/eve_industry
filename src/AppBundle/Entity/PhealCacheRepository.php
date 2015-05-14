<?php
/**
 * @file
 * Custom Repository Class for PhealDoctrineCache
 *
 * This class uses the EntityRepository class to implement a Doctrine Entity based approach to the Pheal library's
 * caching system.
 * Author: Shawn P. Duncan
 * Date: 5/13/15
 * Time: 3:56 PM
 */


namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Pheal\Cache;

class PhealCacheRepository extends EntityRepository implements Cache\CanCache {

  /**
   * Concatenates the arguments into a string
   *
   * @param array $args
   * @return string constructed from arguments array, e. g. ;key1=value1;key2=value2
   */
  protected function concatArguments(array $args) {
    // first we have to sort the args by key to avoid that different orders lead to different cache entries!
    ksort($args);

    $result = '';
    $invalidKeys = array('userid', 'apikey', 'keyid', 'vcode');
    foreach ($args as $key => $value) {
      $key = trim($key);
      $value = trim($value);
      if (empty($value) || in_array($key, $invalidKeys)) {
        // ignore the invalid keys...
        continue;
      }
      $result .= ';' . $key . '=' . $value;
    }

    return $result;
  }

  /**
   * Load XML from cache
   *
   * @param int $userid
   * @param string $apikey **Not used in this implementation**
   * @param string $scope
   * @param string $name
   * @param array $args
   * @return string|false
   */
  public function load($userid, $apikey, $scope, $name, $args) {
    $criteria = array(
      'userId' => $userid,
      'scope' => $scope,
      'name' => $name,
      'args' => $this->concatArguments($args),
    );
    $result = $this->findOneBy($criteria);
    // if nothing is found just stop and return false.
    if (empty($result)) {
      return FALSE;
    }
    $cache_expires = new \DateTime($result->getCachedUntil(), 'UTC');
    $present = new \DateTime('now', 'UTC');
    if ($cache_expires > $present) {
      // cache TTL not exceeded.
      return $result->getXml();
    }
    else {
      // cache TTL exceeded - return false and presumeably Pheal will re-request and re-cache
      return FALSE;
    }
  }

  /**
   * Save XML from cache
   *
   * @param int $userid
   * @param string $apikey
   * @param string $scope
   * @param string $name
   * @param array $args
   * @param string $xml
   * @return boolean
   */
  public function save($userid, $apikey, $scope, $name, $args, $xml) {
    $manager = $this->getEntityManager();
    $concat_args = $this->concatArguments($args);
    $criteria = array(
      'userId' => $userid,
      'scope' => $scope,
      'name' => $name,
      'args' => $concat_args,
    );
    $cache_item = $this->findOneBy($criteria);
    if (empty($cache_item)) {
      // save new item
      $cache_item = new PhealDoctrineCache();
      $manager->persist($cache_item);
    }  // update and save
    $cache_item->setUserId($userid);
    $cache_item->setScope($scope);
    $cache_item->setName($name);
    $cache_item->setArgs($concat_args);
    $xml = new \SimpleXMLElement($xml);
    $cache_item->setXml($xml->asXML());
    $manager->flush();
  }
}