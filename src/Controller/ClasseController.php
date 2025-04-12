<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\ClasseRepository;
use PhpParser\Builder\Class_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ClasseController extends AbstractController
{
    #[Route('/api/classes', name: 'classes', methods: ['GET'])]
    public function getAllClasses(ClasseRepository $classeRepository, SerializerInterface $serializer): JsonResponse
    {
        $classeList = $classeRepository->findAll();

        $jsonClassList = $serializer->serialize($classeList, 'json');

        return new JsonResponse($jsonClassList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/classes/{id}', name: 'classeDetails', methods: ['GET'])]
    public function getClasseDetails(Classe $classe, ClasseRepository $classeRepository, SerializerInterface $serializer): JsonResponse
    {
        $jsonClass = $serializer->serialize($classe, 'json');
        return new JsonResponse($jsonClass, Response::HTTP_OK, [], true);
    }
}
