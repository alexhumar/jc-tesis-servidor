<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SubgrupoRepository extends EntityRepository
{
	
	/*Retorna los subgrupos de un determinado grupo*/
	public function getSubgruposDeGrupo($grupo)
	{
		return $this
		         ->createQueryBuilder('subgrupo')
		         ->select('subgrupo')
		         ->join('subgrupo.grupo', 'grupo')
		         ->where('grupo = :grupo')
		         ->setParameter('grupo', $grupo)
		         ->orderBy('subgrupo.id')
		         ->getQuery()
		         ->getResult();
	}
	
}