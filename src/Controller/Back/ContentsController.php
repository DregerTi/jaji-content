<?php

namespace App\Controller\Back;

use App\Entity\Contents;
use App\Form\ContentsType;
use App\Repository\ContentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/contents')]
class ContentsController extends AbstractController
{
    #[Route('/new', name: 'contents_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContentsRepository $contentsRepository, SluggerInterface $slugger): Response
    {
        $content = new Contents();
        $form = $this->createForm(ContentsType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('image')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = '/images/'.$safeFilename . '-' . uniqid('', true) . '.' . $photoFile->guessExtension();
                try {
                    $photoFile->move(
                        'images/',
                        $newFilename
                    );
                } catch (FileException $e) {
                    //TODO voir si les flash sont gérés
                    $this->addFlash('error', 'Erreur lors de la sauvegarde de l\'image : \n' . $e->getMessage());
                }
                $content->setPrewiewImg($newFilename);
            }

            $content->setCreatedBy($this->getUser());
            $content->setCreatedAt(new \DateTime());

            $contentsRepository->save($content, true);

            return $this->redirectToRoute('front_contents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/contents/new.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }
    #[Route('/{slug}/edit', name: 'contents_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contents $content, ContentsRepository $contentsRepository): Response
    {
        $form = $this->createForm(ContentsType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contentsRepository->save($content, true);

            return $this->redirectToRoute('contents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/contents/edit.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'contents_delete', methods: ['POST'])]
    public function delete(Request $request, Contents $content, ContentsRepository $contentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$content->getId(), $request->request->get('_token'))) {
            $contentsRepository->remove($content, true);
        }

        return $this->redirectToRoute('contents_index', [], Response::HTTP_SEE_OTHER);
    }
}
