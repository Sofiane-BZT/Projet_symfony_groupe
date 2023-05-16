<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\UtilisateursType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class UtilisateursController extends AbstractController
{
    #[Route('/utilisateurs', name: 'app_utilisateurs')]
    public function index(UtilisateursRepository $utilisateurs)
    {

        $utiliRepo = $utilisateurs->findAll();

        return $this->render('utilisateurs/index.html.twig', [
            'Utilisateurs' =>  $utiliRepo,
        ]);
    }


    #[Route('/utilisateur/{id}', name: 'utilisateur_edit')]
    public function edit(int $id ,UtilisateursRepository $utilisateur)
    {

        $utiliRepo = $utilisateur->find($id);

        return $this->render('utilisateurs/edit.html.twig', [
            'utilisateur' =>  $utiliRepo,
        ]);
    }
    
    #[Route('/forme', name: 'forme')]
    public function forme(Request $request, EntityManagerInterface $em): Response
    {
        $utilisateurs=new Utilisateurs();
        $form=$this->createForm(UtilisateursType::class, $utilisateurs);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em->persist($utilisateurs);
            $em->flush();
            dump($utilisateurs);
            die;
        }

        return $this->render('utilisateurs/formulaire.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
