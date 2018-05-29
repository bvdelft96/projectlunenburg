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
     * @Route ("/inkoper/bestelopdrachten/", name="allebestelopdrachten")
     */
    public function alleBestelopdrachten(Request $request){

        $bestellingen = $this->getDoctrine()->getRepository("AppBundle:Bestelling")->findAll();

        //Verwijzing naar formulier
        return $this->render('inkoper/bestelregel.html.twig', [
            'bestellingen' => $bestellingen
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

            foreach ($nieuweBestelling->getBestelregels() as $bestelregel) {
                $bestelregel->setBestelling($nieuweBestelling);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($nieuweBestelling);
            $em->flush();
            return $this->redirect($this->generateurl("allebestelopdrachten"));
        }

        //Verwijzing naar formulier
        return $this->render('inkoper/form.bestelling.html.twig', [
            'form' => $form->createView(),
            'title' => 'Bestelling toevoegen',
        ]);
    }

    /**
     * @Route("/inkoper/bestelling/wijzigen/{bestelling}", name="bestellingwijzigen")
     */
    public function editBestelling (Request $request, $bestelling) {
        $bestaandeBestelling = $this->getDoctrine()->getRepository("AppBundle:Bestelling")->find($bestelling);
        $form = $this->createForm(BestellingType::class, $bestaandeBestelling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($bestaandeBestelling->getBestelregels() as $bestelregel) {
                $bestelregel->setBestelling($bestaandeBestelling);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($bestaandeBestelling);
            $em->flush();
            return $this->redirect($this->generateurl("allebestelopdrachten"));
        }

        //Verwijzing naar formulier
        return $this->render('inkoper/form.bestelling.html.twig', [
            'form' => $form->createView(),
            'title' => 'Bestelling wijzigen',
        ]);
    }
}
   