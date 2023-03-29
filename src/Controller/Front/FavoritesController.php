<?php

namespace App\Controller\Front;

use App\Entity\Contents;
use App\Entity\Favorites;
use App\Form\FavoritesType;
use App\Repository\FavoritesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/favorites')]
class FavoritesController extends AbstractController
{
    #[Route('/my-favorites', name: 'my_favorites', methods: ['GET'])]
    #[Security('is_granted("ROLE_USER")')]
    public function index(): Response
    {
        return $this->render('front/favorites/index.html.twig', [
            'favorites' => $this->getUser()->getFavorites(),
        ]);
    }

    #[Route('/new/{slug}', name: 'favorites_new', methods: ['POST'])]
    #[Security('is_granted("ROLE_USER")')]
    public function new(FavoritesRepository $favoritesRepository, Contents $content): Response
    {
        if ($content) {
            $favorite = new Favorites();
            $favorite->setContent($content);
            $favorite->setLiker($this->getUser());
            $favoritesRepository->save($favorite, true);

            return $this->redirectToRoute('front_favorites_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $favoritesRepository->save($favorite, true);

            return $this->redirectToRoute('front_favorites_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/favorites/new.html.twig', [
            'favorite' => $favorite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'favorites_delete', methods: ['POST'])]
    #[Security('favorite.getUser() == user')]
    public function delete(Request $request, Favorites $favorite, FavoritesRepository $favoritesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favorite->getId(), $request->request->get('_token'))) {
            $favoritesRepository->remove($favorite, true);
        }

        return $this->redirectToRoute('front_favorites_index', [], Response::HTTP_SEE_OTHER);
    }
}
