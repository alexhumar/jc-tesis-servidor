<?php
namespace JuegoPostas\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RespuestaRepository extends EntityRepository
{
	
	/**
	 * Retorna las respuestas de la consulta que se recibe como parametro
	 * 
	 * */
	public function respuestasAConsulta($consulta) {
		$qbRespuesta = $this->createQueryBuilder('respuesta');
		
		return $qbRespuesta
			->select('respuesta')
			->join('respuesta.consulta', 'consulta')
			->where($qbRespuesta->expr()->eq('consulta', ':consulta'))
			->setParameter('consulta', $consulta)
			->getQuery()
			->getResult();
	}
	
}