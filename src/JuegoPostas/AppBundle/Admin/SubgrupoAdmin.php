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
	
	//Funcion que se ejecuta antes de persistir una entidad
	public function prePersist($subgrupo)
	{
		//$this->preUpdate($subgrupo);
	}
	
	//Funcion que se ejecuta antes de editar una entidad
	public function preUpdate($subgrupo)
	{
		//Se hace esto para setear la inversa de la relacion.
		//$subgrupo->setParticipantes($subgrupo->getParticipantes());
	}
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('grupo', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\Grupo', 'required'=>false))
            ->add('estado', 'entity', array('class' => 'JuegoPostas\AppBundle\Entity\EstadoSubgrupo', 'required'=>false))
			->add('participantes', 'sonata_type_model',
            array(
                'multiple' => true,
				'by_reference'=>false)
            )
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