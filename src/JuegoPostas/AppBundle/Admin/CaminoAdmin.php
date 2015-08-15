<?php
// src/JuegoPostas/AppBundle/Admin/CaminoAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CaminoAdmin extends Admin
{
	protected $baseRouteName = 'sonata_camino';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('descripcion', 'text', array('label' => 'Descripcion'))
            ->add('primerPosta', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Posta'))
        ;
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