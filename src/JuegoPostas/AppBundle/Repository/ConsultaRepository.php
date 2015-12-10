<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class ConsultaRepository extends EntityRepository
{
	
	/**
	 * Retorna, en caso de existir, una consulta que no fue respondida por el subgrupo recibido como parametro y
	 *  que haya realizado un subgrupo distinto al recibido como parametro, pero que sea del mismo grupo.
	 * 
	 * */
	public function consultaSinRespuestaDeSubgrupoDistintoA($subgrupo) {
		$qbConsulta = $this->createQueryBuilder('consulta');
		$qbRespuesta = $this->getEntityManager()->getRepository('JuegoPostasAppBundle:Respuesta')->createQueryBuilder('respuesta');
		try {
			return $qbConsulta
				->select('consulta')
				->join('consulta.posta', 'posta')
				->join('posta.subgrupo', 'subgrupo')
				->join('subgrupo.grupo', 'grupo')
				->where($qbConsulta->expr()->andx(
							$qbConsulta->expr()->eq('grupo', ':grupo'),
							$qbConsulta->expr()->andX(
								$qbConsulta->expr()->neq('subgrupo', ':subgrupo'),
								$qbConsulta->expr()->not($qbConsulta->expr()->exists(
									$qbRespuesta
										->select('respuesta')
										->join('respuesta.consulta', 'rspcons')
										->join('respuesta.subgrupoConsultado', 'rspsubgrupoc')
										->where($qbRespuesta->expr()->andX(
												    $qbRespuesta->expr()->eq('rspcons.id', 'consulta.id'),
												    $qbRespuesta->expr()->eq('rspsubgrupoc', ':rspsubgrupoc')
												)
										  )
										->getDQL()
								))
							)
				))
				->setParameter('subgrupo', $subgrupo)
				->setParameter('grupo', $subgrupo->getGrupo())
				->setParameter('rspsubgrupoc', $subgrupo)
				->getQuery()
				->setMaxResults(1)
				->getSingleResult();
		} catch (NoResultException $e) {
			return null;
		}
	}
	
	/**
	 * Retorna la consulta del subgrupo recibido como parametro
	 * 
	 * */
	public function consultaDeSubgrupo($subgrupo) {
		try {
			$qbConsulta = $this->createQueryBuilder('consulta');
			return $qbConsulta
				->select('consulta')
				->join('consulta.posta', 'posta')
				->join('posta.subgrupo', 'subgrupo')
				->where($qbConsulta->expr()->eq('subgrupo', ':subgrupo'))
				->setParameter('subgrupo', $subgrupo)
				->getQuery()
				->getSingleResult();
		} catch (NoResultException $e) {
			return null;
		}
	}
	
}