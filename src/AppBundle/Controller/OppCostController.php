<?php

namespace AppBundle\Controller;

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
    $pheal = new Pheal();

// requests /server/ServerStatus.xml.aspx
    $response = $pheal->serverScope->ServerStatus();

    $html = sprintf(
      "Hello Visitor! The EVE Online Server is: %s!, current amount of online players: %s",
      $response->serverOpen ? "open" : "closed",
      $response->onlinePlayers
    );
    return new Response('<html><body>' . $html . '</body></html>');
  }
}
