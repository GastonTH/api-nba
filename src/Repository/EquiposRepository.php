<?php

namespace App\Repository;
use Doctrine\ORM\EntityRepository;

class EquiposRepository extends EntityRepository
{

    public function findAllTeams(){

        $dql = "SELECT e.nombre, e.ciudad, e.conferencia, e.division FROM App:Equipos e";
        $query = $this->getEntityManager()->createQuery($dql);

        return $query->getArrayResult();

    }

}