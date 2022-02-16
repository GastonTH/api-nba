<?php

namespace App\Controller;
use App\Entity\Jugadores;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JugadoresController extends AbstractController
{

    public function getPlayers(){
        $teamRes = $this->getDoctrine()->getRepository(Jugadores::class)
            ->findPlayers();
        return new JsonResponse($teamRes);
    }

    public function getPlayerByName(Request $request){

        $player = $request ->get('nombre');
        $playerObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Jugadores::class)
            ->findOneBy(['nombre' => $player]);

        $playerRes = $this->getDoctrine()->getRepository(Jugadores::class)
            ->findPlayerByName($playerObjs);
        return new JsonResponse($playerRes);
    }

    public function getPlayerByNameKgCm(Request $request){

        $player = $request ->get('nombre');
        $playerObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Jugadores::class)
            ->findOneBy(['nombre' => $player]);

        $playerRes = $this->getDoctrine()->getRepository(Jugadores::class)
            ->findPlayerByNameKgCm($playerObjs);
        return new JsonResponse($playerRes);
    }

}