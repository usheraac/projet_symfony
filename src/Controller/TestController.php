<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Entity\Incidents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\EmployesForm;
use App\Form\IncidentsForm;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TestController extends AbstractController
{/**
 * @Route("/", name="home")
 */

    public function home(){
        return $this-> render('test/home.html.twig');
    }


    /**
     * @Route("/incident", name="incident")
     */
    public function incident(){
        return $this-> render('test/incident.html.twig');
    }

    /**
     * @Route("/employe", name="employe")
     */
    public function employe(){
        $employe = $this->getDoctrine()
            ->getRepository(Employes::class)
            ->findAll();
        return $this-> render('test/employe.html.twig', [
            'employe' => $employe,
        ]);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about(){
        return $this-> render('test/about.html.twig');
    }

    /**
     * @Route("/createIncident", name ="new_incident")
     */

    public function createIncident(Request $request, ObjectManager $manager)
    {
        $incident = new Incidents();

        $form = $this->createForm(IncidentsForm::class, $incident);
        $form-> handleRequest($request);

        if ($form->isSubmitted() && $form-> isValid()){
            $manager->persist($incident);
            $manager->flush();

            return $this->redirectToRoute('test/incident.html.twig');
        }

        return $this->render('test/incident.html.twig', [
            'incidentsForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/ajoutEmploye")

    public function index()
    {

        $form = $this->createForm(EmployesForm::class);

        return $this->render('test/ajoutEmploye.html.twig', [
            'employesForm' => $form->createView()
        ]);
    }
     */



}
