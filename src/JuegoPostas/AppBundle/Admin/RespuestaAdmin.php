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
            ->add('acuerdoRespuesta', null, array('label' => 'Esta de acuerdo con la respuesta?'))
			->add('justificacion')
			->add('consulta')
            ->add('subgrupoConsultado', null, array('label' => 'Subgrupo consultado'))
        ;
    }

    // Campos que deben mostrarse en los forms de filtro
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('consulta')
        ;
    }

    // Campos que deben mostrarse en los listados
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('acuerdoRespuesta', null, array('label' => 'Esta de acuerdo con la respuesta?'))
			->add('justificacion')
			->add('consulta')
            ->add('subgrupoConsultado', null, array('label' => 'Subgrupo consultado'))
        ;
    }
}