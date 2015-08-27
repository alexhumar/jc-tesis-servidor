<?php
// src/JuegoPostas/AppBundle/Admin/PiezaARecolectarAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PiezaARecolectarAdmin extends Admin
{
	protected $baseRouteName = 'sonata_piezaarecolectar';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('descripcion', 'text', array('label' => 'Descripcion'))
            ->add('cumpleConsigna', 'choice', array(
    				'choices' => array(
        				0 => 'No',
        				1 => 'Si'
    			)
			))
            /* TODO - Faltaria ver la asociacion con Consigna*/
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
}