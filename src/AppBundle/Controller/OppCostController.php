<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PhealCacheRepository;
use Proxies\__CG__\AppBundle\Entity\PhealDoctrineCache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pheal\Pheal;
use Pheal\Core\Config;

class OppCostController extends Controller
{

  /**
   * @Route("opportunity-cost", name="homepage")
   *
   * @return \AppBundle\Controller\Response
   */
  public function indexAction() {

// create pheal object with default values
// so far this will not use caching, and since no key is supplied
// only allow access to the public parts of the EVE API
//    $pheal = new Pheal();
    $em = $this->getDoctrine()->getManager();
    Config::getInstance()->cache = $em->getRepository('AppBundle:PhealDoctrineCache');
// requests /server/ServerStatus.xml.aspx
//    $response = $pheal->serverScope->ServerStatus();
//Cache test
    $characterID = 94901239;
    $keyID = '3848013';
    $vCode = '2X36tvgWtYtwvgNcysdb1YUwH2QldIt8bp7ZtcbHTGojOzzt9kw61eddrCiSYtlp';

    $pheal = new Pheal($keyID, $vCode, 'char');

    // parameters for the request, like a characterID can be added
    // by handing the method an array of those parameters as argument
    $response = $pheal->CharacterSheet(array("characterID" => $characterID));

    $html = sprintf(
      "Hello Visitor, Character %s was created at %s is of the %s race and belongs to the corporation %s",
      $response->name,
      $response->DoB,
      $response->race,
      $response->corporationNam
    );
    return new Response('<html><body>' . $html . '</body></html>');


  }
}
