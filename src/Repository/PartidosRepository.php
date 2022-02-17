<?php

namespace App\Repository;
use App\Entity\Equipos;
use Doctrine\ORM\EntityRepository;

class PartidosRepository extends EntityRepository
{

    public function findResultsByLocalTeam(Equipos $team){

        $query = $this->getEntityManager()
            ->createQuery("SELECT p  FROM App:Partidos p WHERE p.equipoLocal = :teamIn");
        $query->setParameter('teamIn', $team->getNombre());

        $arrayResult[$team->getNombre()] = $query->getArrayResult();

        return $arrayResult;

    }
    public function findResultsByVisitorTeam(Equipos $team){

        $query = $this->getEntityManager()
            ->createQuery("SELECT p  FROM App:Partidos p WHERE p.equipoVisitante = :teamIn");
        $query->setParameter('teamIn', $team->getNombre());

        $arrayResult[$team->getNombre()] = $query->getArrayResult();

        return $arrayResult;

    }
    public function findMediaResultsByLocalTeam(Equipos $team){

        $res = $this->findResultsByVisitorTeam($team);

        $media = 0;

        foreach ($res[$team->getNombre()] as $iter){

            $media += $iter["puntosLocal"];
        }

        $media /= count($res[$team->getNombre()]);

        $arrayRes[$team->getNombre()] = $media;

        return $arrayRes;

    }

    public function findMediaResultsByVisitorTeam(Equipos $team){

        $res = $this->findResultsByVisitorTeam($team);

        $media = 0;

        foreach ($res[$team->getNombre()] as $iter){

            $media += $iter["puntosVisitante"];
        }

        $media /= count($res[$team->getNombre()]);

        $arrayRes[$team->getNombre()] = $media;

        return $arrayRes;

    }

}