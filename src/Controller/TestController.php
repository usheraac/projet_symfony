<?php

namespace App\Controller;

use App\Entity\Employes;
use App\Entity\Incidents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\IncidentsForm;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;



class TestController extends AbstractController
{

/*
    public function home(){
        return $this-> render('test/home.html.twig');
    }*/


    /**
     * @Route("/", name="incident")
     * @Route("/incident", name="incident")
     */
    public function incident(){
        $incident = $this->getDoctrine()
            ->getRepository(Incidents::class) /* recupération des données en base de données sous forme de repository*/
            ->findAll(); /* retourne toute les entités incidents sous forme de tableau php*/

        return $this-> render('test/incident.html.twig', [   /*transmission à la vue*/
            'incident' => $incident,
        ]);
    }

    /**
     * @Route( "/employe", name="employe")
     */
    public function employe(){
        $employe = $this->getDoctrine()
            ->getRepository(Employes::class) /* recupération des données en base de données sous forme de repository*/
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
     * @Route("/deleteI/{id}", name="delete")
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

   /* serialisation */

    /**
     * @Route("/api/employe", name="db_employe", methods={"GET","HEAD"})
     */
    public function db_employe()
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $response = $this->convertToJson_Employe();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "POST");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
            return $response;
        }
    }

    /**
     * @Route("/api/incident", name="db_incident", methods={"GET","HEAD"})
     */
    public function db_incident()
    {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $response = $this->convertToJson_Incident();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set("Access-Control-Allow-Methods", "POST");
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type', true);
            return $response;
        }
    }

    public function convertToJson_Employe()
    {
        $encoders = array(new JsonEncoder()); // permet l'encodage sous forme de tableau JSON
        $normalizer = new ObjectNormalizer(); // utilisation de objectNormalizer pour directement accéder au propriété par le biais de getters et setters
        $normalizer->setCircularReferenceLimit(2); // après 2 sérialisation du même objet, on le considère comme référence circulaire pour eviter des boucles infinies
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer); //création d'un tableau pour la gestion des ObjetNormalizer
        $serializer = new Serializer($normalizers, $encoders); //on seriale nos objets avec l'encodeur JSON
        $projects = $this->getDoctrine()->getRepository(Employes::class)->findAll(); //récuperation de l'ensemble des objets employes en BD
        $projects = $serializer->serialize($projects, 'json'); // serialisation de les objets employes contenu dans $projects en format json grâce au service serializer de symphony
        $response = new JsonResponse(); // prépare la reponse HTTP pour transmetter du JSON
        $response->headers->set('Content-Type', 'application/json'); // définition  de l'entête de la response avec comme corps des données JSON
        $response->setContent($projects);// on set le corps de la response avec nos données JSON
        return $response;
    }

    public function convertToJson_Incident()
    {
        $encoders = array(new JsonEncoder());
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });

        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $projects = $this->getDoctrine()->getRepository(Incidents::class)->findAll();
        $projects = $serializer->serialize($projects, 'json');
        $response = new JsonResponse();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($projects);
        return $response;
    }




   /* deserialisation*/
    /**
     * @Route("/api/post_employe", name="post_employe", methods={"POST","HEAD"})
     */
    public function post_employe(Request $request)
    {
       // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = $request-> getContent();
            $employe = $this -> get('serializer')
                ->deserialize($data, Employes::class, 'json');
            $manager = $this ->getDoctrine()->getManager();
            $manager -> $this ->persist($employe);
            $manager -> flush();

            return new Reponse ('', Response::HTTP_CREATED);

       // }
    }

    /**
     * @Route("/api/post_incident", name="post_incident", methods={"POST","HEAD"})
     */
    public function post_incident(Request $request)
    {
        // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data = $request-> getContent();
        $incident = $this -> get('serializer')
            ->deserialize($data, Incidents::class, 'json');
        $manager = $this ->getDoctrine()->getManager();
        $manager -> $this ->persist($incident);
        $manager -> flush();

        return new Reponse ('', Response::HTTP_CREATED);

        // }
    }








}
