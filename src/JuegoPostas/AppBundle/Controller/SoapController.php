<?php
namespace JuegoPostas\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Zend\Soap;

class SoapController extends Controller {
	
    public function init() {
        // No cache
        ini_set('soap.wsdl_cache_enable', 0);
        ini_set('soap.wsdl_cache_ttl', 0);
    }

    public function servicesAction() {
        if(isset($_GET['wsdl'])) {
            return $this->handleWSDL($this->generateUrl('juco_soap_services', array(), true), 'web_services'); 
        } else {
            return $this->handleSOAP($this->generateUrl('salita_soap_check', array(), true), 'web_services'); 
        }
    }

    /**
    * return the WSDL
    */
    public function handleWSDL($uri, $class) {
        // Soap auto discover
        $autodiscover = new Soap\AutoDiscover();
        $autodiscover->setClass($this->get($class));
        $autodiscover->setUri($uri);

       // Response
       $response = new Response();
       $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
       ob_start();

       // Handle Soap
       $autodiscover->handle();
       $response->setContent(ob_get_clean());
       return $response;
    }

    /**
     * execute SOAP request
     */
    public function handleSOAP($uri, $class) {
        // Soap server
        $soap = new Soap\Server(null,array('location' => $uri,'uri' => $uri,));
        $soap->setClass($this->get($class));

        // Response
        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        // Handle Soap
        $soap->handle();
        $response->setContent(ob_get_clean());
        return $response;
    }
}