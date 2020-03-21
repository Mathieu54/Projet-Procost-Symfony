<?php
namespace App\Controller;

use App\Entity\Metier;
use App\Form\TypeMetier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MetierController extends AbstractController
{
    /**
     * @Route("/metier", name="metier")
     */
    public function metier_list()
    {
        return $this->render('Panel_Metier/metiers_list.html.twig', ['menu_actif' => "metiers",  'all_metiers' => $this->getDoctrine()->getRepository(Metier::class)->findAll()]);
    }

    /**
     * @Route("/metier/add", name="metier_new")
     */
    public function metier_new(Request $request): Response
    {
        $newmetier = new Metier();
        $form = $this->createForm(TypeMetier::class, $newmetier);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','Métier ajouté avec succés !');
            $this->getDoctrine()->getManager()->persist($newmetier);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('metier');
        }
        return $this->render('Panel_Metier/metiers_form.html.twig', ['form' => $form->createView(),'menu_actif' => "metiers"]);
    }

    /**
     * @Route("/metier/edit/{id}", name="metier_edit")
     */
    public function metier_edit(Request $request, int $id)
    {
        $newmetier = new Metier();
        $form = $this->createForm(TypeMetier::class, $newmetier);
        $metier = $this->getDoctrine()->getRepository(Metier::class)->findOneById($id);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $metier = $this->getDoctrine()->getRepository(Metier::class)->findOneById($id);
            $metier->setLibelle($form["libelle"]->getData());

            $this->getDoctrine()->getManager()->persist($metier);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success','Métier modifié avec succés !');

            return $this->redirectToRoute('metier');
        }
        return $this->render('Panel_Metier/metiers_form_edit.html.twig', ['form' => $form->createView(),'menu_actif' => "metiers", 'id_metier' => $metier]);

    }

    /**
     * @Route("/metier/delete/{id}", name="metier_delete")
     */
    public function metier_delete(int $id)
    {
        $check_employe = $this->getDoctrine()->getRepository(Metier::class)->check_metier_employe();
        $get_id_metier = $this->getDoctrine()->getRepository(Metier::class)->findOneById($id);
        for($i = 0; $i < count($check_employe); $i++) {
            if($get_id_metier->getId() === (int)$check_employe[$i]['metier_id']) {
                var_dump($get_id_metier->getId());
                var_dump((int)$check_employe[1]['metier_id']);
            } else {
                $this->getDoctrine()->getManager()->remove($get_id_metier);
                $this->getDoctrine()->getManager()->flush();
            }
        }

    }

}

