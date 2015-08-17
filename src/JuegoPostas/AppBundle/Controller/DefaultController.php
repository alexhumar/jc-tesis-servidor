<?php

namespace JuegoPostas\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	/* //Como servicio de symfony funciona bien.
    	$subgrupos = $this->get('web_services')->getSubgrupos('1');
    	foreach ($subgrupos as $subgrupo) {
    		echo($subgrupo);
    	}die;
    	var_dump($subgrupos);die; //Prueba para ver si retorna los subgrupos*/
    	
    	try {
    		$serviceUri = "http://localhost/sfjuco/web/app_dev.php/soap/services?wsdl";
    		$client = new \SoapClient($serviceUri);
    		//$response = $client->getSubgrupos(1);
    		$response = $client->getHolahola('a');
    		//$response = $client->call('MyServiceOne', array('name' => 'Alex')); //IMPORTANTE: este call funciona solo si $client es de clase Zend\Soap\Client
    		echo($response);die;
    	} catch (\SoapFault $s) {
    		die('ERROR: [' . $s->getCode() . '] ' . $s->getMessage() . $s->getTraceAsString());
    	} catch (Exception $e) {
    		die('ERROR: ' . $e->getMessage());
    	}
    	 
        return $this->render('JuegoPostasAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
