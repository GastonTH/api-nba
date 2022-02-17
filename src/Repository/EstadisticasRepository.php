<?php

namespace App\Repository;
use App\Entity\Jugadores;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

class EstadisticasRepository extends EntityRepository
{
    /**@author
     * @var JugadoresRepository
     */
    private $jugadoresRepository;

    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct($em, $class);

        $this->jugadoresRepository = $em->getRepository(Jugadores::class);
    }

    public function findStadisticsByPlayerName(Jugadores $player){

        $playerIn=$this->jugadoresRepository->findPlayerByName($player);

        $query = $this->getEntityManager()
            ->createQuery("SELECT e FROM App:Estadisticas e WHERE e.jugador = :codeIn");
        $query->setParameter('codeIn', $playerIn["codigo"]);

        $result = $query->getArrayResult();
        $arrayStadistics = array();
        //$arrayResult[$playerIn["nombre"]] = $result[0];
        //$arrayResult[$playerIn["nombre"]]

        foreach ($result as $iter){

            $arrayStadistics[$iter["temporada"]] = [

                "puntos_por_partido" => $iter["puntosPorPartido"],
                "asistencias_por_partido" => $iter["asistenciasPorPartido"],
                "tapones_por_partido" => $iter["taponesPorPartido"],
                "rebotes_por_partido" => $iter["rebotesPorPartido"]

            ];

        }

        $arrayResult = array( $playerIn["nombre"] => $arrayStadistics);
        return $arrayResult;

    }

    public function findStadisticsAvgByPlayerByName(Jugadores $player){

        $resultInfo = $this->findStadisticsByPlayerName($player);

        $playerName = $player->getNombre();

        $statPPP = 0;
        $statAPP = 0;
        $statTPP = 0;
        $statRPP = 0;

        foreach ($resultInfo[$playerName] as $a){

            $statPPP += $a["puntos_por_partido"];
            $statAPP += $a["asistencias_por_partido"];
            $statTPP += $a["tapones_por_partido"];
            $statRPP += $a["rebotes_por_partido"];
        }

        $statPPP /= count($resultInfo[$playerName]);
        $statAPP /= count($resultInfo[$playerName]);
        $statTPP /= count($resultInfo[$playerName]);
        $statRPP /= count($resultInfo[$playerName]);

        $resultArray[$playerName] = [

            "puntos_por_partido" => $statPPP,
            "asistencias_por_partido" => $statAPP,
            "tapones_por_partido" => $statTPP,
            "rebotes_por_partido" => $statRPP

        ];

        return $resultArray;

    }

}