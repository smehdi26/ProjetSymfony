<?php

namespace App\Controller;

use App\Entity\Market;
use App\Form\MarketType;
use App\Repository\MarketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/market/mahdi')]
final class MarketMahdiController extends AbstractController
{
    #[Route(name: 'app_market_mahdi_index', methods: ['GET'])]
    public function index(MarketRepository $marketRepository): Response
    {
        return $this->render('market_mahdi/index.html.twig', [
            'markets' => $marketRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_market_mahdi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $market = new Market();
        $form = $this->createForm(MarketType::class, $market);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($market);
            $entityManager->flush();

            return $this->redirectToRoute('app_market_mahdi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('market_mahdi/new.html.twig', [
            'market' => $market,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_market_mahdi_show', methods: ['GET'])]
    public function show(Market $market): Response
    {
        return $this->render('market_mahdi/show.html.twig', [
            'market' => $market,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_market_mahdi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Market $market, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MarketType::class, $market);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_market_mahdi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('market_mahdi/edit.html.twig', [
            'market' => $market,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_market_mahdi_delete', methods: ['POST'])]
    public function delete(Request $request, Market $market, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$market->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($market);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_market_mahdi_index', [], Response::HTTP_SEE_OTHER);
    }
}
