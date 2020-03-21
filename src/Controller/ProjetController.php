<?php
namespace App\Controller;

use App\Entity\Projet;
use App\Form\TypeProjet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetController extends AbstractController
{
    /**
     * @Route("/projet", name="projet")
     */
    public function projet_list()
    {
        return $this->render('Panel_Projet/projets_list.html.twig', ['menu_actif' => "projets", 'all_projets' => $this->getDoctrine()->getRepository(Projet::class)->findBy(array(), array('date_creation' => 'desc'))]);
    }

    /**
     * @Route("/projet/add", name="projet_new")
     */
    public function projet_new(Request $request): Response
    {
        $newprojet = new Projet();
        $form = $this->createForm(TypeProjet::class, $newprojet);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success-projet','Projet ajouté avec succés !');
            $this->getDoctrine()->getManager()->persist($newprojet);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('projet');
        }
        return $this->render('Panel_Projet/projets_form.html.twig', ['form' => $form->createView(),'menu_actif' => "projets"]);
    }

    /**
     * @Route("/projet/edit/{id}", name="projet_edit")
     */
    public function projet_edit(Request $request, int $id)
    {
        $newprojet = new Projet();
        $form = $this->createForm(TypeProjet::class, $newprojet);
        $projet = $this->getDoctrine()->getRepository(Projet::class)->findOneById($id);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $projet = $this->getDoctrine()->getRepository(Projet::class)->findOneById($id);
            $projet->setNom($form["nom"]->getData());
            $projet->setDescription($form["description"]->getData());
            $projet->setPrixVente($form["prix_vente"]->getData());
            $projet->setDateCreation($form["date_creation"]->getData());
            $this->getDoctrine()->getManager()->persist($projet);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success-projet','Projet modifié avec succés !');
            return $this->redirectToRoute('projet');
        }
        return $this->render('Panel_Projet/projets_form_edit.html.twig', ['form' => $form->createView(),'menu_actif' => "projets", 'id_projet' => $projet]);
    }

    /**
     * @Route("/projet/end/{id}", name="projet_end")
     */
    public function projet_end(Request $request, int $id)
    {
        $projet = $this->getDoctrine()->getRepository(Projet::class)->findOneById($id);
        $projet->setDateLivraison(new \DateTime('now'));
        $this->getDoctrine()->getManager()->persist($projet);
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('success-projet','Vous avez terminé le projet : ' . $projet->getNom());
        return $this->redirectToRoute('projet');
    }


    /**
     * @Route("/projet/voir/{id}", name="projet_voir")
     */
    public function projet_voir(Request $request, int $id)
    {
        $projet = $this->getDoctrine()->getRepository(Projet::class)->findOneById($id);
        return $this->render('Panel_Projet/projets_voir.html.twig', ['menu_actif' => "projets", 'projet' => $projet]);
    }


}
