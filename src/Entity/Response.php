<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResponseRepository")
 */
class Response
{
    /**
     * @Groups({"forums", "forum", "topicsMore", "topic", "addResponse"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="50",
     *     minMessage = "Votre text doit contenir minimum {{ limit }} caractères",
     * )
     * @Groups({"topic", "addResponse"})
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @Groups({"topic", "addResponse"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Topic", inversedBy="responses")
     */
    private $topic;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="responses")
     */
    private $likes;

    /**
     * @Groups({"topic", "forum", "addResponse"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="responsesUsers")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $resolve;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->resolve = 0;
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getResolve(): ?bool
    {
        return $this->resolve;
    }

    public function setResolve(bool $resolve): self
    {
        $this->resolve = $resolve;

        return $this;
    }
}
