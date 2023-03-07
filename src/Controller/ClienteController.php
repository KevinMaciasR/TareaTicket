<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\UsuarioType;
use App\Entity\Factura;
use App\Entity\Ticket;
use App\Entity\Referenciasprecios;
use App\Form\Cliente1Type; //pr hacer uso de la funcion que se encuentra en Cliente1type
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use App\Form\loginCliente;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cliente")
 */
class ClienteController extends AbstractController
{   

    /**
     * @Route("/inicio", name="app_cliente_inicio", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {  
         /*  //cree un objeto llamado usuario, para poder guardar alli el usurio y clave que el usuario ingresaba para inciar sesion
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            try{*/

                $cliente = $entityManager
                ->getRepository(Cliente::class)
                ->findOneBy(array( 
                    /*'usuario' => $usuario->getusuario(),
                    'clave' => $usuario->getclave() ));*/
                    //Valor de prueba Quemado
                    'usuario' => 'Js232',
                    'clave' => '12345' ));
                if($cliente != null ){
                    //Busqueda de Facturas del cliente
                    $facturas = $entityManager
                    ->getRepository(Factura::class)
                    ->findBy(array( 'idCliente'=> $cliente->getIdCliente()));

                    return $this->render('cliente/PortadaCliente.html.twig',[
                        'cliente' => $cliente,
                        'facturas' => $facturas
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
      * @Route("/salir", name="app_cliente_salir")
      */
        public function salircliente(): Response
        {   
            return $this->render('usuario/index.html.twig', [
                'controller_name' => 'UsuarioController',
            ]);
        }


    /**
     * @Route("/new", name="app_cliente_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cliente = new Cliente();
        $form = $this->createForm(Cliente1Type::class, $cliente); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        $cliente->setRol(4);// rol de cliente

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cliente);
            $entityManager->flush();
            $facturas =null;
            return $this->render('cliente/PortadaCliente.html.twig',[
                'cliente' => $cliente,
                'facturas' => $facturas
            ]);
        }

        return $this->renderForm('cliente/new.html.twig', [
            'cliente' => $cliente,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/{idCliente}", name="app_cliente_Cargarticket", methods={"GET"})
     */
    public function cargarticket(Cliente $cliente, EntityManagerInterface $entityManager):Response
    { 
        $referenciasprecios = $entityManager
        ->getRepository(Referenciasprecios::class)
        ->findAll();
        $horasInvertidas=rand(1,5); //simula las horas invertidas que asigna el personal tecnico al momento de establecer el trabajo a realizar.
        $tickets = $entityManager
            ->getRepository(Ticket::class)
            ->findBy(array('idCliente' => $cliente->getIdCliente()));
        return $this->render('ticket/index.html.twig', [
            'cliente' => $cliente,
            'tickets' => $tickets,
            'referenciasprecios' => $referenciasprecios,
            'horasInvertidas' => $horasInvertidas

        ]);
    }

















    /**
     * @Route("/{idCliente}/edit", name="app_cliente_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cliente $cliente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Cliente1Type::class, $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cliente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cliente/edit.html.twig', [
            'cliente' => $cliente,
            'form' => $form,
        ]);
    }



    ///**
    // * @Route("/{idCliente}", name="app_cliente_delete", methods={"POST"})
    // */
   /* public function delete(Request $request, Cliente $cliente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cliente->getIdCliente(), $request->request->get('_token'))) {
            $entityManager->remove($cliente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cliente_index', [], Response::HTTP_SEE_OTHER);
    }*/
}
?>