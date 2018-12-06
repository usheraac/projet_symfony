<?php
/**
 * Created by PhpStorm.
 * User: isaac
 * Date: 09/11/2018
 * Time: 15:29
 */

namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class EmployesForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('departement')
            ->add('fonction')
            ->add('telephone')
            ->add('Email')
            ->add('password')
            ->add('confirm_password')

        ;
    }

}

