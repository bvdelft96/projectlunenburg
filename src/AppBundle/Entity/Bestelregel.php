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
     * @ORM\ManyToOne(targetEntity="Artikel", inversedBy="bestelregels")
     * @ORM\JoinColumn(name="artikelnummer", referencedColumnName="artikelnummer")
     */
    private $artikel;

    /**
     * @ORM\ManyToOne(targetEntity="Bestelling", inversedBy="bestelregels")
     * @ORM\JoinColumn(name="bestelordernummer", referencedColumnName="bestelordernummer")
     */
    private $bestelling;

    /**
     * @ORM\Column(name="aantal", type="integer")
     */
    private $aantal;

    /**
     * @return mixed
     */
    public function getArtikel()
    {
        return $this->artikel;
    }

    /**
     * @param mixed $artikel
     */
    public function setArtikel($artikel)
    {
        $this->artikel = $artikel;
    }

    /**
     * @return mixed
     */
    public function getBestelling()
    {
        return $this->bestelling;
    }

    /**
     * @param mixed $bestelling
     */
    public function setBestelling($bestelling)
    {
        $this->bestelling = $bestelling;
    }

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
     * @return mixed
     */
    public function getAantal()
    {
        return $this->aantal;
    }

    /**
     * @param mixed $aantal
     */
    public function setAantal($aantal)
    {
        $this->aantal = $aantal;
    }

}

