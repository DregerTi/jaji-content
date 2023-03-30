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
    #[Route('/', name: 'favorites_index', methods: ['GET'])]
    #[Security('is_granted("ROLE_CLIENT")')]
    public function index(Request $request, FavoritesRepository $favoritesRepository): Response
    {
        return $this->render('front/favorites/index.html.twig', [
            'favorites' => $favoritesRepository->searchMyFavorites($this->getUser()->getId(), $request->query->get('page') ?? 1),
        ]);
    }

    #[Route('/new/{slug}', name: 'favorites_new', methods: ['POST'])]
    #[Security('is_granted("ROLE_CLIENT")')]
    public function new(FavoritesRepository $favoritesRepository, Contents $content): Response
    {
        $favorite = new Favorites();
        $favorite->setContent($content);
        $favorite->setLiker($this->getUser());
        $favoritesRepository->save($favorite, true);

        $this->addFlash('success', $content->getTitle().' a bien été ajouté à votre liste.');

        return $this->redirectToRoute('front_favorites_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'favorites_delete', methods: ['POST'])]
    #[Security('favorite.getUser() == user')]
    public function delete(Request $request, Favorites $favorite, FavoritesRepository $favoritesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favorite->getId(), $request->request->get('_token'))) {
            $favoritesRepository->remove($favorite, true);
            $this->addFlash('success', $favorite->getContent()->getTitle().' a bien été retiré de votre liste.');
        }

        return $this->redirectToRoute('front_favorites_index', [], Response::HTTP_SEE_OTHER);
    }
}
