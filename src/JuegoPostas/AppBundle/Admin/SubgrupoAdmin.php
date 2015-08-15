<?php
// src/JuegoPostas/AppBundle/Admin/SubgrupoAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class SubgrupoAdmin extends Admin
{
	protected $baseRouteName = 'sonata_subgrupo';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('grupo', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Grupo'))
            ->add('estado', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\EstadoSubgrupo'))
			->add('participantes');
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