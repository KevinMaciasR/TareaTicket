<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Factura;
use App\Entity\Ticket;
use App\Entity\Referenciasprecios;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/{idCliente}/{tipotrabajo}/{horasInvertidas}", name="app_ticket_new", methods={"GET", "POST"})
     * 
     */
    public function new(Cliente $cliente, Referenciasprecios $referencia, int $horasInvertidas, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket($cliente->getIdCliente(), $referencia->getIdReferencia(), $horasInvertidas);
        $entityManager->persist($ticket);
        $entityManager->flush();       
        $facturas = $entityManager
        ->getRepository(Factura::class)
        ->findBy(array( 'idCliente'=> $cliente->getIdCliente()));

        return $this->renderForm('cliente/PortadaCliente.html.twig', [
            'cliente' => $cliente,
            'facturas' => $facturas,
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
?>