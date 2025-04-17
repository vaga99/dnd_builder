<?php

namespace App\Controller;

use App\Entity\CharacterClasse;
use App\Entity\Classe;
use App\Repository\CharacterClasseRepository;
use App\Repository\CharacterRepository;
use App\Repository\ClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ClasseController extends AbstractController
{
    /**
     * Return all Classe in json format
     */
    #[Route('/api/classes', name: 'getClasses', methods: ['GET'])]
    public function getAllClasses(ClasseRepository $classeRepository, CharacterRepository $characterRepository, SerializerInterface $serializer): JsonResponse
    {
        $classeList = $classeRepository->findAll();
        $return = [];
        foreach ($classeList as $key => $classe) {
            $characterList = $characterRepository->findByClasse($classe);
            $return[] = [
                "classe_".$classe->getId() => [
                    "classe_info" => json_decode($serializer->serialize($classe, 'json', ['groups' => 'getClasses'])),
                    "character_list" => json_decode($serializer->serialize($characterList, 'json', ['groups' => 'getClasses']))
                ]
            ];
        }

        return new JsonResponse(json_encode($return), Response::HTTP_OK, [], true);
    }

    /**
     * Return a Classe in json format
     */
    #[Route('/api/classes/{id}', name: 'getClasse', methods: ['GET'])]
    public function getClasseDetails(Classe $classe, SerializerInterface $serializer, CharacterRepository $characterRepository): JsonResponse
    {

        $characterList = $characterRepository->findByClasse($classe);

        $return = [
            "classe_".$classe->getId() => [
                "classe_info" => json_decode($serializer->serialize($classe, 'json', ['groups' => 'getClasses'])),
                "character_list" => json_decode($serializer->serialize($characterList, 'json', ['groups' => 'getClasses']))
            ]
        ];

        return new JsonResponse(json_encode($return), Response::HTTP_OK, [], true);
    }

    /**
     * Delete Classe
     */
    #[Route('/api/classes/{id}', name: 'deleteClasse', methods: ['DELETE'])]
    #[IsGranted('ROLE_DM', message: 'you\'re not allowed to delete a Classe')]
    public function deleteClasse(Classe $classe, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($classe);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Add Classe
     */
    #[Route('/api/classes', name: 'createClasse', methods: ['POST'])]
    #[IsGranted('ROLE_DM', message: 'you\'re not allowed to create a Classe')]
    public function createClasse(
        Request $request, 
        SerializerInterface $serializer, 
        CharacterRepository $characterRepository, 
        EntityManagerInterface $em, 
        UrlGeneratorInterface $urlGenerator,
        ValidatorInterface $validator
    ): JsonResponse {

        $classe = $serializer->deserialize($request->getContent(), Classe::class, 'json');

        $errors = $validator->validate($classe);
        if($errors->count()) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }
        
        $content = $request->toArray();
        $characters = $content['characters'] ?? null;
        
        if(is_array($characters) && count($characters) > 0) {
            for ($i=0; $i < count($characters) ; $i++) {

                // Check if level & character exist in request
                if(isset($characters[$i]["character"]) && isset($characters[$i]["level"])) {
                    $character = $characterRepository->find($characters[$i]["character"]) ?? null;
                    $level = $characters[$i]["level"];

                    // Security check if character & field are valid
                    if($character && is_int($level)) {
                        $characterClasse = new CharacterClasse();
                        $characterClasse->setClasse($classe);
                        $characterClasse->setCharacter($character);
                        $characterClasse->setLevel($level);
                        $em->persist($characterClasse);
                    }
                }
            }
        }
        
        $em->persist($classe);
        $em->flush();

        $jsonClass = $serializer->serialize($classe, 'json', ['groups' => 'getClasses']);
        $location = $urlGenerator->generate('getClasse', ['id' => $classe->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonClass, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    /**
     * Edit Classe
     */
    #[Route('/api/classes/{id}', name: 'deleteClasse', methods: ['PUT'])]
    #[IsGranted('ROLE_DM', message: 'you\'re not allowed to update a Classe')]
    public function updateClasse(Request $request, SerializerInterface $serializer, Classe $classe, EntityManagerInterface $em, CharacterRepository $characterRepository): JsonResponse
    {
        $updatedClasse = $serializer->deserialize($request->getContent(), Classe::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $classe]);
        
        // Get characters in request
        $content = $request->toArray();
        $characters = $content["characters"] ?? null;
        
        if(is_array($characters) && count($characters) > 0) {
            $characterClasses = $classe->getCharacterClasses()->toArray();
        
            // Delete old characters
            if(is_array($characterClasses) && count($characterClasses) > 0) {
                for ($i=0; $i < count($characterClasses); $i++) {
                    $em->remove($characterClasses[$i]);
                }
            }
        
            if(is_array($characters) && count($characters) > 0) {
                for ($i=0; $i < count($characters) ; $i++) {

                    // Check if level & character exist in request
                    if(isset($characters[$i]["character"]) && isset($characters[$i]["level"])) {
                        $character = $characterRepository->find($characters[$i]["character"]) ?? null;
                        $level = $characters[$i]["level"];

                        // Security check if character & field are valid
                        if($character && is_int($level)) {
                            $characterClasse = new CharacterClasse();
                            $characterClasse->setClasse($classe);
                            $characterClasse->setCharacter($character);
                            $characterClasse->setLevel($level);
                            $em->persist($characterClasse);
                        }
                    }
                }
            }
        }
        
        $em->persist($classe);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
