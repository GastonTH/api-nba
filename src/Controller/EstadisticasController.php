<?php

namespace App\Controller;
use App\Entity\Estadisticas;
use App\Entity\Jugadores;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EstadisticasController extends AbstractController
{
    public function getStadisticsPlayerByName(Request $request){

        $player = $request ->get('nombre');

        $playerObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Jugadores::class)
            ->findOneBy(['nombre' => $player]);

        $estadistics = $this->getDoctrine()->getRepository(Estadisticas::class)
            ->findStadisticsByPlayerName($playerObjs);

        return new JsonResponse($estadistics);
    }

    public function getStadisticsAvgByPlayerByName(Request $request){

        $player = $request ->get('nombre');

        $playerObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Jugadores::class)
            ->findOneBy(['nombre' => $player]);

        $estadistics = $this->getDoctrine()->getRepository(Estadisticas::class)
            ->findStadisticsAvgByPlayerByName($playerObjs);

        return new JsonResponse($estadistics);

    }
}