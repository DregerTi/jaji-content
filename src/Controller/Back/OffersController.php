<?php

namespace App\Controller\Back;

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
    #[Route('/new', name: 'offers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OffersRepository $offersRepository): Response
    {
        $offer = new Offers();
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setCreatedAt(new \DateTime());
            $offersRepository->save($offer, true);

            return $this->redirectToRoute('front_offers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/offers/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'offers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offers $offer, OffersRepository $offersRepository): Response
    {
        $form = $this->createForm(OffersType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setUpdatedAt(new \DateTime());
            $offersRepository->save($offer, true);

            return $this->redirectToRoute('front_offers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/offers/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'offers_delete', methods: ['POST'])]
    public function delete(Request $request, Offers $offer, OffersRepository $offersRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offer->getId(), $request->request->get('_token'))) {
            $offersRepository->remove($offer, true);
        }

        return $this->redirectToRoute('front_offers_index', [], Response::HTTP_SEE_OTHER);
    }
}
