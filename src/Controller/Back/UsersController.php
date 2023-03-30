<?php

namespace App\Controller\Back;

use App\Entity\Users;
use App\Form\Users1Type;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/users')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'users_index', methods: ['GET'])]
    public function index(Request $request, UsersRepository $usersRepository): Response
    {
        $search = $request->query->get('search') ?
            explode(' ', $request->query->get('search')) : null
        ;
        $role = $request->query->get('role');
        return $this->render('back/users/index.html.twig', [
            'users' => $usersRepository->search($search, $role),
        ]);
    }

    #[Route('/{id}', name: 'users_show', methods: ['GET'])]
    public function show(Users $user): Response
    {
        return $this->render('back/users/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'users_delete', methods: ['POST'])]
    public function delete(Request $request, Users $user, UsersRepository $usersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $usersRepository->remove($user, true);
            $this->addFlash('success', $user->getFirstname().' a bien été supprimé.');
        }

        return $this->redirectToRoute('back_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
