<?php
// src/JuegoPostas/AppBundle/Admin/PoiAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class PoiAdmin extends Admin
{
	protected $baseRouteName = 'sonata_poi';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            /*Alex - Dejo que sonata reconozca las coordenadas como float*/
            ->add('coordenadaX', null, array('label' => 'Coordenada X'))
            ->add('coordenadaY', null, array('label' => 'Coordenada Y'))
            ->add('piezaARecolectar', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\PiezaARecolectar'))
        ;
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('coordenadaX')
            ->add('coordenadaY')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('coordenadaX')
            ->add('coordenadaY')
        ;
    }
}