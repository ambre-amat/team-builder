<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Repository\EquipesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;  

class EquipesController extends AbstractController
{
    /**
     * @Route("/equipes", name="add_equipes", methods={"POST"})
     */
    public function addEquipe(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent());

        $equipe = new Equipes;
        $equipe->setNom($data->nom);
        $em->persist($equipe);
        $em->flush();

        $tab["id"]=$equipe->getId();
        return $this->json($tab);
    }

    /**
     * @Route("/equipes/{id}", name="delete_equipes", methods={"DELETE"})
     */
    public function deleteEquipe(Equipes $equipe, EntityManagerInterface $em): Response
    {
        $em->remove($equipe);
        $em->flush();
        $tab["delete"]="ok";
        return $this->json($tab);
    }

    /**
     * @Route("/equipes", name="list_equipe", methods={"GET"})
     */
    public function allEquipe(EquipesRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }
}   
