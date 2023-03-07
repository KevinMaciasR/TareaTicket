<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Entity\Facturador;
use App\Entity\Referenciasprecios;
use App\Entity\Ticket;
use App\Form\Facturador1Type;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\False_;
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
     * @Route("/inicio", name="app_facturador_inicio", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {  
        $facturador = $entityManager
        ->getRepository(Facturador::class)
        ->findOneBy(array( 
            /*'usuario' => $usuario->getusuario(),
            'clave' => $usuario->getclave() ));*/
            //Valor de prueba Quemado
            'usuario' => 'Josbaque',
            'clave' => '12345' ));
        $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findAll();
        if($facturador != null ){
            $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findAll();
            return $this->render('facturador/PortadaFacturador.html.twig',[
                'facturador' => $facturador,
                'tickets'=> $tickets
            ]);
        }
    /* }catch(Exception $e){
        echo 'Usuario Incorrecto', $e->getMessage();
    }  
}*/
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
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
            $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findAll();       
            return $this->render('facturador/PortadaFacturador.html.twig',[
                'facturador' => $facturador,
                'tickets'=> $tickets

            ]);
        }
        

        return $this->renderForm('facturador/new.html.twig', [
            'facturador' => $facturador,
            'form' => $form,
        ]);
    }

     /**
      * @Route("/{idTicket}/{idFacturador}", name="app_facturador_crearFactura",  methods={"GET"})
      */
    public function crearFactura(Ticket $ticket, Facturador $facturador, EntityManagerInterface $entityManager)
    {
        $referencia = $entityManager
            ->getRepository(Referenciasprecios::class)
                ->findOneBy(array(  'idReferencia' =>
                    $ticket->getIdReferencia()));
        $ticket->setActivo(False);
        $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findAll();
        $factura = new Factura( $facturador->getIdFacturador(), $ticket->getIdCliente(), $referencia->getTipotrabajo(), $referencia->getPreciohora()*$ticket->gethorasInvertidas()); //mutipicaicon entre el precio por hora y las horas invertidas
        $entityManager->persist($factura);
        $entityManager->flush();  
        return $this->render('facturador/PortadaFacturador.html.twig',[
            'facturador' => $facturador,
            'tickets'=> $tickets
        ]);  
    }

    /**
      * @Route("/salir", name="app_facturador_salir")
      */
      public function salirfacturador(): Response
      {   
          return $this->render('usuario/index.html.twig', [
              'controller_name' => 'UsuarioController',
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
?>