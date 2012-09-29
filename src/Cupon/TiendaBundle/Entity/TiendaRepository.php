<?php
namespace Cupon\TiendaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class TiendaRepository extends EntityRepository
{
    public function findUltimasOfertasPublicadas($tienda_id, $limite = 10)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT o, t
                FROM OfertaBundle:Oferta o
                JOIN o.tienda t
                WHERE o.revisada = true
                AND o.fecha_publicacion < :fecha
                AND o.tienda = :id
                ORDER BY o.fecha_publicacion DESC';

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('fecha', new \DateTime('now'));
        $consulta->setParameter('id', $tienda_id);
        $consulta->setMaxResults($limite);

        return $consulta->getResult();
    }

    public function findCercanas($tienda, $ciudad)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT t
                FROM TiendaBundle:Tienda t
                JOIN t.ciudad c
                WHERE t.slug != :tienda
                AND c.slug = :ciudad';

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('tienda', $tienda);
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(5);

        return $consulta->getResult();
    }
}