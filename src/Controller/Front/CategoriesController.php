<?php

namespace App\Controller\Front;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use App\Repository\UsersRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'categories_index', methods: ['GET'])]
    #[Security('is_granted("ROLE_CLIENT")')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('front/categories/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route('/{label}', name: 'categories_show', methods: ['GET'])]
    public function show(Categories $category): Response
    {
        return $this->render('front/categories/show.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route('/add/{label}', name: 'categories_add_category', methods: ['POST'])]
    public function addCategory(UsersRepository $usersRepository, Categories $category): Response
    {
        $this->getUser()->addCategory($category);
        $usersRepository->save($this->getUser(), true);
        $this->addFlash('success', $category->getLabel().' a bien été ajouté à votre liste.');
        return $this->redirectToRoute('front_categories_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/remove/{label}', name: 'categories_remove_category', methods: ['POST'])]
    #[Security('is_granted("ROLE_CLIENT")')]
    public function removeCategory(UsersRepository $usersRepository, Categories $category): Response
    {
        $this->getUser()->removeCategory($category);
        $usersRepository->save($this->getUser(), true);
        $this->addFlash('success', $category->getLabel().' a bien été retiré de votre liste.');
        return $this->redirectToRoute('front_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
