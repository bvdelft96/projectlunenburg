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



class AccountController extends Controller
{

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


        foreach($artikelen as $artikel){
            if ($artikel->getVerkopen() == null){
                $artikel->setGereserveerdevoorraad(0);
                $artikel->setVrijevoorraad($artikel->getVoorraadaantal());
            } else{
                $artikel->setGereserveerdevoorraad($artikel->getVerkopen());
                $artikel->setVrijevoorraad($artikel->getVoorraadaantal() - $artikel->getGereserveerdevoorraad());
            }
        }

        //Verwijzing naar formulier
        return $this->render('magazijnmeester/index.html.twig', [
            'artikelen' => $artikelen
        ]);

    }

    //Functie om naar de homepagina van de magazijnmeester te gaan.

    /**
     * @Route ("/verkoper", name="verkoper")
     */
    public function verkoperHomepage(Request $request){
        $artikelen = $this->getDoctrine()->getRepository("AppBundle:Artikel")->findAll();

        //Verwijzing naar formulier
        return $this->render('verkoper/index.html.twig', [
            'artikelen' => $artikelen
        ]);

    }
}