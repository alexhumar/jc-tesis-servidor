<?php
// src/JuegoPostas/AppBundle/Admin/RespuestaAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RespuestaAdmin extends Admin
{
	protected $baseRouteName = 'sonata_respuesta';
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('acuerdoPropuesta', 'choice', array(
            		'label' => 'Esta de acuerdo con la propuesta?',
            		'choices' => array(
            				0 => 'No',
            				1 => 'Si'
            )))
			->add('justificacion')
			->add('consulta', null, array('required' => true))
            ->add('subgrupoConsultado', null, array('label' => 'Subgrupo consultado', 'required' => true))
        ;
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('acuerdoPropuesta')
            ->add('consulta')
            ->add('subgrupoConsultado')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('consulta.decisionParcial.cumpleConsigna', null, array('label' => 'Consulta: Cumple con la consigna?'))
            ->add('consulta.decisionParcial.justificacion', null, array('label' => 'Consulta: Justificacion'))
            ->add('acuerdoPropuesta', null, array('label' => 'Respuesta: esta de acuerdo?'))
			->add('justificacion', null, array('label' => 'Respuesta: justificacion'))
            ->add('subgrupoConsultado.nombre', null, array('label' => 'Subgrupo consultado'))
            ->add('_action', 'actions', array(
            		'actions' => array(
            				'edit' => array(),
            		)
            ))
        ;
    }
}