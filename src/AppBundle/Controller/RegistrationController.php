<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\UserType;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{

    //Functie om een gebruiker te registreren.

    /**
     * @Route("/admin/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('admin');
        }

        return $this->render(
            'registration/register.html.twig', array('form' => $form->createView()) );
    }

    //Functie om een gebruiker te wijzigen als admin

    /** 
    * @Route ("/admin/user/wijzigen/{id} ", name="userwijzigen")
    */
    public function wijzigInkoperartikel(Request $request, $id){
        $bestaandeUser = $this->getDoctrine()->getRepository("AppBundle:User")->find($id);
        $form = $this->createForm(UserType::class, $bestaandeUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bestaandeUser);
            $em->flush();
            //Verwijziging naar de pagina admin
            return $this->redirectToRoute('admin');
        }

        //Verwijzing naar formulier
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Gebruiker wijzigen',
        ]);
    }








}