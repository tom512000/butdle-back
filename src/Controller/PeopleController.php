<?php

namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PeopleController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(): JsonResponse
    {
        $repository = $this->entityManager->getRepository(Person::class);
        $people = [];

        foreach ($repository->findAll() as $person) {
            $people[] = [
                'firstname' => $person->getFirstName(),
                'lastname' => $person->getLastName(),
                'gender' => $person->getGender(),
                'job' => $person->getJob(),
                'status' => $person->getStatus(),
                'image' => $person->getImage(),
                'subjects' => $person->getSubjects()->map(fn($subject) => $subject->getName())->toArray(),
            ];
        }

        return new JsonResponse($people);
    }
}
