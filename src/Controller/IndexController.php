<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Production;
use App\Entity\Projet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/", name="index")
     */
    public function index() {
        return $this->redirectToRoute('panel_login');
    }

    /**
     * @Route("/home", name="panel_home")
     */
    public function home() {

        $projet_en_cour = $this->getDoctrine()->getRepository(Projet::class)->total_projet_en_cour();
        $projet_livre = $this->getDoctrine()->getRepository(Projet::class)->total_projet_livre();
        $all_projet = $this->getDoctrine()->getRepository(Projet::class)->all_projet();
        $all_employe = $this->getDoctrine()->getRepository(Employe::class)->all_employe();
        $total_production = $this->getDoctrine()->getRepository(Production::class)->total_production();
        $taux_livraison = round(($projet_livre*100)/$all_projet, 2);
        $taux_rentabilite = round(($all_projet*100)/$total_production, 2);
        $projet_recent = $this->getDoctrine()->getRepository(Projet::class)->findBy(array(), array('date_creation' => 'desc'), 5);
        $data_projet = array();
        $production_recent = $this->getDoctrine()->getRepository(Production::class)->temps_production_list();
        $top_employe = $this->getDoctrine()->getRepository(Employe::class)->top_employe();
        foreach($projet_recent as $projet_for)
        {
            $data_projet[$projet_for->getid()]['id'] = $projet_for->getid();
            $data_projet[$projet_for->getid()]['nom'] = $projet_for->getNom();
            $data_projet[$projet_for->getid()]['date_creation'] = $projet_for->getDateCreation();
            $data_projet[$projet_for->getid()]['prix_vente'] = $projet_for->getPrixVente();
            $data_projet[$projet_for->getid()]['date_livraison'] = $projet_for->getDateLivraison();
        }
        return $this->render('Panel_Home/index.html.twig', ['menu_actif' => "dashboard",'projet_en_cour' => $projet_en_cour, 'projet_livre' => $projet_livre, 'taux_livraison' => $taux_livraison, 'taux_rentabilite' => $taux_rentabilite, 'all_employe' => $all_employe, 'data_projet' => $data_projet, 'total_production' => $total_production, 'data_production' => $production_recent, 'top_employe' => $top_employe]);

    }

}
