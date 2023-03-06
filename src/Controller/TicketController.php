<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Ticket;
use App\Entity\Referenciasprecios;
use App\Form\TicketType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ticket")
 */
class TicketController extends AbstractController
{
    /**
     * @Route("/", name="app_ticket_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findAll();

        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * @Route("/{idCliente}/{tipotrabajo}", name="app_ticket_new", methods={"GET", "POST"})
     * 
     */
    public function new(Request $request, Cliente $cliente, Referenciasprecios $referencia, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket($cliente->getIdCliente(), $referencia->getPreciohora());
        $entityManager->persist($ticket);
        $entityManager->flush();       


        return $this->renderForm('cliente/PortadaCliente.html.twig', [
            'cliente' => $cliente,
        ]);
    }
       
    /**
     * @Route("/{idTicket}", name="app_ticket_show", methods={"GET"})
     */
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    ///**
    // * @Route("/{idTicket}/edit", name="app_ticket_edit", methods={"GET", "POST"})
    //*/
    /*public function edit(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }*/







    ///**
    // * @Route("/{idTicket}", name="app_ticket_delete", methods={"POST"})
    // */
    /*public function delete(Request $request, Ticket $ticket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getIdTicket(), $request->request->get('_token'))) {
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ticket_index', [], Response::HTTP_SEE_OTHER);
    }*/
}