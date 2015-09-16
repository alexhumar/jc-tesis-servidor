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
    	
        $formMapper
        	->add('latlng', 'oh_google_maps', array(
    			'map_width'      => 1200,     // the width of the map
			    'map_height'     => 600,     // the height of the map
			    'default_lat'    => self::__DEFAULT_LAT,    // the starting position on the map
			    'default_lng'    => self::__DEFAULT_LNG, // the starting position on the map
			    'label'   => false,
			    'lat_options' => array('label'=>'Latitud', 'data'=>self::__DEFAULT_LAT),
			    'lng_options' => array('label'=>'Longitud', 'data'=>self::__DEFAULT_LNG)
			))
            /*Alex - Dejo que sonata reconozca las coordenadas como float*/
            //->add('coordenadaX', null, array('label' => 'Coordenada X'))
            //->add('coordenadaY', null, array('label' => 'Coordenada Y'))
            
            ->add('piezaARecolectar','sonata_type_model', array('query'=>$piezasRepo->piezasSinPoiQuery()))
        ;
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