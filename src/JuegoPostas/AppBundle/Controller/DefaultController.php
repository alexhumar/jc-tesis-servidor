<?php

namespace JuegoPostas\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	try {
    		$serviceUri = $this->container->getParameter("wsdl_uri");
    		$client = new \SoapClient($serviceUri);
    		//$response = $client->getSubgrupos(3);
    		$response = $client->login('Subgrupo 1.1');
    		//$response = $client->getPuntoInicial(99);
    		var_dump($response);die;
    	} catch (/*\*/SoapFault $s) {
    		die('ERROR: [' . $s->getCode() . '] ' . $s->getMessage() . $s->getTraceAsString());
    	} catch (Symfony\Component\Debug\Exception\FatalErrorException $e) {
    		die('ERROR: ' . $e->getMessage());
    	}
    	 
        return $this->render('JuegoPostasAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
