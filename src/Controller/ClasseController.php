<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ClasseController extends AbstractController
{
    #[Route('/api//classes', name: 'classes')]
    public function getAllClasses(): JsonResponse
    {
        return $this->json([
            'controller_name' => 'ClasseController',
        ]);
    }
}
