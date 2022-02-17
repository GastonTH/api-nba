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

        $result = $this->findPlayerByName($playerIn);

        $peso = $result["peso"];
        $result["peso"] = floatval($peso) * 0.453592;

        $altura = explode("-",$result["altura"]);
        $result["altura"] = (floatval($altura[0]*12)*2.54) + (($altura[1]*2.54));

        return $result[0];
    }

}