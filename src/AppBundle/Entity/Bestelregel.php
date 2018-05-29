<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bestelregel
 *
 * @ORM\Table(name="bestelregel")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BestelregelRepository")
 */
class Bestelregel
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Artikel", inversedBy="bestelregels")
     * @ORM\JoinColumn(name="artikelnummer", referencedColumnName="artikelnummer")
     */
    private $artikelnummer;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Artikel", inversedBy="bestelregels")
     * @ORM\JoinColumn(name="bestelordernummer", referencedColumnName="bestelordernummer")
     */
    private $bestelordernummer;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Bestelregel
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set artikelnummer
     *
     * @param integer $artikelnummer
     *
     * @return Bestelregel
     */
    public function setArtikelnummer($artikelnummer)
    {
        $this->artikelnummer = $artikelnummer;
    
        return $this;
    }

    /**
     * Get artikelnummer
     *
     * @return integer
     */
    public function getArtikelnummer()
    {
        return $this->artikelnummer;
    }

    /**
     * Set bestelordernummer
     *
     * @param integer $bestelordernummer
     *
     * @return Bestelregel
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
}

