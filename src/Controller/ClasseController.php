<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\CharacterRepository;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Builder\Class_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

final class ClasseController extends AbstractController
{
    #[Route('/api/classes', name: 'getClasses', methods: ['GET'])]
    public function getAllClasses(ClasseRepository $classeRepository, SerializerInterface $serializer): JsonResponse
    {
        $classeList = $classeRepository->findAll();

        $jsonClassList = $serializer->serialize($classeList, 'json', ['groups' => 'getClasses']);

        return new JsonResponse($jsonClassList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/classes/{id}', name: 'getClasse', methods: ['GET'])]
    public function getClasseDetails(Classe $classe, SerializerInterface $serializer): JsonResponse
    {
        $jsonClass = $serializer->serialize($classe, 'json');
        return new JsonResponse($jsonClass, Response::HTTP_OK, ['groups' => 'getClasses'], true);
    }

    #[Route('/api/classes/{id}', name: 'deleteClasse', methods: ['DELETE'])]
    public function deleteClasse(Classe $classe, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($classe);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/classes', name: 'createClasse', methods: ['POST'])]
    public function createClasse(Request $request, SerializerInterface $serializer, CharacterRepository $characterRepository, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $classe = $serializer->deserialize($request->getContent(), Classe::class, 'json');
        
        $content = $request->toArray();
        $idCharacter = $content['id_character'] ?? null;
        
        if($idCharacter) {
            $classe->addCharacter($characterRepository->find($idCharacter));
        }
        
        $em->persist($classe);
        $em->flush();
        
        $jsonClass = $serializer->serialize($classe, 'json', ['groups' => 'getClasses']);

        $location = $urlGenerator->generate('getClasse', ['id' => $classe->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonClass, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/classes/{id}', name: 'deleteClasse', methods: ['PUT'])]
    public function updateClasse(Request $request, SerializerInterface $serializer, Classe $classe, EntityManagerInterface $em, CharacterRepository $characterRepository): JsonResponse
    {
        $updatedClasse = $serializer->deserialize($request->getContent(), Classe::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $classe]);
        $content = $request->toArray();
        $idCharacters = $content["id_characters"] ?? null;
        
        if(is_array($idCharacters) && count($idCharacters) > 0) {
            for ($i=0; $i < count($idCharacters) ; $i++) { 
                $updatedClasse->addCharacter($characterRepository->find($idCharacters[$i]));
            }
        }
        
        $em->persist($classe);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
