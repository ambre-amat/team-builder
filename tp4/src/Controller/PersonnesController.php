<?php

namespace App\Controller;

use App\Entity\Personnes;
use App\Repository\PersonnesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonnesController extends AbstractController
{
    /**
     * @Route("/personnes", name="add_personnes", methods={"POST"})
     */
    public function addPersonne(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent());

        $personne= new Personnes;
        $personne->setNom($data->nom);
        $personne->setPrenom($data->prenom);
        $personne->setEquipes($data->equipes);
        $em->persist($personne);
        $em->flush();

        $tab["id"]=$personne->getId();
        return $this->json($tab);
        
    }

    /**
     * @Route("/personnes/{id}", name="delete_personnes", methods={"DELETE"})
     */
    public function deletePersonne(Personnes $personne, EntityManagerInterface $em): Response
    {
        $em->remove($personne);
        $em->flush();

        $tab["delete"]="ok";
        return $this->json($tab);
    }

    /**
     * @Route("/personnes", name="list_personnes", methods={"GET})
     */
    public function allPersonnes(PersonnesRepository $repo): Response
    {
        return $this->json($repo->findAll());
    }
    
}
