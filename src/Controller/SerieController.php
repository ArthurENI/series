<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/serie', name: 'serie_')]
final class SerieController extends AbstractController
{
//    #[Route('', name: 'list')]
    #[Route('/list/{page}', name: 'list',requirements: ['page' => '\d+'])]
    public function list(SerieRepository $serieRepository,int $page = 1): Response
    {
//        $series = $serieRepository->findAll();
//        $series = $serieRepository->findBy(["status" => "ended"], ['name' => 'ASC']);
//        $series = $serieRepository->findBy([], ['popularity' => 'DESC']);
//        $series = $serieRepository->findBestSeries();
        $nbSeries = $serieRepository->count();
        $maxPage = ceil($nbSeries / 50);
        if ($page < 1) {
            return $this->redirectToRoute('serie_list');
        }elseif ($page > $maxPage ){
            return $this->redirectToRoute('serie_list', ['page' => $maxPage]);
        }
        $series = $serieRepository->findBestSeriesWithPagination($page);

        return $this->render('serie/list.html.twig',[
            'series' => $series,
            'currentPage' => $page,
            'maxPage' => $maxPage,
        ]);
    }

    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id,SerieRepository $serieRepository): Response
    {
//        outils pour debug
//        dump($id);
//        dd("ci");

        $serie = $serieRepository->find($id);
//        $serie = $serieRepository->findOneBy(['id' => $id]);

        if (!$serie) {
            throw $this->createNotFoundException("Serie not found");
        }

        return $this->render('serie/detail.html.twig',[
            'serie' => $serie
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request,
        EntityManagerInterface $entityManager): Response
    {
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);

        $serieForm->handleRequest($request);
        $serie->setDateCreated(new \DateTime());
        if ($serieForm->isSubmitted()) {

            $entityManager->persist($serie);
            $entityManager->flush();
            $this->addFlash('success',$serie->getName().' has been created');
        }

        return $this->render('serie/create.html.twig',[
            'serieForm' => $serieForm
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['GET'])]
    public function delete(int $id,SerieRepository $serieRepository,EntityManagerInterface $entityManager): Response
    {
        $serie = $serieRepository->find($id);
        if ($serie) {
            $entityManager->remove($serie);
        }
        $entityManager->flush();
        $this->addFlash('success',$serie->getName().'was deleted');
        return $this->redirectToRoute('serie_list');
    }

    #[Route('/{id}/update', name: 'update', methods: ['GET','POST'])]
    public function update(int $id,SerieRepository $serieRepository,Request $request,
                           EntityManagerInterface $entityManager): Response
    {
        $serie = $serieRepository->find($id);
        $serieForm = $this->createForm(SerieType::class, $serie);
        $serieForm->handleRequest($request);

        if ($serieForm->isSubmitted()) {
            $entityManager->persist($serie);
            $entityManager->flush();
            $this->addFlash('success',$serie->getName().' has been updated !');
            return $this->redirectToRoute('serie_detail',['id'=>$serie->getId()]);
        }

        return $this->render('serie/update.html.twig',[
            'serieForm' => $serieForm
        ]);
    }



}
