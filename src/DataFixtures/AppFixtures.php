<?php

namespace App\DataFixtures;


use App\Entity\Employe;
use App\Entity\Metier;
use App\Entity\Production;
use App\Entity\Projet;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture {
    /**
     * @var ObjectManager
     */
    private $manager;

    function load(ObjectManager $manager):void {
        $this->manager = $manager;
        $this->addProjet();
        $this->addMetier();
        $this->addEmploye();
        $this->addTimeProduction();
        $this->manager->flush();
    }

    private function addProjet(): void {
        $input_description = array("Un projet assez ambitieux, pour la taille du programme", "Update d'un ancien projet", "Nouveau projet pour l'entreprise !", "Petit projet pour une PME", "Projet à l'abandon pour l'instant","Etude d'un projet pour le commerce Marketing", "Développement d'un site web pour Coiffure", "Construction d'une API pour l'IA de la NASA", "Création d'un projet Symfony pour les Licences Pro Web");
        $input_date = array("2019-01-20","2020-02-02","2020-02-12","2020-02-22","2020-03-02","2020-03-15","2020-03-16","2020-03-18","2020-03-22","2020-04-15","2020-05-14");
        for($i = 0; $i < 20; $i++) {
            $random_desc = $input_description[rand(0,8)];
            $random_date = $input_date[rand(0,10)];
            $random_livre = rand(0,1);
            if($random_livre == 1) {
                $random_livre = null;
            } else {
                $random_livre = new \DateTime('now');
            }
            $projet = (new Projet())->setNom("Projet N°".$i)
                ->setDescription($random_desc)
                ->setPrixVente(rand(500,10000))
                ->setDateCreation(DateTime::createFromFormat('Y-m-d', $random_date))
                ->setDateLivraison($random_livre);
            $this->manager->persist($projet);
        }
    }

    private function addMetier(): void {
        $metier = (new Metier())->setLibelle("Web Designer");
        $this->manager->persist($metier);
        $metier = (new Metier())->setLibelle("SEO Manager");
        $this->manager->persist($metier);
        $metier = (new Metier())->setLibelle("Web Developper");
        $this->manager->persist($metier);
        $metier = (new Metier())->setLibelle("Chef Developper");
        $this->manager->persist($metier);
    }

    private function addEmploye(): void {
        $job_random = rand(1,4);
        $metier = $this->manager->getReference(Metier::class, $job_random);
        $employe = (new Employe())->setRoles((array)"ROLE_MANAGER")
            ->setEmail("manager@gmail.com")
            ->setDateEmbauche(DateTime::createFromFormat('Y-m-d', "2019-05-05"))
            ->setPrenom("Luc")
            ->setNom("Yard")
            ->setCoutHoraire(rand(15,50))
            ->setUrlImg("img/ui-zac.jpg")
            ->setPassword("$2y$10$/F./kLkFvfffEgO4G41JqudvWEI2a.rOnx.zCx6h2TCkJQPSIeNkG")
            ->setMetier($metier);
        $this->manager->persist($employe);

        $job_random = rand(1,4);
        $metier = $this->manager->getReference(Metier::class, $job_random);
        $employe = (new Employe())->setRoles((array)"ROLE_EMPLOYE")
            ->setEmail("employe@gmail.com")
            ->setDateEmbauche(DateTime::createFromFormat('Y-m-d', "2019-07-10"))
            ->setPrenom("Bernard")
            ->setNom("Gurl")
            ->setCoutHoraire(rand(15,50))
            ->setUrlImg("img/ui-sherman.jpg")
            ->setPassword("$2y$10$/F./kLkFvfffEgO4G41JqudvWEI2a.rOnx.zCx6h2TCkJQPSIeNkG")
            ->setMetier($metier);
        $this->manager->persist($employe);

        $job_random = rand(1,4);
        $metier = $this->manager->getReference(Metier::class, $job_random);
        $employe = (new Employe())->setRoles((array)"ROLE_EMPLOYE")
            ->setEmail("employe2@gmail.com")
            ->setDateEmbauche(DateTime::createFromFormat('Y-m-d', "2020-01-05"))
            ->setPrenom("Marine")
            ->setNom("Paquito")
            ->setCoutHoraire(rand(15,50))
            ->setUrlImg("img/ui-divya.jpg")
            ->setPassword("$2y$10$/F./kLkFvfffEgO4G41JqudvWEI2a.rOnx.zCx6h2TCkJQPSIeNkG")
            ->setMetier($metier);
        $this->manager->persist($employe);
    }

    private function addTimeProduction(): void {
        $input_date = array("2019-01-20","2020-02-02","2020-02-12","2020-02-22","2020-03-02","2020-03-15","2020-03-16","2020-03-18","2020-03-22");
        for($i = 0; $i < 50; $i++) {
            $random_date = $input_date[rand(0,8)];
            $random_time_prod = rand(1, 50);
            $random_user = rand(1, 3);
            $random_projet = rand(1, 19);
            $employe = $this->manager->getReference(Employe::class, $random_user);
            $projet = $this->manager->getReference(Projet::class, $random_projet);
            $production = (new Production())->setTimeProduction($random_time_prod)->setDateAjout(DateTime::createFromFormat('Y-m-d', $random_date))->addEmployeId($employe)->addProjetId($projet);
            $this->manager->persist($production);
        }
    }

}
?>



