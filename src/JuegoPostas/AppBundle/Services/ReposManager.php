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
}