<?php

namespace App\Repository;
use App\Entity\Jugadores;
use Doctrine\ORM\EntityRepository;

class JugadoresRepository extends EntityRepository
{

    public function findPlayers(){

        $query = $this->getEntityManager()
            ->createQuery("SELECT j FROM App:Jugadores j");

        return $query->getArrayResult();

    }

    public function findPlayerByName(Jugadores $playerIn){

        if (str_contains($playerIn->getNombre(), '%20')){
            $str = str_replace("%20", " ", $playerIn->getNombre());
            $playerIn->setNombre($str);
        }

        $query = $this->getEntityManager()
            ->createQuery("SELECT j FROM App:Jugadores j WHERE j.nombre = :playerName");
        $query->setParameter('playerName', $playerIn->getNombre());

        $res =  $query->getArrayResult();
        return $res[0];
    }

    public function findPlayerByNameKgCm(Jugadores $playerIn){

        if (str_contains($playerIn->getNombre(), '%20')){
            $str = str_replace("%20", " ", $playerIn->getNombre());
            $playerIn->setNombre($str);
        }

        $query = $this->getEntityManager()
            ->createQuery("SELECT j.nombre, j.altura, j.peso FROM App:Jugadores j WHERE j.nombre = :playerName");
        $query->setParameter('playerName', $playerIn->getNombre());

        $response =  $query->getArrayResult();

        // ----

        $peso = $response[0]["peso"];
        $response[0]["peso"] = floatval($peso) * 0.453592;

        $altura = explode("-",$response[0]["altura"]);
        $response[0]["altura"] = (floatval($altura[0]*12)*2.54) + (($altura[1]*2.54));

        return $response[0];
    }

}