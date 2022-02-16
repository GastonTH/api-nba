<?php

namespace App\Repository;
use App\Entity\Jugadores;
use Doctrine\ORM\EntityRepository;

class JugadoresRepository extends EntityRepository
{

    public function findPlayers(){

        $query = $this->getEntityManager()
            ->createQuery("SELECT j.codigo, j.nombre, j.procedencia, j.altura, j.peso, j.posicion FROM App:Jugadores j");

        return $query->getArrayResult();

    }

    public function findPlayerByName(Jugadores $playerIn){

        if (str_contains($playerIn->getNombre(), '%20')){
            $str = str_replace("%20", " ", $playerIn->getNombre());
            $playerIn->setNombre($str);
        }

        $query = $this->getEntityManager()
            ->createQuery("SELECT j.codigo, j.nombre, j.procedencia, j.altura, j.peso, j.posicion FROM App:Jugadores j WHERE j.nombre = :playerName");
        $query->setParameter('playerName', $playerIn->getNombre());

        return $query->getArrayResult();
    }

    public function findPlayerByNameKgCm(Jugadores $playerIn){

        $result = $this->findPlayerByName($playerIn);

        $peso = $result[0]["peso"];
        $result[0]["peso"] = floatval($peso) * 0.453592;

        $altura = explode("-",$result[0]["altura"]);

        $result[0]["altura"] = (floatval($altura[0]*12)*2.54) + (($altura[1]*2.54));

        return $result[0];
    }

}