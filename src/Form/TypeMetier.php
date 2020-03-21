<?php

namespace App\Form;

use App\Entity\Metier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeMetier extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder->add('libelle' ,TextType::class, ['label' => 'Libellé']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Metier::class]);
    }
}

?>
