<?php

namespace App\Controller\Back;

use App\Entity\Favorites;
use App\Entity\Users;
use App\Form\FavoritesType;
use App\Repository\FavoritesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favorites')]
class FavoritesController extends AbstractController
{
    #[Route('/user/{id}', name: 'favorites_user', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function index(Users $user): Response
    {
        return $this->render('back/favorites/index.html.twig', [
            'favorites' => $user->getFavorites(),
        ]);
    }
}
