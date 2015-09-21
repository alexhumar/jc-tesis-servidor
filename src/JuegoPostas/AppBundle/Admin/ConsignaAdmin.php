<?php
// src/JuegoPostas/AppBundle/Admin/ConsignaAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ConsignaAdmin extends Admin
{
	protected $baseRouteName = 'sonata_consigna';
	
	//Funcion que se ejecuta antes de persistir una entidad
	public function prePersist($consigna)
	{
		//$this->preUpdate($consigna);
	}
	
	//Funcion que se ejecuta antes de editar una entidad
	public function preUpdate($consigna)
	{
		//Se hace esto para setear la inversa de la relacion.
		//$consigna->setPiezasARecolectar($consigna->getPiezasARecolectar());
	}
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {	
    	$consigna = $this->getSubject();
        $formMapper
            ->add('nombre')
            ->add('descripcion', 'text', array('label' => 'Descripcion'));
        /*Si esta en edicion, las piezas a recolectar unicamente las muestra, ya que se cargan automaticamente con el camino*/
        if (!$consigna->isNew()) {
          	$formMapper
		        ->add('piezasARecolectar', /*'sonata_type_model'*/null,
                       	array(
                           	'multiple' => true,
			            	//'by_reference'=>false,
                       		'read_only' => true,
                       		'disabled' => true            		
                       	)
                );
        }
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('descripcion')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('nombre')
            ->add('descripcion')
        ;
    }
}