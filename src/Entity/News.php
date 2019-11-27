<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
  * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="App\Repository\NewsRepository")
 */
class News implements \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(name="publication_date", type="datetime")
     */
    private $publicationDate;

    /**
     * @ORM\Column(name="last_edit_date", type="datetime", nullable=true)
     */
    private $lastEditDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id_user")
     */
    private $author;

    /**
     * @ORM\Column(name="archived", type="boolean")
     */
    private $archived = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getLastEditDate(): ?\DateTimeInterface
    {
        return $this->lastEditDate;
    }

    public function setLastEditDate(?\DateTimeInterface $lastEditDate): self
    {
        $this->lastEditDate = $lastEditDate;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    /**
     * @return mixed|string
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->title,
            $this->description,
            $this->publicationDate,
            $this->lastEditDate,
            $this->author,
            $this->archived
        ));
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->title,
            $this->description,
            $this->publicationDate,
            $this->lastEditDate,
            $this->author,
            $this->archived,
            ) = unserialize($serialized, array('allowed_classes' => true));
    }
}
