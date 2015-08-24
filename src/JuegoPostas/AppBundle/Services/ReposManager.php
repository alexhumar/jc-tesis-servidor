<?php
namespace JuegoPostas\AppBundle\Services;

use Doctrine\ORM\EntityManager;

class ReposManager
{
	protected $em;
	
	public function __construct(EntityManager $entitymanager)
	{
		$this->em = $entitymanager;
	}
	
	public function getEntityManager()
	{
		return $this->em;
	}
	
	public function getSubgrupoRepo()
	{
		return $this->getEntityManager()->getRepository('JuegoPostasAppBundle:Subgrupo');
	}
	
	public function getPostaRepo() {
		return $this->getEntityManager()->getRepository('JuegoPostasAppBundle:Posta');
	}
	
	public function getEstadoSubgrupoRepo() {
		return $this->getEntityManager()->getRepository('JuegoPostasAppBundle:EstadoSubgrupo');
	}
	
	public function getConsultaRepo() {
		return $this->getEntityManager()->getRepository('JuegoPostasAppBundle:Consulta');
	}
}