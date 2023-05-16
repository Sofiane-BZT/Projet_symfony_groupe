<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\Utilisateurs1Type;
use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateurs2')]
class Utilisateurs2Controller extends AbstractController
{
    #[Route('/', name: 'app_utilisateurs2_index', methods: ['GET'])]
    public function index(UtilisateursRepository $utilisateursRepository): Response
    {
        return $this->render('utilisateurs2/index.html.twig', [
            'utilisateurs' => $utilisateursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_utilisateurs2_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UtilisateursRepository $utilisateursRepository): Response
    {
        $utilisateur = new Utilisateurs();
        $form = $this->createForm(Utilisateurs1Type::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateursRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateurs2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateurs2/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateurs2_show', methods: ['GET'])]
    public function show(Utilisateurs $utilisateur): Response
    {
        return $this->render('utilisateurs2/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_utilisateurs2_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateurs $utilisateur, UtilisateursRepository $utilisateursRepository): Response
    {
        $form = $this->createForm(Utilisateurs1Type::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateursRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateurs2_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateurs2/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateurs2_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateurs $utilisateur, UtilisateursRepository $utilisateursRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateursRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('app_utilisateurs2_index', [], Response::HTTP_SEE_OTHER);
    }
}
