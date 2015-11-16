<?php
// src/JuegoPostas/AppBundle/Admin/PoiAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PoiAdmin extends Admin
{
	const __DEFAULT_LAT = -34.92056351681724;
	const __DEFAULT_LNG = -57.95356750488281;
	protected $baseRouteName = 'sonata_poi';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
    	$piezasRepo = $this->getConfigurationPool()->getContainer()->get('repos_manager')->getPiezaARecolectarRepo();
    	/* Para obtener el POI tengo que volver al camino y recorrer las postas hasta volver al POI.
    	 * Esto pasa porque no se puede obtener el objeto actual de un formulario embebido, tengo que 
    	 * sacarlo del formulario padre, en este caso, el unico formulario que no es embebido es el de
    	 * camino.
    	 */
    	//Me quedo con el objeto del formulario raíz, es decir, el camino.
    	$camino = $this->getRoot()->getSubject();
    	$posta = $camino->getPrimerPosta();
    	$piezaPredefinida = null;
    	if($posta != null){
    		$parentAdmin = $this->getParentFieldDescription()->getAdmin(); //Esta el la posta del poi
    		$countPostas = 0; //Calculo la cantidad de postas antes de llegar al camino
    		while ($parentAdmin->hasParentFieldDescription()){
    			$parentAdmin = $parentAdmin->getParentFieldDescription()->getAdmin();
    			 
    			$countPostas++;
    		}
    		 
    		//Busco la posta que contenga al POI del formulario actual
    		for ($i=1 ; $i<$countPostas ; $i++) $posta=$posta->getPostaSiguiente();
    		
    		$piezaPredefinida = $posta ? $posta->getPoi()->getPiezaARecolectar() : null;
    	}
    	
    	$dataLat = self::__DEFAULT_LAT;
    	$dataLong = self::__DEFAULT_LNG;
    	
    	if($posta != null){
    		$dataLat = $posta->getPoi()->getCoordenadaX();
    		$dataLong = $posta->getPoi()->getCoordenadaY();
    	}
    	
        $formMapper
        	->add('latlng', 'oh_google_maps', array(
    			'map_width'      => 1200,     // the width of the map
			    'map_height'     => 600,     // the height of the map
			    'default_lat'    => self::__DEFAULT_LAT,    // the starting position on the map
			    'default_lng'    => self::__DEFAULT_LNG, // the starting position on the map
			    'label'   => false,
			    'lat_options' => array('label'=>'Latitud', 'data'=>$dataLat),
			    'lng_options' => array('label'=>'Longitud', 'data'=>$dataLong)
			))
            /*Alex - Dejo que sonata reconozca las coordenadas como float*/
            //->add('coordenadaX', null, array('label' => 'Coordenada X'))
            //->add('coordenadaY', null, array('label' => 'Coordenada Y'))
            
        ;
        if ($piezaPredefinida)
        	$formMapper->add('piezaARecolectar','sonata_type_model', array('query'=>$piezasRepo->piezasSinPoiQuery($piezaPredefinida)));
        else
        	$formMapper->add('piezaARecolectar','sonata_type_model');
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('coordenadaX')
            ->add('coordenadaY')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('coordenadaX')
            ->addIdentifier('coordenadaY')
        ;
    }
	
	public function getNewInstance()
	{
	    $instance = parent::getNewInstance();
	    $instance->setCoordenadaY(self::__DEFAULT_LAT);
	    $instance->setCoordenadaX(self::__DEFAULT_LNG);
	
	    return $instance;
	}
}