<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Metier;
use App\Entity\Production;
use App\Entity\Projet;
use App\Form\TypeEmploye;
use App\Form\TypeProduction;
use App\Form\TypeProfil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    /**
     * @Route("/employe", name="employe")
     */
    public function employe_list()
    {
        return $this->render('Panel_Employe/employes_list.html.twig', ['menu_actif' => "employes",  'all_employes' => $this->getDoctrine()->getRepository(Employe::class)->all_employes()]);
    }

    /**
     * @Route("/employe/new", name="employe_new", methods={"GET", "POST"})
     */
    public function employe_new(Request $request): Response
    {
        $newemploye = new Employe();
        $form = $this->createForm(TypeEmploye::class, $newemploye);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success_employe','Employé ajouté avec succés !');
            $this->getDoctrine()->getManager()->persist($newemploye);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('employe');
        }
        return $this->render('Panel_Employe/employes_form.html.twig', ['form' => $form->createView(),'menu_actif' => "employes"]);
    }

    /**
     * @Route("/employe/voir/{id}", name="employe_voir")
     */
    public function employe_voir(Request $requete, int $id)
    {
        $production = new Production();
        $form = $this->createForm(TypeProduction::class, $production);
        $projet_id = $this->getDoctrine()->getRepository(Projet::class)->findOneById(5);
        $employe_id = $this->getDoctrine()->getRepository(Employe::class)->findOneById($id);
        $form->handleRequest($requete);
        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success_ajout_prod_employe','Vouvs venez d\'ajouter du temps de production !');
            $production->setTimeProduction($form["time_production"]->getData());
            $production->setDateAjout(new \DateTime('now'));
            $production->addProjetId($projet_id);
            $production->addEmployeId($employe_id);
            $this->getDoctrine()->getManager()->persist($production);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('employe_voir',array('id' => $id));
        }
        $employe = $this->getDoctrine()->getRepository(Employe::class)->findOneById($id);
        $production_profil = $this->getDoctrine()->getRepository(Production::class)->production_profil($id);
        return $this->render('Panel_Employe/employes_voir.html.twig', ['form' => $form->createView(),'menu_actif' => "employes", "employe" => $employe, "production_profil" => $production_profil]);
    }

    /**
     * @Route("/profil", name="profil")
     */
    public function mon_profil(Request $requete)
    {
        $production = new Production();
        $form = $this->createForm(TypeProduction::class, $production);
        $projet_id = $this->getDoctrine()->getRepository(Projet::class)->findOneById(5);
        $employe_id = $this->getDoctrine()->getRepository(Employe::class)->findOneById($this->getUser()->getId());
        $form->handleRequest($requete);
        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success_ajout_prod','Vouvs venez d\'ajouter du temps de production !');
            $production->setTimeProduction($form["time_production"]->getData());
            $production->setDateAjout(new \DateTime('now'));
            $production->addProjetId($projet_id);
            $production->addEmployeId($employe_id);
            $this->getDoctrine()->getManager()->persist($production);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('profil');
        }
        $user = $this->getUser()->getId();
        $projet_non_livre = $this->getDoctrine()->getRepository(Projet::class)->projet_non_rendu();
        $production_profil = $this->getDoctrine()->getRepository(Production::class)->production_profil($user);
        return $this->render('Panel_Employe/employes_profil.html.twig', ['form' => $form->createView(), 'menu_actif' => "employes", "projet_non_livre" => $projet_non_livre, "production_profil" => $production_profil]);
    }

    /**
     * @Route("/profil/modif", name="profil_modif")
     */
    public function profil_modif(Request $request)
    {
        $employe = $this->getDoctrine()->getRepository(Employe::class)->findOneById($this->getUser()->getId());
        $form = $this->createForm(TypeProfil::class, $employe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success_profil_modif','Votre profil vient d\'étre modifié !');
            $employe->setNom($form["nom"]->getData());
            $employe->setPrenom($form["prenom"]->getData());
            $employe->setEmail($form["email"]->getData());
            $this->getDoctrine()->getManager()->persist($employe);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('employe');
        }
        return $this->render('Panel_Employe/employes_form_edit_profil.html.twig', ['form' => $form->createView(),'menu_actif' => "employes"]);
    }

}
?>
