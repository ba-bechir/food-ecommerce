<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationType extends AbstractType
{
    /**
     * Config de base d'un champ
     */
    protected function getConfiguration($label, $placeholder, $options = [])
    {
        return array_merge_recursive( [ 
            'label' => $label,
            'attr' => [
            'placeholder' => $placeholder
            ]
            ], $options);
    }
}
