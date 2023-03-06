<?php

namespace App\Controller;

use App\Entity\Facturador;
use App\Form\Facturador1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/facturador")
 */
class FacturadorController extends AbstractController
{
    /**
     * @Route("/", name="app_facturador_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $facturadors = $entityManager
            ->getRepository(Facturador::class)
            ->findAll();

        return $this->render('facturador/index.html.twig', [
            'facturadors' => $facturadors,
        ]);
    }

    /**
     * @Route("/new", name="app_facturador_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $facturador = new Facturador();
        $form = $this->createForm(Facturador1Type::class, $facturador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($facturador);
            $entityManager->flush();

            return $this->redirectToRoute('app_facturador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('facturador/new.html.twig', [
            'facturador' => $facturador,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idFacturador}", name="app_facturador_show", methods={"GET"})
     */
    public function show(Facturador $facturador): Response
    {
        return $this->render('facturador/show.html.twig', [
            'facturador' => $facturador,
        ]);
    }

    /**
     * @Route("/{idFacturador}/edit", name="app_facturador_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Facturador $facturador, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Facturador1Type::class, $facturador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_facturador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('facturador/edit.html.twig', [
            'facturador' => $facturador,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idFacturador}", name="app_facturador_delete", methods={"POST"})
     */
    public function delete(Request $request, Facturador $facturador, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facturador->getIdFacturador(), $request->request->get('_token'))) {
            $entityManager->remove($facturador);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_facturador_index', [], Response::HTTP_SEE_OTHER);
    }
}
