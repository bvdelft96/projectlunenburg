<?php
//Namespace en uses, mag je vergeten. Moet er wel in staan!
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Bestelregel;
use AppBundle\Entity\Bestelling;
use AppBundle\Form\Type\BestellingType;
use AppBundle\Form\Type\BestelregelType;
use AppBundle\Entity\Artikel;
use AppBundle\Form\Type\ArtikelType;

class BestellingController extends Controller
{
    
    /**
     * @Route ("/inkoper/bestelopdrachten/, name="allebestelopdrachten")
     *
     */
    public function alleBestelopdrachten(Request $request){

        $artikelen = $this->getDoctrine()->getRepository("AppBundle:Artikel")->findAll();
        $bestellingen = $this->getDoctrine()->getRepository("AppBundle:Bestelling")->findAll();
        

        //Verwijzing naar formulier
        return $this->render('inkoper/bestelregel.html.twig', [
            'bestellingen' => $bestellingen,
            'artikelen' => $artikelen

        ]);

    }

    /**
    * @Route("/inkoper/bestelling/nieuw", name="bestellingnieuw")
    */
    public function nieuweBestelling (Request $request) {
        $nieuweBestelling = new Bestelling();
        $form = $this->createForm(BestellingType::class, $nieuweBestelling);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nieuweBestelling);
            $em->flush();
            return $this->redirect($this->generateurl("bestelregelnieuw"));
        }

        //Verwijzing naar formulier
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Bestelling toevoegen',
        ]);
    }

    /**
    * @Route("/inkoper/bestelregel/nieuw", name="bestelregelnieuw")
    */
    public function nieuweBestelregel (Request $request) {
        $nieuweBestelregel = new Bestelregel();
        $form = $this->createForm(BestelregelType::class, $nieuweBestelregel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nieuweBestelregel);
            $em->flush();
            return $this->redirect($this->generateurl("inkoperallebestelopdrachten"));
        }

        //Verwijzing naar formulier
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Bestelling toevoegen',
        ]);
    }
}
   