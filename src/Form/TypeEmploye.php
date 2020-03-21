<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Metier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeEmploye extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('password')
            ->add('cout_horaire')
            ->add('date_embauche')
            ->add('url_img')
            ->add('metier', EntityType::class, [
                'class' => Metier::class,
                'choice_label' => 'libelle',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Employe::class]);
    }
}
?>
