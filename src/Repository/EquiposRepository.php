<?php

namespace App\Repository;

use App\Entity\Equipos;
use Doctrine\ORM\EntityRepository;

class EquiposRepository extends EntityRepository
{

    public function findAllTeams(){

        $dql = "SELECT e.nombre, e.ciudad, e.conferencia, e.division FROM App:Equipos e";
        $query = $this->getEntityManager()->createQuery($dql);

        return $query->getArrayResult();

    }

    public function findTeamByName(Equipos $nombreIn){

        $query = $this->getEntityManager()->createQuery("SELECT e.nombre, e.ciudad, e.conferencia, e.division FROM App:Equipos e WHERE e.nombre = :nombreIn");
        $query->setParameter('nombreIn', $nombreIn->getNombre());

        return $query->getArrayResult();

    }

    public function findAllPlayerByTeam(){

        $allInfoArray = array();

        $arrayTeams = $this->findAllTeams();

        foreach ($arrayTeams as $iterate){

            $query = $this->getEntityManager()->createQuery("SELECT j.nombre, j.procedencia, j.posicion FROM App:Jugadores j WHERE j.nombreEquipo = :nombreIn");
            $query->setParameter('nombreIn', $iterate['nombre']);
            $res = $query->getArrayResult();
            $allInfoArray[$iterate['nombre']] = $res;
        }

        return $allInfoArray;

    }

    public function findPlayersByTeam(Equipos $nombreIn){

        $query = $this->getEntityManager()
            ->createQuery("SELECT j.codigo, j.nombre, j.procedencia, j.altura, j.peso, j.posicion FROM App:Jugadores j WHERE j.nombreEquipo = :nombreIn");
        $query->setParameter('nombreIn', $nombreIn->getNombre());

        return $query->getArrayResult();

    }

}