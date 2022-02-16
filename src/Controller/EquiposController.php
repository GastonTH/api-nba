<?php

namespace App\Controller;
use App\Entity\Equipos;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class EquiposController extends AbstractController
{
    public function getAllTeams(){

        $teams = $this->getDoctrine()->getRepository(Equipos::class)
            ->findAllTeams();
        return new JsonResponse($teams);
    }

    public function getTeamByName(Request $request){

        $team = $request ->get('nombre');
        $teamObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Equipos::class)
            ->findOneBy(['nombre' => $team]);

        $teamRes = $this->getDoctrine()->getRepository(Equipos::class)
            ->findTeamByName($teamObjs);
        return new JsonResponse($teamRes);
    }

    public function getAllPlayersByTeams(){
        $teamRes = $this->getDoctrine()->getRepository(Equipos::class)
            ->findAllPlayerByTeam();
        return new JsonResponse($teamRes);
    }

    public function getPlayersByTeam(Request $request){

        $team = $request ->get('nombre');
        $teamObjs = $this->getDoctrine()
            ->getManager()
            ->getRepository(Equipos::class)
            ->findOneBy(['nombre' => $team]);

        $teamRes = $this->getDoctrine()->getRepository(Equipos::class)
            ->findPlayersByTeam($teamObjs);
        return new JsonResponse($teamRes);
    }

}