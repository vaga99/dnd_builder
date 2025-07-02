<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Repository\CharacterRepository;
use App\Repository\ClasseRepository;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use JMS\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;
use App\Form\Type\ClasseType\ClasseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ClasseController extends AbstractController
{
    /**
     * Return all Classe in json format
     */
    #[Route('/classes', name: 'getClasses', methods: ['GET'])]
    public function getAllClasses(ClasseRepository $classeRepository, CharacterRepository $characterRepository, SerializerInterface $serializer, Request $request, TagAwareCacheInterface $cache): JsonResponse
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 2);
        $idCache = "getAllClasses-". $page . '-'.$limit;
        
        // Use cache to return value
        $return = $cache->get($idCache, function (ItemInterface $item) use ($classeRepository, $characterRepository, $serializer, $page, $limit) {
            $item->tag("classesCache");
            $classeList = $classeRepository->findAllWithPagination($page, $limit);
            $return = [];
            $context = SerializationContext::create()->setGroups(['getClasses']);
            $context2 = SerializationContext::create()->setGroups(['getClasses']);
            
            foreach ($classeList as $key => $classe) {
                $characterList = $characterRepository->findByClasse($classe);
                $charactersInfo = [];
                foreach ($characterList as $key2 => $character) {
                    $charactersInfo[] = [
                        "id" => $character->getId(),
                        "name" => $character->getName()
                    ];
                }

                $return[] = [
                    "classe_".$classe->getId() => [
                        "classe_info" => json_decode($serializer->serialize($classe, 'json', $context)),
                        // "character_list" => json_decode($serializer->serialize($characterList, 'json'))
                        "character_list" => $charactersInfo
                    ]
                ];
            }
            return $return;
        });


        return new JsonResponse(json_encode($return), Response::HTTP_OK, [], true);
    }

    /**
     * Return a Classe in twig template
     */
    #[Route('/newClasses', name: 'createClasse')]
    public function createClasse(Request $request, EntityManagerInterface $em): Response
    {
        $classe = new Classe();
        $form = $this->createForm(ClasseType::class, $classe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $classe = $form->getData();

            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('editClasse', ['id' => $classe->getId()]);
        }

        return $this->render('classe/index.html.twig', [
            'classe' => $classe,
            'form' => $form
        ]);
    }

    /**
     * Edit Classe
     */
    #[Route('/classes/{id}', name: 'editClasse')]
    public function updateClasse(
        Classe $classe, 
        Request $request, 
        EntityManagerInterface $em
        ): Response
    {
        $form = $this->createForm(ClasseType::class, $classe);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $classe = $form->getData();

            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('editClasse', ['id' => $classe->getId()]);
        }

        return $this->render('classe/index.html.twig', [
            'classe' => $classe,
            'form' => $form
        ]);
    }
}