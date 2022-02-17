<?php

namespace App\Repository;
use App\Entity\Equipos;
use Doctrine\ORM\EntityRepository;

class PartidosRepository extends EntityRepository
{

    public function findResultsByLocalTeam(Equipos $team){

        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM App:Partidos p WHERE p.equipoLocal = :teamIn");
        $query->setParameter('teamIn', $team->getNombre());

        $res = $query->getArrayResult();

        return $res;

    }
    public function findResultsByVisitorTeam(Equipos $team, string $localOrVisitor){

        $query = $this->getEntityManager()
            ->createQuery("SELECT p FROM App:Partidos p WHERE p.equipoLocal = :teamIn");
        $query->setParameter('teamIn', $team->getNombre());

        $res = $query->getArrayResult();

        return $res;

    }
    public function findMediaResultsByLocalTeam(Equipos $team){

    }
    public function findMediaResultsByVisitorTeam(Equipos $team){

    }

}