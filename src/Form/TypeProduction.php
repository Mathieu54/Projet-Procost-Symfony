<?php

namespace App\Form;

use App\Entity\Production;
use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeProduction extends AbstractType
{
    private $em;
    private $projetRepository;
    public function __construct(EntityManagerInterface $em, ProjetRepository $projetRepository)
    {
        $this->em = $em;
        $this->projetRepository = $projetRepository;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time_production'/*)->add('projet_id', EntityType::class, ['class' => Projet::class, 'choice_label' => 'name', 'choices' => $this->projetRepository->projet_non_rendu()]*/);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Production::class]);
    }
}
?>
