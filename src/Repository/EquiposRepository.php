<?php

namespace App\Repository;
use Doctrine\ORM\EntityRepository;

class EquiposRepository extends EntityRepository
{

    /*
     * $this->getEntityManager()
    ->createQuery('
        SELECT p
            FROM GabrielUploadBundle:Image p
            WHERE p.upvotes > '.$maxvotes.'
            ORDER BY p.createdAt ASC
    ')
    ->getSQL();*/

    public function findAllTeams(){

        $dql = "SELECT e.nombre, e.ciudad, e.conferencia, e.division FROM App:Equipos e";
        $query = $this->getEntityManager()->createQuery($dql);

        return $query->getArrayResult();

    }

    public function findTeamByName(string $nombreIn){

        $query = $this->getEntityManager()->createQuery("SELECT e.nombre, e.ciudad, e.conferencia, e.division FROM Equipos:e WHEN :nombreIn");


    }

}