<?php

namespace App\Repository;

use App\Entity\Equipos;
use Doctrine\ORM\EntityRepository;

class EquiposRepository extends EntityRepository
{

    public function findAllTeams(){

        // instancio la 'query' para que devuelva todos los equipos
        $dql = "SELECT e FROM App:Equipos e";
        $query = $this->getEntityManager()->createQuery($dql);

        return $query->getArrayResult();

    }

    public function findTeamByName(Equipos $nombreIn){

        // instancio la 'query' que devuelve
        $query = $this->getEntityManager()->createQuery("SELECT e.nombre, e.ciudad, e.conferencia, e.division FROM App:Equipos e WHERE e.nombre = :nombreIn");
        $query->setParameter('nombreIn', $nombreIn->getNombre());

        $result = $query->getArrayResult();

        return $result[0];

    }

    public function findAllPlayerByTeam(){

        $allInfoArray = array();

        $arrayTeams = $this->findAllTeams();

        foreach ($arrayTeams as $iterate){

            $query = $this->getEntityManager()->createQuery("SELECT j FROM App:Jugadores j WHERE j.nombreEquipo = :nombreIn");
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

        $res[$nombreIn->getNombre()] = $query->getArrayResult();

        return $res;

    }

}