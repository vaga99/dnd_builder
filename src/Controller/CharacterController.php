<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Classe;
use App\Form\Type\CharacterType\CharacterType;
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
use App\Repository\CharacterClasseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class CharacterController extends AbstractController
{
    /**
     * Return all character
     */
    #[Route('characters', name: 'getCharacters')]
    public function getAllCharacters(
        CharacterRepository $characterRepository, 
        Request $request, 
        TagAwareCacheInterface $cache
    ): Response
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $idCache = "getAllCharacters-". $page . '-'.$limit;
        
        // Use cache to return value
        $characters = $cache->get($idCache, function (ItemInterface $item) use ($characterRepository, $page, $limit) {
            $item->tag("charactersCache");
            return $characterRepository->findAllWithPagination($page, $limit);
        });

        return $this->render('character/index.html.twig', [
            'characters' => $characters,
        ]);
    }

    /**
     * Return a Character in front
     */
    #[Route('characters/{id}', name: 'getCharacter')]
    public function getCharacter(
        Character $character, 
        CharacterRepository $characterRepository
    ): Response
    {
        return $this->render('character/details.html.twig', [
            'character' => $character,
        ]);
    }

    /**
     * Edit a Character in front
     */
    #[Route('characters/edit/{id}', name: 'editCharacter')]
    public function editCharacter(
        Character $character, 
        Request $request, 
        EntityManagerInterface $em,
        TagAwareCacheInterface $cache
    ): Response
    {
        $form = $this->createForm(CharacterType::class, $character);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $character = $form->getData();

            $em->persist($character);
            $em->flush();

            return $this->redirectToRoute('getCharacter', ['id' => $character->getId()]);
        }

        $cache->invalidateTags(["charactersCache"]);

        return $this->render('character/edit.html.twig', [
            'character' => $character,
            'form' => $form
        ]);
    }

    /**
     * Delete Character
     */
    #[Route('characters/delete/{id}', name: 'deleteCharacter')]
    public function deleteCharacter(
        Character $character, 
        EntityManagerInterface $em,
        CharacterClasseRepository $charaClasserepo,
        TagAwareCacheInterface $cache
    ): Response
    {

        $characterClasses = $charaClasserepo->findByCharacter($character);

        foreach ($characterClasses as $key => $characterClasse) {
            $em->remove($characterClasse);
        }

        $em->remove($character);
        $em->flush();
        $cache->invalidateTags(["charactersCache"]);

        return $this->redirectToRoute('getCharacters');
    }
}