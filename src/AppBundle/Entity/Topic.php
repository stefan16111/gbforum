<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Topic
 *
 * @ORM\Table(name="topic")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 */
class Topic
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true, referencedColumnName="id")
     */
    private $poster;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category", inversedBy="topics")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
     */
    private $category;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Thread", mappedBy="topic")
     */
    private $threads;

    public function __construct() {
        $this->setDate(date_create(date("Y-m-d H:i:s")));
        $this->threads = new ArrayCollection();       
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Post
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Post
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set poster
     *
     * @param string $poster
     *
     * @return Post
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Topic
     */
    public function setCategory(\AppBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add thread
     *
     * @param \AppBundle\Entity\Thread $thread
     *
     * @return Topic
     */
    public function addThread(\AppBundle\Entity\Thread $thread)
    {
        $this->threads[] = $thread;

        return $this;
    }

    /**
     * Remove thread
     *
     * @param \AppBundle\Entity\Thread $thread
     */
    public function removeThread(\AppBundle\Entity\Thread $thread)
    {
        $this->threads->removeElement($thread);
    }

    /**
     * Get threads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getThreads()
    {
        return $this->threads;
    }
}
