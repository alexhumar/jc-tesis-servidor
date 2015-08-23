<?php
// src/JuegoPostas/AppBundle/Admin/GrupoAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class GrupoAdmin extends Admin
{
	protected $baseRouteName = 'sonata_grupo';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('consigna', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Consigna'))
			//Chache: Pongo el required en false sino no hay forma de agregar todas las entidades, se arma un ciclo de requireds.
            ->add('camino', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Camino','required'=>FALSE))
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