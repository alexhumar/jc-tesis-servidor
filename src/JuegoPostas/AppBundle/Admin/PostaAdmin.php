<?php
// src/JuegoPostas/AppBundle/Admin/PostaAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PostaAdmin extends Admin
{
	protected $baseRouteName = 'sonata_posta';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('postaSiguiente', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Posta', 'required' => false))
            ->add('subgrupo', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Subgrupo'))
            ->add('poi', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Poi'))
            ->add('decisionFinal', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Decision', 'required' => false))
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