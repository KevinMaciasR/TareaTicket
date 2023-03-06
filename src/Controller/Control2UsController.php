<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Form\Usuario1Type;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/control2/us')]
class Control2UsController extends AbstractController
{
    #[Route('/', name: 'app_control2_us_index', methods: ['GET'])]
    public function index(UsuarioRepository $usuarioRepository): Response
    {
        return $this->render('control2_us/index.html.twig', [
            'usuarios' => $usuarioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_control2_us_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UsuarioRepository $usuarioRepository): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(Usuario1Type::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usuarioRepository->add($usuario, true);

            return $this->redirectToRoute('app_control2_us_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('control2_us/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }

    #[Route('/{usuario}', name: 'app_control2_us_show', methods: ['GET'])]
    public function show(Usuario $usuario): Response
    {
        return $this->render('control2_us/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    #[Route('/{usuario}/edit', name: 'app_control2_us_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Usuario $usuario, UsuarioRepository $usuarioRepository): Response
    {
        $form = $this->createForm(Usuario1Type::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usuarioRepository->add($usuario, true);

            return $this->redirectToRoute('app_control2_us_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('control2_us/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form,
        ]);
    }

    #[Route('/{usuario}', name: 'app_control2_us_delete', methods: ['POST'])]
    public function delete(Request $request, Usuario $usuario, UsuarioRepository $usuarioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getUsuario(), $request->request->get('_token'))) {
            $usuarioRepository->remove($usuario, true);
        }

        return $this->redirectToRoute('app_control2_us_index', [], Response::HTTP_SEE_OTHER);
    }
}
