<?php

namespace App\Controller;

use App\Entity\Serie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/serie', name: 'serie_')]
final class SerieController extends AbstractController
{
    #[Route('', name: 'list')]
    public function list(): Response
    {
        //TODO renvoyer la liste des series
        return $this->render('serie/list.html.twig');
    }

    #[Route('/{id}', name: 'detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id): Response
    {
//        outils pour debug
//        dump($id);
//        dd("ci");
        //TODO renvoyer une série
        return $this->render('serie/detail.html.twig');
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $entityManager): Response
    {
//        $serie = new Serie();
//        $serie->setBackdrop("backdrop.png")
//            ->setDateCreated(new \DateTime())
//            ->setFirstAirDate(new \DateTime('-6 month'))
//            ->setName('The Witcher')
//            ->setGenres('Fantastique')
//            ->setLastAirDate(new \DateTime('-1 month'))
//            ->setPopularity(5000)
//            ->setPoster('poster.png')
//            ->setStatus('returning')
//            ->setTmdbId(123456)
//            ->setVote(8);
//        dump($serie);
//
//        $entityManager->persist($serie);
//        $entityManager->flush();
//
//        dump($serie);
//
//        $serie->setName("Buffy contre les vampires");
//        $entityManager->persist($serie);
//        $entityManager->flush();
//
//        $entityManager->remove($serie);
//        $entityManager->flush();

        //TODO créer une série avec un formulaire
        return $this->render('serie/create.html.twig');
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['GET'])]
    public function delete(int $id): Response
    {
        //TODO supprimer une série
        return $this->render('serie/list.html.twig');
    }



}
