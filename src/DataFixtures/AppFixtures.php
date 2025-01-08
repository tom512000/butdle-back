<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jsonData = file_get_contents(__DIR__ . '/data/persons.json');
        $persons = json_decode($jsonData, true);
        $existingSubjects = [];

        foreach ($persons as $personData) {
            $person = new Person();
            $person->setFirstName($personData['prenom']);
            $person->setLastName($personData['nom']);
            $person->setGender($personData['genre']);
            $person->setJob($personData['emploi']);
            $person->setStatus($personData['statut']);
            $person->setImage($personData['image']);

            if (!empty($personData['matieres'])) {
                foreach ($personData['matieres'] as $subjectName) {
                    if (!isset($existingSubjects[$subjectName])) {
                        $subject = new Subject();
                        $subject->setName($subjectName);

                        $manager->persist($subject);

                        $existingSubjects[$subjectName] = $subject;
                    } else {
                        $subject = $existingSubjects[$subjectName];
                    }

                    $person->addSubject($subject);
                }
            }

            $manager->persist($person);
        }

        $manager->flush();
    }
}
