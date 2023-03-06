<?php

namespace App\Controller;

use App\Entity\Personaltecnico;
use App\Form\PersonaltecnicoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/personaltecnico")
 */
class PersonaltecnicoController extends AbstractController
{
    /**
     * @Route("/", name="app_personaltecnico_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $personaltecnicos = $entityManager
            ->getRepository(Personaltecnico::class)
            ->findAll();

        return $this->render('personaltecnico/index.html.twig', [
            'personaltecnicos' => $personaltecnicos,
        ]);
    }

    /**
     * @Route("/new", name="app_personaltecnico_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $personaltecnico = new Personaltecnico();
        $form = $this->createForm(PersonaltecnicoType::class, $personaltecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($personaltecnico);
            $entityManager->flush();

            return $this->redirectToRoute('app_personaltecnico_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personaltecnico/new.html.twig', [
            'personaltecnico' => $personaltecnico,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idTecnico}", name="app_personaltecnico_show", methods={"GET"})
     */
    public function show(Personaltecnico $personaltecnico): Response
    {
        return $this->render('personaltecnico/show.html.twig', [
            'personaltecnico' => $personaltecnico,
        ]);
    }

    /**
     * @Route("/{idTecnico}/edit", name="app_personaltecnico_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Personaltecnico $personaltecnico, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PersonaltecnicoType::class, $personaltecnico);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_personaltecnico_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('personaltecnico/edit.html.twig', [
            'personaltecnico' => $personaltecnico,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idTecnico}", name="app_personaltecnico_delete", methods={"POST"})
     */
    public function delete(Request $request, Personaltecnico $personaltecnico, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personaltecnico->getIdTecnico(), $request->request->get('_token'))) {
            $entityManager->remove($personaltecnico);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_personaltecnico_index', [], Response::HTTP_SEE_OTHER);
    }
}
