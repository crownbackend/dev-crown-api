<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @Groups({"video", "commentArticle"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"user", "video", "commentArticle"})
     * @Assert\NotBlank(groups={"user"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Groups("user")
     * @Assert\NotBlank(groups={"user"})
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups("user")
     * @Assert\NotBlank(groups={"user"})
     * @Assert\Email(groups={"user"})
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $confirmationToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tokenPassword;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $confirmationTokenCreatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $tokenPasswordCreatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentVideo", mappedBy="user")
     */
    private $commentsVideo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommentArticle", mappedBy="user")
     */
    private $commentsArticle;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Topic", mappedBy="likes")
     */
    private $topics;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Response", mappedBy="likes")
     */
    private $responses;

    public function __construct()
    {
        $this->enabled = 0;
        $this->createdAt = new \DateTime();
        $this->roles = ["ROLE_USER"];
        $this->commentsVideo = new ArrayCollection();
        $this->commentsArticle = new ArrayCollection();
        $this->topics = new ArrayCollection();
        $this->responses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): self
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }

    public function getTokenPassword(): ?string
    {
        return $this->tokenPassword;
    }

    public function setTokenPassword(?string $tokenPassword): self
    {
        $this->tokenPassword = $tokenPassword;

        return $this;
    }

    public function getConfirmationTokenCreatedAt(): ?\DateTimeInterface
    {
        return $this->confirmationTokenCreatedAt;
    }

    public function setConfirmationTokenCreatedAt(?\DateTimeInterface $confirmationTokenCreatedAt): self
    {
        $this->confirmationTokenCreatedAt = $confirmationTokenCreatedAt;

        return $this;
    }

    public function getTokenPasswordCreatedAt(): ?\DateTimeInterface
    {
        return $this->tokenPasswordCreatedAt;
    }

    public function setTokenPasswordCreatedAt(?\DateTimeInterface $tokenPasswordCreatedAt): self
    {
        $this->tokenPasswordCreatedAt = $tokenPasswordCreatedAt;

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

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|CommentVideo[]
     */
    public function getCommentsVideo(): Collection
    {
        return $this->commentsVideo;
    }

    public function addCommentsVideo(CommentVideo $commentsVideo): self
    {
        if (!$this->commentsVideo->contains($commentsVideo)) {
            $this->commentsVideo[] = $commentsVideo;
            $commentsVideo->setUser($this);
        }

        return $this;
    }

    public function removeCommentsVideo(CommentVideo $commentsVideo): self
    {
        if ($this->commentsVideo->contains($commentsVideo)) {
            $this->commentsVideo->removeElement($commentsVideo);
            // set the owning side to null (unless already changed)
            if ($commentsVideo->getUser() === $this) {
                $commentsVideo->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CommentArticle[]
     */
    public function getCommentsArticle(): Collection
    {
        return $this->commentsArticle;
    }

    public function addCommentsArticle(CommentArticle $commentsArticle): self
    {
        if (!$this->commentsArticle->contains($commentsArticle)) {
            $this->commentsArticle[] = $commentsArticle;
            $commentsArticle->setUser($this);
        }

        return $this;
    }

    public function removeCommentsArticle(CommentArticle $commentsArticle): self
    {
        if ($this->commentsArticle->contains($commentsArticle)) {
            $this->commentsArticle->removeElement($commentsArticle);
            // set the owning side to null (unless already changed)
            if ($commentsArticle->getUser() === $this) {
                $commentsArticle->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->addLike($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            $topic->removeLike($this);
        }

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
            $response->addLike($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            $response->removeLike($this);
        }

        return $this;
    }
}
