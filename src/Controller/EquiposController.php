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
}