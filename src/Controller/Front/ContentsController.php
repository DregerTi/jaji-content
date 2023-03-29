<?php

namespace App\Controller\Front;

use App\Entity\Contents;
use App\Repository\ContentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contents')]
class ContentsController extends AbstractController
{
    #[Route('/', name: 'contents_index', methods: ['GET'])]
    public function index(ContentsRepository $contentsRepository, Request $request): Response
    {
        $page = $request->query->get('page') ?? 1;
        $categories = $request->query->get('categories')
            ? explode(',', $request->query->get('categories'))
            : null;

        return $this->render('front/contents/index.html.twig', [
            'contents' => $contentsRepository->search($categories, $page),
            'userCategories' => $this->getUser()->getCategories(),
        ]);
    }

    #[Route('/{slug}', name: 'contents_show', methods: ['GET'])]
    public function show(Contents $content): Response
    {
        return $this->render('front/contents/show.html.twig', [
            'content' => $content,
        ]);
    }
}
