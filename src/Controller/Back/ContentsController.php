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
    #[Route('/', name: 'contents_index', methods: ['GET'])]
    public function index(ContentsRepository $contentsRepository): Response
    {
        return $this->render('back/contents/index.html.twig', [
            'contents' => $contentsRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'contents_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContentsRepository $contentsRepository, SluggerInterface $slugger): Response
    {
        $content = new Contents();
        $form = $this->createForm(ContentsType::class, $content);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('image')->getData();
            $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = '/images/'.$safeFilename . '-' . uniqid('', true) . '.' . $photoFile->guessExtension();
            try {
                $photoFile->move(
                    'images/',
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $content->setPrewiewImg($newFilename);

            $content->setCreatedBy($this->getUser());
            $content->setCreatedAt(new \DateTime());

            $contentsRepository->save($content, true);

            return $this->redirectToRoute('back_contents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/contents/new.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'contents_show', methods: ['GET'])]
    public function show(Contents $content): Response
    {
        return $this->render('back/contents/show.html.twig', [
            'content' => $content,
        ]);
    }

    #[Route('/{id}/edit', name: 'contents_edit', methods: ['GET', 'POST'])]
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

    #[Route('/{id}', name: 'contents_delete', methods: ['POST'])]
    public function delete(Request $request, Contents $content, ContentsRepository $contentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$content->getId(), $request->request->get('_token'))) {
            $contentsRepository->remove($content, true);
        }

        return $this->redirectToRoute('contents_index', [], Response::HTTP_SEE_OTHER);
    }
}