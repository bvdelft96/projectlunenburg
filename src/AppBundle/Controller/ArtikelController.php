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
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /** 
    * @Route ("/inkoper/artikel/nieuw ", name="artikelnieuw")
    */
    public function nieuweArtikel(Request $request){
        $nieuweArtikel = new Artikel();
        $form = $this->createForm(ArtikelType::class, $nieuweArtikel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $nieuweArtikel->bestelserie = $nieuweArtikel->minimumVoorraad - $nieuweArtikel->voorraadaantal;
            $em->persist($nieuweArtikel);
            $em->flush();
            return $this->redirect($this->generateurl("artikelnieuw"));
        }

        return new Response($this->render('form.html.twig', array('form' => $form->createView())));
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

        return new Response($this->render('form.html.twig', array('form' => $form->createView())));
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

        return new Response($this->render('form.html.twig', array('form' => $form->createView())));
    }


    /** 
    * @Route ("/inkoper/artikel/alle", name="inkoperalleartikelen")
    */
    public function alleInkoperartikelen(Request $request){
        $artikelen = $this->getDoctrine()->getRepository("AppBundle:Artikel")->findAll();
        
        return new Response($this->render('artikelinkoper.html.twig', array('artikelen' => $artikelen)));

    }
}