<?php

namespace JuegoPostas\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JuegoPostas\AppBundle\Services\JuCoServices;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
    	try {
//     		$jcs = $this->get('web_services');
//     		$response = $jcs->guardarRespuesta(3,6,0,"Porque no sabes nada");
//     		$response = $jcs->esperarEstadoSubgrupos(1);
//     		$response = $jcs->esperarEstadoSubgrupos(2, 7);
//     		$response = $jcs->existenRespuestas(11);
// 			$response = $jcs->guardarRespuesta(3, 11, 0, 'sdf');
// 			$response = $jcs->tomarDecision(11, 1, "sd", 0);
//     		var_dump($response);die;
    		
    		
    		$serviceUri = $this->container->getParameter("wsdl_uri");
    		$client = new \SoapClient($serviceUri);
    		//$response = $client->login('Subgrupo 1.1');
    		//$response = $client->setPostaActual($name);
    		//$response = $client->getPieza(1);
    		//$response = $client->getSubgrupos(3);
    		//$response = $client->cambiarEstadoSubgrupo(5,2);
    		//$response = $client->tomarDecision(1,0,"Porque plantea algo distinto",1);
    		//$response = $client->finJuegoSubgrupo(1);
    		//$response = $client->esperarEstadoSubgrupos(794, 951);
    		//$response = $client->esperarEstadoFinal();
    		//$response = $client->existePreguntaSinResponder(5);
    		//$response = $client->existenRespuestas(11);
    		//$response = $client->guardarRespuesta(3,6,0,"Porque no sabes nada");
    		//$response = $client->getSubgrupos(1);
    		//$response = $client->getResultadoFinal(1);
    		var_dump($response);die;
    	} catch (/*\*/SoapFault $s) {
    		die('ERROR: [' . $s->getCode() . '] ' . $s->getMessage() . $s->getTraceAsString());
    	} catch (Symfony\Component\Debug\Exception\FatalErrorException $e) {
    		die('ERROR: ' . $e->getMessage());
    	}
    	 
        return $this->render('JuegoPostasAppBundle:Default:index.html.twig', array('name' => $name));
    }
}
