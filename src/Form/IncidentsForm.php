<?php
/**
 * Created by PhpStorm.
 * User: isaac
 * Date: 09/11/2018
 * Time: 16:09
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class IncidentsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet')
            ->add('description')
            ->add('service')
            ->add('Date')
            ->add('DateTarget')
            ->add('status')
            ->add('discussion')
            ->add('employe')
            ;
    }


}