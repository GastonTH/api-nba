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

        $localOrVisitor = "local";

        $team = $request ->get('nombre');
        $teamObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Equipos::class)
            ->findOneBy(['nombre' => $team]);

        $teamRes = $this->getDoctrine()->getRepository(Partidos::class)
            ->findResultsByLocalTeam($teamObjs, $localOrVisitor);

        return new JsonResponse($teamRes);

    }

    public function getResultsByVisitorTeam(Request $request){}
    public function getMediaResultsByLocalTeam(Request $request){}
    public function getMediaResultsByVisitorTeam(Request $request){}
}