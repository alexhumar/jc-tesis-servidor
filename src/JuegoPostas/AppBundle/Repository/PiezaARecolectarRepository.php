<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use JuegoPostas\AppBundle\JuegoPostasAppBundle;

class PiezaARecolectarRepository extends EntityRepository
{
	
	/**
	 * Retorna la query que consulta aquellas Piezas que no tengan un POI relacionado.
	 * 
	 * @param JuegoPostasAppBundle\Entity\PiezaARecolectar $piezaPredefinida 
	 * 
	 * */
	public function piezasSinPoiQuery($piezaPredefinida = null) {
		$qbPiezaARecolectar = $this->createQueryBuilder('piezaarecolectar');
		$qbPoi = $this->getEntityManager()->getRepository('JuegoPostasAppBundle:Poi')->createQueryBuilder('poi');
	
		$builder = $qbPiezaARecolectar
			->select('piezaarecolectar')
			->where($qbPiezaARecolectar->expr()->not($qbPiezaARecolectar->expr()->exists(
								$qbPoi
									->select('poi')
									->where($qbPoi->expr()->eq('poi.piezaARecolectar', 'piezaarecolectar.id'))
									->getDQL()
							))
						);
		if($piezaPredefinida)
			$builder->orWhere($qbPiezaARecolectar->expr()->eq('piezaarecolectar.id', ':id'))->setParameter('id', $piezaPredefinida->getId());
			
		return	$builder->getQuery();
	}
	
}