<?php

namespace JuegoPostas\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	try {
    		
    		//$response = $this->get('web_services')->getPuntoInicial(3);
    		//echo($response);die;
    		
    		$serviceUri = "http://192.168.0.21/sfjuco/web/app_dev.php/soap/services?wsdl";
    		$client = new \SoapClient($serviceUri);
    		//$response = $client->getSubgrupos(3);
    		//$response = $client->login('Subgrupo UNO');
    		$response = $client->getPuntoInicial(4);
    		//$response = $client->getString(1);
    		//$response = $client->call('MyServiceOne', array('name' => 'Alex')); //IMPORTANTE: este call funciona solo si $client es de clase Zend\Soap\Client
    		var_dump($response);die;
    	} catch (/*\*/SoapFault $s) {
    		die('ERROR: [' . $s->getCode() . '] ' . $s->getMessage() . $s->getTraceAsString());
    	} catch (Exception $e) {
    		die('ERROR: ' . $e->getMessage());
    	}
    	 
        return $this->render('JuegoPostasAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
