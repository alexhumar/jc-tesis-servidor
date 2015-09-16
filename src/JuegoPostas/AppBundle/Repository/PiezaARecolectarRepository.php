<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class PiezaARecolectarRepository extends EntityRepository
{
	
	/**
	 * Retorna la query que consulta aquellas Piezas que no tengan un POI relacionado.
	 * 
	 * */
	public function piezasSinPoiQuery() {
		$qbPiezaARecolectar = $this->createQueryBuilder('piezaarecolectar');
		$qbPoi = $this->getEntityManager()->getRepository('JuegoPostasAppBundle:Poi')->createQueryBuilder('poi');
		try {
			return $qbPiezaARecolectar
				->select('piezaarecolectar')
				->where($qbPiezaARecolectar->expr()->not($qbPiezaARecolectar->expr()->exists(
									$qbPoi
										->select('poi')
										->where($qbPoi->expr()->eq('poi.piezaARecolectar', 'piezaarecolectar.id'))
										->getDQL()
								))
							)
				->getQuery();
		} catch (NoResultException $e) {
			return null;
		}
	}
	
}