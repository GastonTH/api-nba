<?php

namespace App\Controller;

use App\Entity\Equipos;
use App\Entity\Partidos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PartidosController extends AbstractController
{
    public function getResultsByLocalTeam(Request $request){

        $team = $request ->get('nombre');
        $teamObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Equipos::class)
            ->findOneBy(['nombre' => $team]);

        $teamRes = $this->getDoctrine()->getRepository(Partidos::class)
            ->findResultsByLocalTeam($teamObjs);

        return new JsonResponse($teamRes);

    }

    public function getResultsByVisitorTeam(Request $request){

        $team = $request ->get('nombre');
        $teamObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Equipos::class)
            ->findOneBy(['nombre' => $team]);

        $teamRes = $this->getDoctrine()->getRepository(Partidos::class)
            ->findResultsByVisitorTeam($teamObjs);

        return new JsonResponse($teamRes);

    }

    public function getMediaResultsByLocalTeam(Request $request){

        $team = $request ->get('nombre');
        $teamObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Equipos::class)
            ->findOneBy(['nombre' => $team]);

        $teamRes = $this->getDoctrine()->getRepository(Partidos::class)
            ->findMediaResultsByLocalTeam($teamObjs);

        return new JsonResponse($teamRes);

    }
    public function getMediaResultsByVisitorTeam(Request $request){

        $team = $request ->get('nombre');
        $teamObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Equipos::class)
            ->findOneBy(['nombre' => $team]);

        $teamRes = $this->getDoctrine()->getRepository(Partidos::class)
            ->findMediaResultsByVisitorTeam($teamObjs);

        return new JsonResponse($teamRes);

    }
}