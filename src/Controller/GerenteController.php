<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Entity\Gerente;
use App\Form\Gerente1Type;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gerente")
 */
class GerenteController extends AbstractController
{

    /**
     * @Route("/inicio", name="app_gerente_inicio", methods={"GET"})
     */
    //Busqueda de facturas por fecha por parte del gerente
    public function index(EntityManagerInterface $entityManager): Response
    {

                 /*  //cree un objeto llamado usuario, para poder guardar alli el usurio y clave que el usuario ingresaba para inciar sesion
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            try{*/

                $gerente = $entityManager
                ->getRepository(Gerente::class)
                ->findOneBy(array( 
                    /*'usuario' => $usuario->getusuario(),
                    'clave' => $usuario->getclave() ));*/
                    //Valor de prueba Quemado
                    'usuario' => 'sof789',
                    'clave' => '12345' ));
                if($gerente != null ){
                    return $this->render('gerente/PortadaGerente.html.twig',[
                        'gerente' => $gerente,
                    ]);
                }
            /* }catch(Exception $e){
                echo 'Usuario Incorrecto', $e->getMessage();
            }  
        }*/
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);

        /*
        //{ obtener datos por fecha}
        $factura = $entityManager
            ->getRepository(Factura::class)->findBy(['fecha'=> $fecha]); 

        return $this->render('gerente/index.html.twig', [
            'gerentes' => $factura,
        ]);*/

    }
    /**
     * @Route("/new", name="app_gerente_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gerente = new Gerente();
        $form = $this->createForm(Gerente1Type::class, $gerente);
        $form->handleRequest($request);
        $gerente->setRol(1);// rol de gerente

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gerente);
            $entityManager->flush();

            return $this->redirectToRoute('app_gerente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gerente/new.html.twig', [
            'gerente' => $gerente,
            'form' => $form,
        ]);
    }

     /**
      * @Route("/salir", name="app_gerente_salir")
      */
        public function salirgerente(): Response
        {   
            return $this->render('usuario/index.html.twig', [
                'controller_name' => 'UsuarioController',
            ]);
        }
    
        /**
     * @Route("/", name="app_gerente_facturas", methods={"GET"})
     */
    public function mostrarFacturas(){


    }







    /**
     * @Route("/{idgerente}", name="app_gerente_show", methods={"GET"})
     */
    public function show(Gerente $gerente): Response
    {
        return $this->render('gerente/show.html.twig', [
            'gerente' => $gerente,
        ]);
    }

    /**
     * @Route("/{idgerente}/edit", name="app_gerente_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Gerente $gerente, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Gerente1Type::class, $gerente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_gerente_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('gerente/edit.html.twig', [
            'gerente' => $gerente,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{idgerente}", name="app_gerente_delete", methods={"POST"})
     */
    public function delete(Request $request, Gerente $gerente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gerente->getIdgerente(), $request->request->get('_token'))) {
            $entityManager->remove($gerente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gerente_index', [], Response::HTTP_SEE_OTHER);
    }
}
?>
