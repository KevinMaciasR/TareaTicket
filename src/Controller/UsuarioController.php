<?php

namespace App\Controller;
use App\Entity\Usuario;
use App\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsuarioController extends AbstractController
{
    /**
     * @Route("/", name="app_usuario")
     */
    public function index(): Response
    {


        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
           
        ]);
    }

    /**
     * @Route("/iniciocliente", name="app_usuario_iniciocliente")
     */
    public function iniciocliente(Request $request,EntityManagerInterface $entityManager): Response
    {           
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('usuario/Bienvenida.html.twig', [
                'usuario'=>$usuario]          
        );
    }return $this->renderForm('usuario/usuario.html.twig',[
    'controller_name' => 'UsuarioController', 
        'usuario'=> $usuario,
        'form' => $form]);
}
    /**
     * @Route("/iniciogerente", name="app_usuario_iniciogerente")
     */
    public function iniciogerente(): Response
    {
        return $this->render('cliente/inicio.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }
        /**
     * @Route("/iniciopersonaltecnico", name="app_usuario_iniciopersonaltecnico")
     */
    public function iniciopersonalTecnico(): Response
    {
        return $this->render('personaltecnico/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }
        /**
     * @Route("/iniciofacturador", name="app_usuario_iniciofacturador")
     */
    public function iniciofacturador(): Response
    {
        return $this->render('facturador/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }
}
?>