<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Entity\Gerente;
use App\Entity\Usuario;
use App\Form\Gerente1Type;
use App\Form\UsuarioType;
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
     * @Route("/inicio", name="app_gerente_inicio")
     */
    //Busqueda de facturas por fecha por parte del gerente
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

         //cree un objeto llamado usuario, para poder guardar alli el usurio y clave que el usuario ingresaba para inciar sesion
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($usuario->getusuario() != null){
                $gerente = $entityManager
                ->getRepository(Gerente::class)
                ->findOneBy(array( 
                    'usuario' => $usuario->getusuario(),
                    'clave' => $usuario->getclave() ));
                    //Valor de prueba Quemado
                    /*'usuario' => 'sof789',
                    'clave' => '12345' ));*/
                if($gerente != null ){
                    $facturas = $entityManager
                    ->getRepository(Factura::class)
                    ->findAll();
                    return $this->render('gerente/PortadaGerente.html.twig',[
                        'gerente' => $gerente,
                        'facturas'=> $facturas,
                        'valor'=> 1
                    ]);
                }
  
            }
        }
        return $this->renderForm('usuario/usuario.html.twig',[
            'controller_name' => 'UsuarioController', 
                //'usuarioGeneral'=> $usuarioGeneral,
                'form' => $form,
                'rol' => 1 //identificador de rol de gerente
        ]);

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
            if( $gerente->getUsuario()!= null){
                //validacion para que no se registren clientes repetidos
                $correo = $entityManager->getRepository(Gerente::class)
                ->findBy(array( 'correo'=> $gerente->getCorreo()
            ));
                $cedula = $entityManager->getRepository(Gerente::class)
                ->findBy(array('cedula'=> $gerente->getCedula()
            ));
                $usuarioDuplicado = $entityManager->getRepository(Gerente::class)
                ->findOneBy(array( 'usuario'=>$gerente->getUsuario()
            ));
                if(empty($correo) == 1 && empty($cedula) == 1 && empty($usuarioDuplicado)==1){ //condicion para garantizar que el Gerente ingresado no se encuentra en la base de datos
                    $entityManager->persist($gerente);
                    $entityManager->flush();
                    $facturas = $entityManager
                    ->getRepository(Factura::class)
                    ->findAll();
                    return $this->render('gerente/PortadaGerente.html.twig',[
                        'gerente' => $gerente,
                        'facturas'=> $facturas
                    ]);
        }}}

        return $this->renderForm('gerente/new.html.twig', [
            'gerente' => $gerente,
            'form' => $form,
        ]);
    }

    /**
    * @Route("/salir", name="app_gerente_salir")
    */
    /*public function salirgerente(): Response
    {   
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }*/
    
    /**
    * @Route("/facturap", name="app_gerente_facturaP")
    */
      public function facturas(): Response
      { 
        $facturafiltradas =   null;
        return $this->render('gerente/FacturaPeriodos.html.twig',[
            'facturas'=> $facturafiltradas
        ]);
      }

    /**
    * @Route("/{mes}", name="app_gerente_facturas", methods={"GET"})
    */
    public function mostrarFacturas(string $mes, EntityManagerInterface $entityManager)
    {
        $facturas = $entityManager
        ->getRepository(Factura::class)
        ->findAll();
        $facturafiltradas = array();
        
        $cont=-1;
        foreach( $facturas as $factura){    
            if ((strcmp($factura->getFecha()->format('m'), $mes)===0)){ //validacion de filtro de fecha
                $cont++;
                $facturafiltradas[$cont]=$factura;
                //$valor[$cont]=[$factura->getFecha()->format('m')];
            }
        }
        return $this->render('gerente/FacturaPeriodos.html.twig',[
            'facturas'=> $facturafiltradas,
            'facturasF' =>$facturas,
        ]);

    }

















    /**
     * @Route("/{idgerente}", name="app_gerente_show", methods={"GET"})
     */
    /*public function show(Gerente $gerente): Response
    {
        return $this->render('gerente/show.html.twig', [
            'gerente' => $gerente,
        ]);
    }*/

    /**
     * @Route("/{idgerente}/edit", name="app_gerente_edit", methods={"GET", "POST"})
     */
    /*public function edit(Request $request, Gerente $gerente, EntityManagerInterface $entityManager): Response
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
    }*/

    /**
     * @Route("/{idgerente}", name="app_gerente_delete", methods={"POST"})
     */
    /*public function delete(Request $request, Gerente $gerente, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gerente->getIdgerente(), $request->request->get('_token'))) {
            $entityManager->remove($gerente);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_gerente_index', [], Response::HTTP_SEE_OTHER);
    }*/
}
?>
