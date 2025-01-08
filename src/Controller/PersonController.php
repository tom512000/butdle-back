<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PersonController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Person::class);

        $persons = $repository->findAll();

        if (empty($persons)) {
            return new JsonResponse(['message' => 'No person found'], 404);
        }

        $randomPerson = $persons[array_rand($persons)];

        return new JsonResponse([
            'firstname' => $randomPerson->getFirstName(),
            'lastname' => $randomPerson->getLastName(),
            'gender' => $randomPerson->getGender(),
            'job' => $randomPerson->getJob(),
            'status' => $randomPerson->getStatus(),
            'image' => $randomPerson->getImage(),
            'subjects' => $randomPerson->getSubjects()->map(fn($subject) => $subject->getName())->toArray(),
        ]);
    }
}
