<?php

namespace App\Controller;

use App\Entity\Character;
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

final class CharacterController extends AbstractController
{
    /**
     * Return all Classe in json format
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
    public function getCharacterDetails(
        Character $character, 
        SerializerInterface $serializer, 
        CharacterRepository $characterRepository
    ): Response
    {
        return $this->render('character/details.html.twig', [
            'character' => $character,
        ]);
    }
}