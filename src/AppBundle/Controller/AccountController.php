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
     * @Route ("/inkoper/{status}", defaults={"status"=1}, name="inkoper")
     *
     * @param $status 0 = alle, 1 = in voorraad, 2 = uit voorraad
     * @return Response
     */
    public function inkoperHomepage(Request $request, $status){

        $search = $request->get('q');
        $em = $this->getDoctrine()->getManager();

        if($status != 0) {
            if ($search) {
                $artikelen = $em->createQuery('Select a FROM AppBundle:Artikel a WHERE a.inVoorraad = :status AND (a.artikelnummer LIKE :query OR a.omschrijving LIKE :query)')
                    ->setParameter('query', '%'.$search.'%')
                    ->setParameter('status', $status == 1);
            } else {
                $artikelen = $em->createQuery('Select a FROM AppBundle:Artikel a WHERE a.inVoorraad = :status')
                    ->setParameter('status', $status == 1);
            }
        } else {
            if ($search) {
                $artikelen = $em->createQuery('Select a FROM AppBundle:Artikel a WHERE a.artikelnummer LIKE :query OR a.omschrijving LIKE :query')
                    ->setParameter('query', '%'.$search.'%');
            } else {
                $artikelen = $em->createQuery('Select a FROM AppBundle:Artikel a');
            }
        }

        //Verwijzing naar formulier
        return $this->render('inkoper/index.html.twig', [
            'artikelen' => $artikelen->getResult(),
            'status' => $status,
            'q' => $search
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
                $artikel->setGereserveerdevoorraad($artikel->getVoorraadaantal());
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