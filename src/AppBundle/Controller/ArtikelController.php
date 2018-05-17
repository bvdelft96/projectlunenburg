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



class ArtikelController extends Controller
{

    //Functie om een nieuwe artikel te maken

    /** 
    * @Route ("/inkoper/artikel/nieuw ", name="artikelnieuw")
    */
    public function nieuweArtikel(Request $request){
        $nieuweArtikel = new Artikel();
        $form = $this->createForm(ArtikelType::class, $nieuweArtikel);

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

    //Functie om naar de homepagina van de inkoper te gaan.

    /**
     * @Route ("/inkoper", name="inkoper")
     */
    public function inkoperHomepage(Request $request){
        $artikelen = $this->getDoctrine()->getRepository("AppBundle:Artikel")->findAll();

        //Verwijzing naar formulier
        return $this->render('inkoper/index.html.twig', [
            'artikelen' => $artikelen
        ]);

    }

    //Functie om naar de homepagina van de magazijnmeester te gaan.

    /**
     * @Route ("/magazijnmeester", name="magazijnmeester")
     */
    public function magazijnmeesterHomepage(Request $request){
        $artikelen = $this->getDoctrine()->getRepository("AppBundle:Artikel")->findAll();

        //Verwijzing naar formulier
        return $this->render('magazijnmeester/index.html.twig', [
            'artikelen' => $artikelen
        ]);

    }
}