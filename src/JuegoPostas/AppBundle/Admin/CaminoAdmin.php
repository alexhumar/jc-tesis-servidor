<?php
// src/JuegoPostas/AppBundle/Admin/CaminoAdmin.php

namespace JuegoPostas\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

use JuegoPostas\AppBundle\Entity\Posta;
use JuegoPostas\AppBundle\Entity\Poi;
use Sonata\AdminBundle\Tests\DependencyInjection\Post;
use Doctrine\Common\Collections\ArrayCollection;

class CaminoAdmin extends Admin
{
	const __DEFAULT_LAT = -34.92056351681724;
	const __DEFAULT_LNG = -57.95356750488281;
	
	protected $baseRouteName = 'sonata_camino';
	
	public function preUpdate($camino){
		$grupo = $camino->getGrupo();
		$posta = $camino->getPrimerPosta();
		/* Seteo la consigna del grupo a todas las piezas a recolectar de las postas del camino */
		while($posta != null){
			$posta->getPoi()->getPiezaARecolectar()->setConsigna($grupo->getConsigna());
			$posta = $posta->getPostaSiguiente();
		}
		
	}
	
	// Metodo para validaciones especificas
	public function validate(ErrorElement $errorElement, $camino)
	{
		$posta = $camino->getPrimerPosta();
		$subgrupos = new ArrayCollection();
		$piezas = new ArrayCollection();
		while($posta != null){
			$subgrupo = $posta->getSubgrupo();
			$pieza = $posta->getPoi()->getPiezaARecolectar();
			if ($subgrupos->contains($subgrupo)){
				$posta = null;
				$errorElement->with('subgrupo')->addViolation('No pueden existir dos postas con el mismo subgrupo.')->end();
			}else{
				$posta = $posta->getPostaSiguiente();
				$subgrupos->add($subgrupo);
			}
			if ($piezas->contains($pieza)){
				$posta = null;
				$errorElement->with('subgrupo')->addViolation('No pueden existir dos postas con la misma pieza a recolectar.')->end();
			}else{
				$piezas->add($pieza);
			}
		}
	}
	
    // Campos que deben mostrarse en los forms de creacion/edicion
    protected function configureFormFields(FormMapper $formMapper)
    {
    	$camino = $this->getSubject();
    	if ($camino->isNew()){
    		//El objeto es nuevo por lo tanto estoy en el create del formulario.
    		$formMapper->with('Camino', array('description' => '<h3>Las postas se agregaran a continuaci&oacute;n.</h3>'))
	    		->add('grupo', null, array('required' => true))
	    		->add('descripcion', 'text', array('label' => 'Descripcion'))
    		;
    	}else{
    		//El objeto ya fue creado, por lo tanto estoy en el edit.
    		$formMapper
	    		->add('primerPosta', 'sonata_type_admin',array(
	    				'delete' => false,
	    				'btn_add' => false,
	    		),array())
    		;
    		
    	}
        
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