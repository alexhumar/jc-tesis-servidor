<?php
// src/JuegoPostas/AppBundle/Admin/CaminoAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use JuegoPostas\AppBundle\Entity\Posta;
use JuegoPostas\AppBundle\Entity\Poi;
use Sonata\AdminBundle\Tests\DependencyInjection\Post;

class CaminoAdmin extends Admin
{
	const __DEFAULT_LAT = -34.92056351681724;
	const __DEFAULT_LNG = -57.95356750488281;
	
	protected $baseRouteName = 'sonata_camino';
	
	public function prePersist($camino){
		$camino->setGrupo($this->getSubject()->getGrupo());
	}
	
	// Metodo para validaciones especificas
	public function validate(ErrorElement $errorElement, $object)
	{
		if (false) {
		    $errorElement->with('camino')->addViolation('Fail to check the complex rules')->end();
		}
	}
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
    	$camino = $this->getSubject();
    	if ($camino->isNew()){
    		//El objeto es nuevo por lo tanto estoy en el create del formulario.
    		$formMapper->with('Camino', array('description' => '<h3>Las postas podr&aacute;n ser agregadas en la edici&oacute;n del camino.</h3>'))
	    		->add('grupo')
	    		->add('descripcion', 'text', array('label' => 'Descripcion'))
    		;
    	}else{
    		//El objeto ya fue creado, por lo tanto estoy en el edit.
    		$formMapper
	    		->add('primerPosta', 'sonata_type_admin',array(
	    				'delete' => false,
	    				'btn_add' => false,
	    		),array())
    		;
    		
    	}
        
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('descripcion')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('descripcion')
        ;
    }
}