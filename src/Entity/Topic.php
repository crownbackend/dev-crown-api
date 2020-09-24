<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic
{
    /**
     * @Groups({"lastTopics", "search", "forums", "forum", "topicsMore", "topic", "editTopic"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="5",
     *     max="255"
     * )
     * @Groups({"lastTopics", "search", "forums", "forum", "topicsMore", "topic"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="50",
     *     minMessage = "Votre text doit contenir minomum {{ limit }} caractères",
     * )
     * @Groups({"topic"})
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Groups({"forum", "topicsMore", "topic"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups({"forum", "topicsMore", "topic"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @Groups({"lastTopics", "search", "forum", "topicsMore", "topic"})
     * @ORM\Column(type="boolean")
     */
    private $resolve;

    /**
     * @Groups({"forum", "topicsMore", "topic"})
     * @ORM\Column(type="boolean")
     */
    private $close;

    /**
     * @Groups({"lastTopics", "search", "topic"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Forum", inversedBy="topics")
     */
    private $forum;

    /**
     * @Groups({"forums", "forum", "topicsMore", "topic"})
     * @ORM\OneToMany(targetEntity="App\Entity\Response", mappedBy="topic")
     */
    private $responses;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="topics")
     */
    private $likes;

    /**
     * @Groups({"forums", "forum", "topicsMore", "topic"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @Groups({"topic"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="topicsUsers")
     */
    private $user;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->close = 0;
        $this->resolve = 0;
        $this->responses = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getClose(): ?bool
    {
        return $this->close;
    }

    public function setClose(bool $close): self
    {
        $this->close = $close;

        return $this;
    }

    public function getForum(): ?Forum
    {
        return $this->forum;
    }

    public function setForum(?Forum $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * @return Collection|Response[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setTopic($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getTopic() === $this) {
                $response->setTopic(null);
            }
        }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
}
