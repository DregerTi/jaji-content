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
    public function index(Request $request, ContentsRepository $contentsRepository): Response
    {
        $page = $request->query->get('page') ?? 1;
        $categories = $request->query->get('categories')
            ? explode(',', $request->query->get('categories'))
            : null;
        $search = $request->query->get('search');
        $sortByCreationDate = in_array($request->query->get('sortByCreationDate'), ['ASC', 'DESC'], true) ?
            $request->query->get('sortByCreationDate') : null;

        $filteredContents = $contentsRepository->search($categories, $search, $page, $sortByCreationDate);

        return $this->render('back/contents/index.html.twig', [
            'contents' => $filteredContents['results'],
            'totalNbOfContents' => $filteredContents['count'],
            'userCategories' => null,
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
            if ($photoFile) {
                $content->setPrewiewImg(($this->saveImage($photoFile, $slugger)));
            }

            $content->setCreatedBy($this->getUser());
            $content->setCreatedAt(new \DateTime());

            $contentsRepository->save($content, true);
            $this->addFlash('success', $content->getTitle().' a bien été ajouté.');

            return $this->redirectToRoute('front_contents_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted()) {
            $this->addFlash('error', 'Une erreur est survenue.');
        }

        return $this->renderForm('back/contents/new.html.twig', [
            'content' => $content,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'contents_show', methods: ['GET'])]
    public function show(Contents $content): Response
    {
        return $this->render('back/contents/show.html.twig', [
            'content' => $content,
        ]);
    }

    #[Route('/{slug}/edit', name: 'contents_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contents $content, ContentsRepository $contentsRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ContentsType::class, $content, ['isNew' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('image')->getData();
            if ($photoFile) {
                $content->setPrewiewImg($this->saveImage($photoFile, $slugger));
                var_dump($content->getPrewiewImg());die;
            }

            $content->setUpdatedBy($this->getUser());
            $content->setUpdatedAt(new \DateTime());
            $contentsRepository->save($content, true);

            $this->addFlash('success', $content->getTitle().' a bien été modifié.');

            return $this->redirectToRoute('back_contents_index', [], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted()) {
            $this->addFlash('error', 'Une erreur est survenue.');
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
            $this->addFlash('success', $content->getTitle().' a bien été supprimé.');
        }

        return $this->redirectToRoute('back_contents_index', [], Response::HTTP_SEE_OTHER);
    }

    private function saveImage($photoFile, $slugger): string
    {
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
        return $newFilename;
    }
}
