<?php

namespace App\Controller;

use App\Entity\Personaltecnico;
use App\Entity\Ticket;
use App\Entity\Usuario;
use App\Form\PersonaltecnicoType;
use App\Form\UsuarioType;;
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
    /**     * @Route("/inicio", name="app_personaltecnico_inicio")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $usuario = new Usuario(); 
        $form = $this->createForm(UsuarioType::class, $usuario); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($usuario->getusuario() != null){
             $personaltecnico = $entityManager
            ->getRepository(Personaltecnico::class)
            ->findOneBy(array( 
                'usuario' => $usuario->getusuario(),
                'clave' => $usuario->getclave() ));
                /*'usuario' => 'mbz32',
                'clave' => '12345' ));*/
        if($personaltecnico != null ){
            $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findAll();
             return $this->render('personaltecnico/PortadaPersonalTecnico.html.twig', [
            'personaltecnico' => $personaltecnico,
            'tickets' => $tickets
        ]);
    }

    }}
    return $this->renderForm('usuario/usuario.html.twig',[
        'controller_name' => 'UsuarioController', 
            'form' => $form,
            'rol' => 2 //identificador de rol de gerente
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
            $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findAll();
            return $this->render('personaltecnico/PortadaPersonalTecnico.html.twig', [
                'personaltecnico' => $personaltecnico,
                'tickets' => $tickets
            ]);
        }

        return $this->renderForm('personaltecnico/new.html.twig', [
            'personaltecnico' => $personaltecnico,
            'form' => $form,
        ]);
    }

    /**
      * @Route("/salir", name="app_tecnico_salir")
      */
      public function salirPersonalTecnico(): Response
      {   
          return $this->render('usuario/index.html.twig', [
              'controller_name' => 'UsuarioController',
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
