<?php

namespace App\Controller\Front;

use App\Entity\Offers;
use App\Form\OffersType;
use App\Repository\OffersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offers')]
class OffersController extends AbstractController
{
    #[Route('/', name: 'offers_index', methods: ['GET'])]
    public function index(OffersRepository $offersRepository): Response
    {
        return $this->render('front/offers/index.html.twig', [
            'offers' => $offersRepository->findAll(),
        ]);
    }
}
