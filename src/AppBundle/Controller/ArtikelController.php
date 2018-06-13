<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Artikel;
use AppBundle\Form\Type\ArtikelType;
use AppBundle\Form\Type\ArtikelInkoperType;
use AppBundle\Form\Type\ArtikelMagazijnmeesterType;
use AppBundle\Form\Type\ArtikelVerkoperType;



class ArtikelController extends Controller
{

    //Functie om als inkoper een artikel te kunnen verwijderen.

    /**
     * @Route ("/inkoper/artikel/verwijder/{status}/{artikelnummer}", name="inkoperartikeluitvoorraad")
     */
    public function inkoperartikeluitvoorraad($status, $artikelnummer) {
        $bestaandeArtikel = $this->getDoctrine()->getRepository("AppBundle:Artikel")->find($artikelnummer);
        $bestaandeArtikel->setInVoorraad(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($bestaandeArtikel);
        $em->flush();

        return $this->redirectToRoute('inkoper', ['status' => $status]);
    }

    //Functie om als inkoper een artikel te kunnen terug te kunnen zetten.

    /**
     * @Route ("/inkoper/artikel/terugzetten/{status}/{artikelnummer}", name="inkoperartikelinvoorraad")
     */
    public function inkoperartikelinvoorraad($status, $artikelnummer) {
        $bestaandeArtikel = $this->getDoctrine()->getRepository("AppBundle:Artikel")->find($artikelnummer);
        $bestaandeArtikel->setInVoorraad(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($bestaandeArtikel);
        $em->flush();

        return $this->redirectToRoute('inkoper', ['status' => $status]);
    }

    //Functie om als magazijnmeester een artikel te kunnen verwijderen.

    /**
     * @Route ("/magazijnmeester/artikel/verwijder/{status}/{artikelnummer}", name="magazijnmeesterartikeluitvoorraad")
     */
    public function magazijnmeesterartikeluitvoorraad($status, $artikelnummer) {
        $bestaandeArtikel = $this->getDoctrine()->getRepository("AppBundle:Artikel")->find($artikelnummer);
        $bestaandeArtikel->setInVoorraad(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($bestaandeArtikel);
        $em->flush();

        return $this->redirectToRoute('magazijnmeester', ['status' => $status]);
    }



    //Functie om een nieuwe artikel te maken

    /** 
    * @Route ("/inkoper/artikel/nieuw ", name="artikelnieuw")
    */
    public function nieuweArtikel(Request $request){
        $nieuweArtikel = new Artikel();
        $form = $this->createForm(ArtikelType::class, $nieuweArtikel);
        $nieuweArtikel->setInVoorraad(1);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Functie om bestelserie te berekenen
            if ($nieuweArtikel->getMinimumvoorraad() > $nieuweArtikel->getVoorraadaantal()){
                $nieuweArtikel->setBestelserie($nieuweArtikel->getMinimumvoorraad() - $nieuweArtikel->getVoorraadaantal());
            } else{
                $nieuweArtikel->setBestelserie(0);
            }
            $em->persist($nieuweArtikel);
            $em->flush();
            //Verwijziging naar de pagina inkoper
            return $this->redirectToRoute('inkoper');
        }

        //Verwijzing naar formulier
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Artikel toevoegen',
        ]);
    }

    //Functie om een artikel te wijzigen door de inkoper

    /** 
    * @Route ("/inkoper/artikel/wijzigen/{artikelnummer} ", name="inkoperartikelwijzigen")
    */
    public function wijzigInkoperartikel(Request $request, $artikelnummer){
        $bestaandeArtikel = $this->getDoctrine()->getRepository("AppBundle:Artikel")->find($artikelnummer);
        $form = $this->createForm(ArtikelInkoperType::class, $bestaandeArtikel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Functie om bestelserie te berekenen
            if ($bestaandeArtikel->getMinimumvoorraad() > $bestaandeArtikel->getVoorraadaantal()){
                $bestaandeArtikel->setBestelserie($bestaandeArtikel->getMinimumvoorraad() - $bestaandeArtikel->getVoorraadaantal());
            } else{
                $bestaandeArtikel->setBestelserie(0);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($bestaandeArtikel);
            $em->flush();
            //Verwijziging naar de pagina inkoper
            return $this->redirectToRoute('inkoper');
        }

        //Verwijzing naar formulier
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Artikel wijzigen',
        ]);
    }

    //Functie om een artikel te wijzigen door de magazijnmeester

    /** 
    * @Route ("/magazijnmeester/artikel/wijzigen/{artikelnummer} ", name="magazijnmeesterartikelwijzigen")
    */
    public function wijzigMagazijnmeesterartikel(Request $request, $artikelnummer){
        $bestaandeArtikel = $this->getDoctrine()->getRepository("AppBundle:Artikel")->find($artikelnummer);
        $form = $this->createForm(ArtikelMagazijnmeesterType::class, $bestaandeArtikel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bestaandeArtikel);
            $em->flush();
            //Verwijzing naar de pagina magazijnmeester
            return $this->redirectToRoute('magazijnmeester');
        }

        //Verwijzing naar formulier
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Locatiecode wijzigen',
        ]);
    }


    //Functie om als verkoper een artikel te kunnen wijzigen.

    /** 
    * @Route ("/verkoper/artikel/wijzigen/{artikelnummer} ", name="verkoperartikelwijzigen")
    */
    public function wijzigVerkoperartikel(Request $request, $artikelnummer){
        $bestaandeArtikel = $this->getDoctrine()->getRepository("AppBundle:Artikel")->find($artikelnummer);
        $form = $this->createForm(ArtikelVerkoperType::class, $bestaandeArtikel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Functie om bestelserie te berekenen

            $em = $this->getDoctrine()->getManager();
            $em->persist($bestaandeArtikel);
            $em->flush();
            //Verwijzing naar de pagina verkoper
            return $this->redirectToRoute('verkoper');
        }

        //Verwijzing naar formulier
        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Verkopen wijzigen',
        ]);
    }
}