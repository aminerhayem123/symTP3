<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Entity\Voiture;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_route", methods={"GET"})
     */
    public function index(): Response
    {
        $agences = $this->getDoctrine()->getRepository(Agence::class)->findAll();
        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

        return $this->render('pages/admin/index.html.twig', [
            'agences' => $agences,
            'voitures' => $voitures
        ]);
    }
}
