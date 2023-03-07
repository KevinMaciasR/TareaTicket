<?php

namespace App\Controller;
use App\Entity\Usuario;
use App\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/*  
Cliente: 4
Facturador: 3
Personal técnico: 2
Gerente: 1
*/
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
                'usuario'=>$usuario,
                'rol' => 4]          
        );
    }return $this->renderForm('usuario/usuario.html.twig',[
    'controller_name' => 'UsuarioController', 
        'usuario'=> $usuario,
        'form' => $form,
        'rol' => 4 //identificador de rol
    ]);
}
    /**
     * @Route("/iniciogerente", name="app_usuario_iniciogerente")
     */
    public function iniciogerente(Request $request): Response
    {
        $usuario = new Usuario(); 
        $form = $this->createForm(UsuarioType::class, $usuario); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('usuario/Bienvenida.html.twig', [
                'usuario'=>$usuario,
                'rol' => 1]          
        );
    }return $this->renderForm('usuario/usuario.html.twig',[
    'controller_name' => 'UsuarioController', 
        'usuario'=> $usuario,
        'form' => $form,
        'rol' => 1 //identificador de rol de gerente
    ]);
    }
        /**
     * @Route("/iniciopersonaltecnico", name="app_usuario_iniciopersonaltecnico")
     */
    public function iniciopersonalTecnico(Request $request): Response
    {
        $usuario = new Usuario(); 
        $form = $this->createForm(UsuarioType::class, $usuario); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('usuario/Bienvenida.html.twig', [
                'usuario'=>$usuario,
                'rol'=> 2]   
        );
    }return $this->renderForm('usuario/usuario.html.twig',[
    'controller_name' => 'UsuarioController', 
        'usuario'=> $usuario,
        'form' => $form,
        'rol' => 2 //identificador de rol de gerente
    ]);
    }
        /**
     * @Route("/iniciofacturador", name="app_usuario_iniciofacturador")
     */
    public function iniciofacturador(Request $request): Response
    {
        $usuario = new Usuario(); 
        $form = $this->createForm(UsuarioType::class, $usuario); //aqui llama del archivo Cliente1Type ubicado en la carpeta form
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->render('usuario/Bienvenida.html.twig', [
                'usuario'=>$usuario,
                'rol'=> 3]
        );
    }return $this->renderForm('usuario/usuario.html.twig',[
    'controller_name' => 'UsuarioController', 
        'usuario'=> $usuario,
        'form' => $form,
        'rol' => 3 //identificador de rol de gerente
    ]);
    }
}
?>