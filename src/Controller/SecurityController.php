<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Employes;
use App\Form\EmployesForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     * @Route("/editE/{id}", name="employe_edit")
     */
    public function registration(Employes $employe = null, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        if (!$employe){
            $employe = new Employes();
        }
        $form = $this -> createForm(EmployesForm::class, $employe); /*creation du formulaire pour enregistrer un employé */
        $form->handleRequest($request); // On vérifie que les réçu sont entrées sont correctes

        if ($form->isSubmitted() && $form-> isValid()){
            $hash = $encoder-> encodePassword($employe, $employe->getPassword());  /*Encodage du  mot de passe*/
            $employe->setPassword($hash); /*changement  du  mot de passe par l'encodé*/
            $manager->persist($employe);  /*persistence des données de la variable employe */
            $manager->flush();  /*chargement des données dans la BD*/

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form'=> $form -> createView(), /*passer le formulaire à twig */
            'editMode' => $employe -> getId() !== null  /*faire passer twig en EditMode */
        ]);

    }

    /**
     * @Route("/deleteE/{id}", name="employe_delete")
     */
    public function delete(Employes $this_employe , ObjectManager $manager)
    {

            $manager->remove($this_employe);  /*suppression de l'employé  */
            $manager->flush();

            $employe = $this->getDoctrine()
                ->getRepository(Employes::class) /* recupération des données en base de données sous forme de reposotory*/
                ->findAll();
            return $this-> render('test/employe.html.twig', [
                'employe' => $employe,
            ]);


    }

    /**
     * @Route("/connexion", name="security_login")
     */

    public function login(Request $request, AuthenticationUtils $utils){
        $error = $utils ->getLastAuthenticationError();
        return $this-> render('security/login.html.twig', [
            'error' => $error,


        ]);
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */

    public function logout(){

    }

}
