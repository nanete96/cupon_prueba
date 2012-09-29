<?php
namespace Cupon\UsuarioBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    public function findTodasLasCompras($usuario_id)
    {
        $em = $this->getEntityManager();

        $dql = 'SELECT v, o, t
                FROM OfertaBundle:Venta v
                JOIN v.oferta o JOIN o.tienda t
                WHERE v.usuario != :id
                ORDER BY v.fecha DESC';

        $consulta = $em->createQuery($dql);
        $consulta->setParameter('id', $usuario_id);

        return $consulta->getResult();
    }
}
