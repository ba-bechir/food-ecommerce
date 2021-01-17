<?php

namespace App\Form;

use App\Entity\Article;
use App\Form\ConfigurationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends ConfigurationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('articleName', TextType::class, $this->getConfiguration("Nom de l'article", ""))
            ->add('price', MoneyType::class, $this->getConfiguration("Prix", ""))
            ->add('quantity', IntegerType::class, $this->getConfiguration("Quantité", ""))
            ->add('description', TextareaType::class, $this->getConfiguration("Description", ""))
            ->add('image', FileType::class, [
                'label' => 'Choisir une image',
                'multiple' => true, //Ajout de plusieurs images
                'mapped' => false, //Ne pas le lier à la BDD
                'required' => false
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
