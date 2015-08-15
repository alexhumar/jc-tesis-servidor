<?php
// src/JuegoPostas/AppBundle/Admin/DecisionAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class DecisionAdmin extends Admin
{
	protected $baseRouteName = 'sonata_decision';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            /*Alex - Dejo que sonata lo reconozca como boolean*/
            ->add('cumpleConsigna', null, array('label' => 'Cumple la consigna'))
            ->add('justificacion', 'text', array('label' => 'Justificacion'))
        ;
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('justificacion')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('justificacion')
        ;
    }
}