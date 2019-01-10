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
        $incident = $this->getDoctrine()
            ->getRepository(Incidents::class)
            ->findAll();
        return $this-> render('test/incident.html.twig', [
            'incident' => $incident,
        ]);
    }

    /**
     * @Route("/employe", name="employe")
     */
    public function employe(){
        $employe = $this->getDoctrine()
            ->getRepository(Employes::class) /* recupération des données en base de données sous forme de reposotory*/
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
     * @Route("/editI/{id}", name ="incident_edit")
     */

    public function createIncident(Incidents $incident = null, Request $request, ObjectManager $manager)
    {
        if(!$incident){
            $incident = new Incidents();
        }


        $form = $this->createForm(IncidentsForm::class, $incident);
        $form-> handleRequest($request);

        if ($form->isSubmitted() && $form-> isValid()){
            $manager->persist($incident);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('test/createInc.html.twig', [
            'incidentsForm' => $form->createView(),
            'editMode' => $incident -> getId() !== null
        ]);
    }

    /**
     * @Route("/deleteI/{id}", name="employe_delete")
     */
    public function delete(Incidents $this_incident , ObjectManager $manager)
    {

        $manager->remove($this_incident);  /*suppression de l'employé  */
        $manager->flush();

        $incident = $this->getDoctrine()
            ->getRepository(Incidents::class)
            ->findAll();
        return $this-> render('test/incident.html.twig', [
            'incident' => $incident,
        ]);


    }

//    /**
//     * @Route("/api/idesk", name="db-idesk", methods=("GET", "PUT", "OPIONS")
//     */
//    public function DB_projects()
//    {
//
//    }




}
