<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Bestelling
 *
 * @ORM\Table(name="bestelling")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BestellingRepository")
 */
class Bestelling
{

    /**
     * @var int
     *
     * @ORM\Column(name="bestelordernummer", type="integer", unique=true)
     * @ORM\Id
     */
    private $bestelordernummer;

    /**
     * @var string
     *
     * @ORM\Column(name="leverancier", type="string", length=6, nullable=true)
     */
    private $leverancier;

    /**
     * @var int
     *
     * @ORM\Column(name="keuringseisen", type="integer", length=4, nullable=true)
     */
    private $keuringseisen;

    /**
     * @ORM\OneToMany(targetEntity="Bestelregel", mappedBy="bestelling", cascade={"persist"})
     */
    private $bestelregels;

    public function __construct()
    {
        $this->bestelregels = new ArrayCollection();
    }

    /**
     * @param mixed $bestelregels
     */
    public function setBestelregels($bestelregels)
    {
        $this->bestelregels = $bestelregels;
    }

    /**
     * @return mixed
     */
    public function getBestelregels()
    {
        return $this->bestelregels;
    }

    /**
     * Set bestelordernummer
     *
     * @param integer $bestelordernummer
     *
     * @return Bestelling
     */
    public function setBestelordernummer($bestelordernummer)
    {
        $this->bestelordernummer = $bestelordernummer;
    
        return $this;
    }

    /**
     * Get bestelordernummer
     *
     * @return integer
     */
    public function getBestelordernummer()
    {
        return $this->bestelordernummer;
    }

    /**
     * Set leverancier
     *
     * @param string $leverancier
     *
     * @return Bestelling
     */
    public function setLeverancier($leverancier)
    {
        $this->leverancier = $leverancier;
    
        return $this;
    }

    /**
     * Get leverancier
     *
     * @return string
     */
    public function getLeverancier()
    {
        return $this->leverancier;
    }


    /**
     * Set keuringseisen
     *
     * @param integer $keuringseisen
     *
     * @return Bestelling
     */
    public function setKeuringseisen($keuringseisen)
    {
        $this->keuringseisen = $keuringseisen;
    
        return $this;
    }

    /**
     * Get keuringseisen
     *
     * @return integer
     */
    public function getKeuringseisen()
    {
        return $this->keuringseisen;
    }
}

