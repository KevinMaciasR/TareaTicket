<?php

namespace App\Controller;

use App\Entity\Referenciasprecios;
use App\Form\ReferenciaspreciosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/referenciasprecios')]
class ReferenciaspreciosController extends AbstractController
{
    #[Route('/', name: 'app_referenciasprecios_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $referenciasprecios = $entityManager
            ->getRepository(Referenciasprecios::class)
            ->findAll();

        return $this->render('referenciasprecios/index.html.twig', [
            'referenciasprecios' => $referenciasprecios,
        ]);
    }

    #[Route('/new', name: 'app_referenciasprecios_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $referenciasprecio = new Referenciasprecios();
        $form = $this->createForm(ReferenciaspreciosType::class, $referenciasprecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($referenciasprecio);
            $entityManager->flush();

            return $this->redirectToRoute('app_referenciasprecios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('referenciasprecios/new.html.twig', [
            'referenciasprecio' => $referenciasprecio,
            'form' => $form,
        ]);
    }

    #[Route('/{idReferencia}', name: 'app_referenciasprecios_show', methods: ['GET'])]
    public function show(Referenciasprecios $referenciasprecio): Response
    {
        return $this->render('referenciasprecios/show.html.twig', [
            'referenciasprecio' => $referenciasprecio,
        ]);
    }

    #[Route('/{idReferencia}/edit', name: 'app_referenciasprecios_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Referenciasprecios $referenciasprecio, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReferenciaspreciosType::class, $referenciasprecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_referenciasprecios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('referenciasprecios/edit.html.twig', [
            'referenciasprecio' => $referenciasprecio,
            'form' => $form,
        ]);
    }

    #[Route('/{idReferencia}', name: 'app_referenciasprecios_delete', methods: ['POST'])]
    public function delete(Request $request, Referenciasprecios $referenciasprecio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$referenciasprecio->getIdReferencia(), $request->request->get('_token'))) {
            $entityManager->remove($referenciasprecio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_referenciasprecios_index', [], Response::HTTP_SEE_OTHER);
    }
}
