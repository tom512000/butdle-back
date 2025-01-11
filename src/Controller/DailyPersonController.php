<?php

namespace App\Controller;

use App\Entity\DailyPerson;
use App\Entity\Person;
use App\Entity\Subject;
use App\Repository\DailyPersonRepository;
use App\Repository\PersonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DailyPersonController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws RandomException
     */
    public function __invoke(DailyPersonRepository $dailyRepository, PersonRepository $personRepository): JsonResponse
    {
        $dailyPersonExist = $dailyRepository->findOneBy([]);
        if (!$dailyPersonExist) {
            $dailyPerson = new DailyPerson();
            $dailyPerson->setCreatedDate(new \DateTime());
            $dailyPerson->addPerson($personRepository->generateRandomPerson()[0]);

            $this->entityManager->persist($dailyPerson);
            $this->entityManager->flush();
        }

        $dailyPerson = $dailyRepository->findOneBy([]);
        if ($dailyPerson->getCreatedDate()->format('Y-m-d') !== (new \DateTime())->format('Y-m-d')) {
            $dailyPerson->setCreatedDate(new \DateTime());
            $dailyPerson->getPerson()->clear();
            $dailyPerson->addPerson($personRepository->generateRandomPerson()[0]);

            $this->entityManager->persist($dailyPerson);
            $this->entityManager->flush();
        }

        $dailyPerson = $dailyRepository->findOneBy([]);
        $person = $dailyPerson->getPerson()->first();
        return new JsonResponse([
            'firstname' => $person->getFirstName(),
            'lastname' => $person->getLastName(),
            'gender' => $person->getGender(),
            'job' => $person->getJob(),
            'status' => $person->getStatus(),
            'image' => $person->getImage(),
            'subjects' => $person->getSubjects()->map(fn($subject) => $subject->getName())->toArray(),
            'createdDate' => $dailyPerson->getCreatedDate()->format('d-m-Y'),
        ]);
    }
}
