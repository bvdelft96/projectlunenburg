<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Artikel
 *
 * @ORM\Table(name="artikel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArtikelRepository")
 */
class Artikel
{

    //Mapping naar de database

     /**
     * @var string
     *
     * @ORM\Column(name="artikelnummer", type="integer", length=20, unique=true)
     * @ORM\Id
     * @Assert\Length(
     *      min = 10,
     *      max = 10,
     *      minMessage = "Minimaal 10 karakters",
     *      maxMessage = "Maximaal 10 karakters"
     *)
     */
    private $artikelnummer;

    /**
     * @var string
     *
     * @ORM\Column(name="omschrijving", type="string", length=255, nullable=true)
     */
    private $omschrijving;

    /**
     * @var string
     *
     * @ORM\Column(name="specificaties", type="string", length=255, nullable=true)
     */
    private $specificaties;

    /**
     * @var string
     *
     * @ORM\Column(name="Magazijnlocatie", type="string", length=6)
         * @Assert\Regex(
         *    pattern = "/^20|[0-1]{1}[0-9]{1}\/[A-Z][0]{1}[0-9]{1}|10$/i",
         *    match=true,
         *    message="Ongeldige locatie [ERROR1]")
         * @Assert\Regex(
         *    pattern = "/^[2]{1}[1-9]{1}\/[A-Z]{1}[0-9]{1}$/i",
         *    match=false,
         *    message="Ongeldige locatie [ERROR2]")
         * @Assert\Regex(
         *    pattern = "/^[3-9]{1}[0-9]{1}\/[A-Z][0-9]{1}$/i",
         *    match=false,
         *    message="Ongeldige locatie [ERROR3]")
         * @Assert\Regex(
         *    pattern = "/^[0-1]{1}[0-9]{1}\/[A-Z][1]{1}[1-9]{1}$/i",
         *    match=false,
         *    message="Ongeldige locatie [ERROR4]")
         * @Assert\Regex(
         *    pattern = "/^[0-1]{1}[0-9]{1}\/[A-Z][2-9]{1}[0-9]{1}$/i",
         *    match=false,
         *    message="Ongeldige locatie [ERROR5]")
         * @Assert\Regex(
         *    pattern = "/^[0-9A-Za-z]+$/i",
         *    match=false,
         *    message="Ongeldige locatie [ERROR6]")
         * @Assert\Length(
         *      max = 6,
         *      maxMessage = "Mag niet meer zijn dan {{ limit }} karakters"
         * )
         */
    private $magazijnlocatie;

    /**
     * @var decimal
     *
     * assert
     * @ORM\Column@Column(type="decimal", precision= 10, scale=2, nullable=true)
     */
    private $inkoopprijs;

    /**
     * @var string
     *
     * @ORM\Column(name="vervangendeArtikel", type="string", length=255, nullable=true)
     */

    private $vervangendeArtikel;

    /**
     * @var integer
     *
     * @ORM\Column(name="minimumVoorraad", type="integer", length=20, nullable=true)
     */
    private $minimumVoorraad;

    /**
     * @var integer
     *
     * @ORM\Column(name="voorraadaantal", type="integer", length=20, nullable=true)
     */
    private $voorraadaantal;

    /**
     * @var integer
     *
     * @ORM\Column(name="bestelserie", type="integer", length=20, nullable=true)
     */
    private $bestelserie;

    //**************************************************Set/Get Functies hieronder!*********************************


    /**
     * Set artikelnummer
     *
     * @param string $artikelnummer
     *
     * @return Artikel
     */
    public function setArtikelnummer($artikelnummer)
    {
        $this->artikelnummer = $artikelnummer;

        return $this;
    }

    /**
     * Get artikelnummer
     *
     * @return string
     */
    public function getArtikelnummer()
    {
        return $this->artikelnummer;
    }

    /**
     * Set omschrijving
     *
     * @param string $omschrijving
     *
     * @return Artikel
     */
    public function setOmschrijving($omschrijving)
    {
        $this->omschrijving = $omschrijving;

        return $this;
    }

    /**
     * Get omschrijving
     *
     * @return string
     */
    public function getOmschrijving()
    {
        return $this->omschrijving;
    }

    /**
     * Set specificaties
     *
     * @param string $specificaties
     *
     * @return Artikel
     */
    public function setSpecificaties($specificaties)
    {
        $this->specificaties = $specificaties;

        return $this;
    }

    /**
     * Get specificaties
     *
     * @return string
     */
    public function getSpecificaties()
    {
        return $this->specificaties;
    }

    /**
     * Set magazijnlocatie
     *
     * @param string $magazijnlocatie
     *
     * @return Artikel
     */
    public function setMagazijnlocatie($magazijnlocatie)
    {
        $this->magazijnlocatie = $magazijnlocatie;

        return $this;
    }

    /**
     * Get magazijnlocatie
     *
     * @return string
     */
    public function getMagazijnlocatie()
    {
        return $this->magazijnlocatie;
    }

    /**
     * Set inkoopprijs
     *
     * @param decimal $inkoopprijs
     *
     * @return Artikel
     */
    public function setInkoopprijs($inkoopprijs)
    {
        $this->inkoopprijs = $inkoopprijs;

        return $this;
    }

    /**
     * Get inkoopprijs
     *
     * @return decimal
     */
    public function getInkoopprijs()
    {
        return $this->inkoopprijs;
    }

    /**
     * Set vervangendeArtikel
     *
     * @param string $vervangendeArtikel
     *
     * @return Artikel
     */
    public function setVervangendeartikel($vervangendeArtikel)
    {
        $this->vervangendeArtikel = $vervangendeArtikel;

        return $this;
    }

    /**
     * Get vervangendeArtikel
     *
     * @return string
     */
    public function getVervangendeartikel()
    {
        return $this->vervangendeArtikel;
    }

     /**
     * Set minimumVoorraad
     *
     * @param integer $minimumVoorraad
     *
     * @return Artikel
     */
    public function setMinimumvoorraad($minimumVoorraad)
    {
        $this->minimumVoorraad = $minimumVoorraad;

        return $this;
    }

    /**
     * Get minimumVoorraad
     *
     * @return integer
     */
    public function getMinimumvoorraad()
    {
        return $this->minimumVoorraad;
    }

     /**
     * Set voorraadaantal
     *
     * @param integer $voorraadaantal
     *
     * @return Artikel
     */
    public function setVoorraadaantal($voorraadaantal)
    {
        $this->voorraadaantal = $voorraadaantal;

        return $this;
    }

    /**
     * Get voorraadaantal
     *
     * @return integer
     */
    public function getVoorraadaantal()
    {
        return $this->voorraadaantal;
    }

     /**
     * Set bestelserie
     *
     * @param integer $bestelserie
     *
     * @return Artikel
     */
    public function setBestelserie($bestelserie)
    {
       $this->bestelserie = $bestelserie;
    }

    /**
     * Get bestelserie
     *
     * @return integer
     */
    public function getBestelserie()
    {
        return $this->bestelserie;
    }
}


