<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ConsultaRepository extends EntityRepository
{
	
	/*Retorna, en caso de existir, una consulta sin respuesta que haya realizado un subgrupo distinto al
	 * recibido como parametro */
	public function consultaSinRespuestaDeSubgrupoDistintoA($subgrupo) {
		$qbConsulta = $this->createQueryBuilder('consulta');
		$qbRespuesta = $this->createQueryBuilder('respuesta');
			
		try {
			$qbConsulta
				->select('consulta')
				->join('consulta.posta', 'posta')
				->join('posta.subgrupo', 'subgrupo')
				->where($qbConsulta->expr()->andx(
							$qbConsulta->expr()->neq('subgrupo', ':subgrupo'),
							$qbConsulta->expr()->not($qbConsulta->expr()->exists(
								$qbRespuesta
									->select('respuesta')
									->from('JuegoPostasAppBundle:Respuesta', 'respuesta')
									->where($qbRespuesta->expr()->eq('respuesta.consulta', 'consulta.ID'))
									->getQuery()
							))
				))
				->setParameter('subgrupo', $subgrupo)
				->getQuery()
				->getSingleResult();
		} catch (NoResultException $e) {
			return null;
		}
	}
	
}