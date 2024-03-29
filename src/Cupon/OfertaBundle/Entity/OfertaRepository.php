<?php
namespace Cupon\OfertaBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OfertaRepository extends EntityRepository
{
    public function findOfertaDelDia($ciudad)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT o, c, t
                FROM OfertaBundle:Oferta o
                JOIN o.ciudad c JOIN o.tienda t
                WHERE o.revisada = true
                AND o.fecha_publicacion < :fecha
                AND c.slug = :ciudad
                ORDER BY o.fecha_publicacion DESC';

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('fecha', new \DateTime('now'));
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(1);

        return $consulta->getSingleResult();
    }


    public function findOferta($ciudad, $slug){
        $em = $this->getEntityManager();

        $dql =  'SELECT o, c, t
                FROM OfertaBundle:Oferta o
                JOIN o.ciudad c JOIN o.tienda t
                WHERE o.revisada = true
                AND o.slug = :slug
                AND c.slug = :ciudad';

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('slug', $slug);
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(1);

        return $consulta->getSingleResult();
    }

    public function findRelacionadas($ciudad)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT o, c, t
                FROM OfertaBundle:Oferta o
                JOIN o.ciudad c JOIN o.tienda t
                WHERE o.revisada = true
                AND o.fecha_publicacion <= :fecha
                AND c.slug != :ciudad
                ORDER BY o.fecha_publicacion DESC';

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('fecha', new \DateTime('now'));
        $consulta->setParameter('ciudad', $ciudad);
        $consulta->setMaxResults(5);

        return $consulta->getResult();
    }

    public function findRecientes($ciudad_id)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT o, t
                FROM OfertaBundle:Oferta o
                JOIN o.tienda t
                WHERE o.revisada = true
                AND o.fecha_publicacion <= :fecha
                AND o.ciudad = :id
                ORDER BY o.fecha_publicacion DESC';

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('fecha', new \DateTime('now'));
        $consulta->setParameter('id', $ciudad_id);
        $consulta->setMaxResults(5);

        return $consulta->getResult();
    }

}
