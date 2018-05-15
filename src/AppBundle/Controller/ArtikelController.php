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

    /** 
    * @Route ("/inkoper/artikel/nieuw ", name="artikelnieuw")
    */
    public function nieuweArtikel(Request $request){
        $nieuweArtikel = new Artikel();
        $form = $this->createForm(ArtikelType::class, $nieuweArtikel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $nieuweArtikel->setBestelserie($nieuweArtikel->getMinimumvoorraad() - $nieuweArtikel->getVoorraadaantal());
            $em->persist($nieuweArtikel);
            $em->flush();
            return $this->redirect($this->generateurl("artikelnieuw"));
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Artikel toevoegen',
        ]);
    }

    /** 
    * @Route ("/inkoper/artikel/wijzigen/{artikelnummer} ", name="inkoperartikelwijzigen")
    */
    public function wijzigInkoperartikel(Request $request, $artikelnummer){
        $bestaandeArtikel = $this->getDoctrine()->getRepository("AppBundle:Artikel")->find($artikelnummer);
        $form = $this->createForm(ArtikelInkoperType::class, $bestaandeArtikel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($bestaandeArtikel);
            $em->flush();
            return $this->redirect($this->generateurl("inkoperartikelwijzigen", array("artikelnummer" => $bestaandeArtikel->getArtikelnummer())));
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Artikel wijzigen',
        ]);
    }

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
            return $this->redirect($this->generateurl("magazijnmeesterartikelwijzigen", array("artikelnummer" => $bestaandeArtikel->getArtikelnummer())));
        }

        return $this->render('form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Artikel wijzigen',
        ]);
    }

    /**
     * @Route ("/inkoper", name="inkoper")
     */
    public function inkoperHomepage(Request $request){
        $artikelen = $this->getDoctrine()->getRepository("AppBundle:Artikel")->findAll();

        return $this->render('inkoper/index.html.twig', [
            'artikelen' => $artikelen
        ]);

    }

    /**
     * @Route ("/magazijnmeester", name="magazijnmeester")
     */
    public function magazijnmeesterHomepage(Request $request){
        $artikelen = $this->getDoctrine()->getRepository("AppBundle:Artikel")->findAll();

        return $this->render('magazijnmeester/index.html.twig', [
            'artikelen' => $artikelen
        ]);

    }
}