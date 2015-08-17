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
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre')
            ->add('descripcion', 'text', array('label' => 'Descripcion'))
			->add('piezasARecolectar', 'sonata_type_model',
            array(
                'multiple' => true
            ));
            /* FIXME - Explota cuando la cantidad es muy grande, no deberia molestar por ahora. */
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
            ->add('nombre')
        ;
    }
}