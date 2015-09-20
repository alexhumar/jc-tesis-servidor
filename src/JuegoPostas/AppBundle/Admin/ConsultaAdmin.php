<?php
// src/JuegoPostas/AppBundle/Admin/ConsultaAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ConsultaAdmin extends Admin
{
	protected $baseRouteName = 'sonata_consulta';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
			->add('decisionParcial', null, array('required' => true))
			->add('posta', null, array('required' => true))
        ;
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('decisionParcial')
            ->add('posta')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('decisionParcial.cumpleConsigna', null, array('label' => 'Cumple la consigna'))
            ->add('decisionParcial.justificacion',  null, array('label' => 'Justificacion'))
			->add('posta.nombre',  null, array('label' => 'Posta'))
			->add('_action', 'actions', array(
					'actions' => array(
							'edit' => array(),
					)
			))
        ;
    }
}