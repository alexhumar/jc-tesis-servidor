<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class PostaRepository extends EntityRepository
{
	
	/*Retorna el poi que tiene asignado un determinado subgrupo*/
	public function getPostaDeSubgrupo($subgrupo)
	{
		try {
			return $this
				->createQueryBuilder('posta')
				->join('posta.subgrupo', 'subgrupo')
				->where('subgrupo = :subgrupo')
				->setParameter('subgrupo', $subgrupo)
				->getQuery()
				->getSingleResult(); //getSingleResult arroja una exepcion si la consulta no devuelve resultado
		} catch (NoResultException $e) {
			return null;
		}
	}
	
}