<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EmployesForm;
use App\Form\IncidentsForm;

class TestController extends AbstractController
{
    /**
     * @Route("/")
     */
    /*public function index()
    {

        $form = $this->createForm(EmployesForm::class);

        return $this->render('test/index.html.twig', [
            'employesForm' => $form->createView()
        ]);
    }*/

    /**
     * @Route("/createInc")
     */
    public function createInc()
    {

        $form = $this->createForm(IncidentsForm::class);

        return $this->render('test/createInc.html.twig', [
            'incidentsForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/ajoutEmploye")
     */
    public function index()
    {

        $form = $this->createForm(EmployesForm::class);

        return $this->render('test/ajoutEmploye.html.twig', [
            'employesForm' => $form->createView()
        ]);
    }



}
