<?php
// src/JuegoPostas/AppBundle/Admin/PostaAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use JuegoPostas\AppBundle\Entity\Poi;

class PostaAdmin extends Admin
{
	const __DEFAULT_LAT = -34.92056351681724;
	const __DEFAULT_LNG = -57.95356750488281;
	
	protected $baseRouteName = 'sonata_posta';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
    	   	
    	/* Veo si es necesario agregar una posta siguiente, dependiendo del numero de */
    	/* subgrupos del grupo al que pertenece el camino de la posta */
    	$parentAdmin = $this->getParentFieldDescription()->getAdmin();
    	$countPostas = 1;
    	$container = $this->getConfigurationPool()->getContainer();
    	$subgrupoRepo = $container->get('repos_manager')->getSubgrupoRepo();
    	while ($parentAdmin->hasParentFieldDescription()){
    		$parentAdmin = $parentAdmin->getParentFieldDescription()->getAdmin();
    		
    		$countPostas++;
    	}
    	//Como itera con todos los padres, este siempre será el camino.
    	$camino = $parentAdmin->getSubject();
    	
    	$subgrupos = $subgrupoRepo->getSubgruposDeGrupo($camino->getGrupo());
        $subgrupoQuery = $subgrupoRepo->getSubgruposDeGrupoQuery($camino->getGrupo());
        
    	$formMapper
	    	->add('nombre', 'text', array('label' => 'Nombre'))
	    	->add('subgrupo', 'sonata_type_model', array('query' => $subgrupoQuery))
	    	->add('poi','sonata_type_admin',array(
	    			'delete' => false,
	    			'btn_add' => false,
    	));	
        if(count($subgrupos) > $countPostas)
            $formMapper
	            ->add('postaSiguiente', 'sonata_type_admin',array(
		    			'delete' => false,
		    			'btn_add' => false,
		    	));
	        ;
            
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombre')
        ;
    }
    
    public function getNewInstance()
    {
    	$instance = parent::getNewInstance();
    	$poi = new Poi();
    	$poi->setCoordenadaX(self::__DEFAULT_LAT);
    	$poi->setCoordenadaY(self::__DEFAULT_LNG);
    	$instance->setPoi($poi);
    	
    
    	return $instance;
    }
}