<?php

namespace JuegoPostas\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JuegoPostas\AppBundle\Services\JuCoServices;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	try {
    		/*$jcs = $this->get('web_services');
    		//$response = $jcs->guardarRespuesta(3,6,0,"Porque no sabes nada");
    		//$response = $jcs->esperarEstadoSubgrupos(1);
    		$response = $jcs->getResultadoFinal(1);
    		var_dump($response);die;*/
    		
    		$serviceUri = $this->container->getParameter("wsdl_uri");
    		$client = new \SoapClient($serviceUri);
    		//$response = $client->login('Subgrupo 1.1');
    		//$response = $client->getPuntoInicial(4);
    		//$response = $client->getPieza(4);
    		//$response = $client->getSubgrupos(3);
    		//$response = $client->cambiarEstadoSubgrupo(1,3);
    		//$response = $client->tomarDecision(1,0,"Porque plantea algo distinto",1);
    		//$response = $client->finJuegoSubgrupo(1);
    		//$response = $client->esperarEstadoSubgrupos(1);
    		//$response = $client->existePreguntaSinResponder(5);
    		//$response = $client->existenRespuestas(4);
    		//$response = $client->guardarRespuesta(3,6,0,"Porque no sabes nada");
    		//$response = $client->getSubgrupos(1);
    		$response = $client->getResultadoFinal(1);
    		var_dump($response);die;
    	} catch (/*\*/SoapFault $s) {
    		die('ERROR: [' . $s->getCode() . '] ' . $s->getMessage() . $s->getTraceAsString());
    	} catch (Symfony\Component\Debug\Exception\FatalErrorException $e) {
    		die('ERROR: ' . $e->getMessage());
    	}
    	 
        return $this->render('JuegoPostasAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
