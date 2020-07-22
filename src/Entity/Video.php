<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    const IDX_TYPE_VIDEO = [
        1 => "video/ogg",
        2 => "video/mp4"
    ];
    /**
     * @Groups({"videos", "lastVideos", "video", "technology", "playlist"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"videos", "lastVideos", "video", "technology", "playlist"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @Groups({"videos", "lastVideos", "video", "technology", "playlist"})
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Groups({"videos", "video"})
     * @ORM\Column(type="text")
     */
    private $videoURL;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups({"videos", "lastVideos", "video", "technology", "playlist"})
     * @ORM\Column(type="datetime")
     */
    private $publishedAt;

    /**
     * @Groups({"videos", "lastVideos", "technology", "playlist"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @Groups({"videos", "lastVideos", "video", "technology", "playlist"})
     * @ORM\Column(type="string")
     */
    private $imageFile;

    /**
     * @Groups({"videos", "video"})
     * @ORM\Column(type="string", length=255)
     */
    private $nameFileVideo;

    /**
     * @Groups({"video"})
     * @ORM\Column(type="integer")
     */
    private $typeVideo;

    /**
     * @Groups({"videos", "video"})
     * @ORM\OneToMany(targetEntity="App\Entity\CommentVideo", mappedBy="video")
     */
    private $comments;

    /**
     * @Groups({"videos", "lastVideos", "video", "technology", "playlist"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Technology", inversedBy="videos")
     * @ORM\JoinColumn(name="technology_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $technology;

    /**
     * @Groups({"videos", "lastVideos", "video", "technology"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Playliste", inversedBy="videos")
     * @ORM\JoinColumn(name="playliste_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $playliste;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="videos")
     */
    private $users;

    /**
     * user is favored
     * @var
     * @Groups({"videos", "technology", "playlist"})
     */
    public $favored;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getVideoURL(): ?string
    {
        return $this->videoURL;
    }

    public function setVideoURL(string $videoURL): self
    {
        $this->videoURL = $videoURL;

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

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

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

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getNameFileVideo(): ?string
    {
        return $this->nameFileVideo;
    }

    public function setNameFileVideo(string $nameFileVideo): self
    {
        $this->nameFileVideo = $nameFileVideo;

        return $this;
    }

    public function getTypeVideo(): ?int
    {
        return $this->typeVideo;
    }

    public function setTypeVideo(int $typeVideo): self
    {
        $this->typeVideo = $typeVideo;

        return $this;
    }

    /**
     * @return Collection|CommentVideo[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(CommentVideo $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setVideo($this);
        }

        return $this;
    }

    public function removeComment(CommentVideo $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getVideo() === $this) {
                $comment->setVideo(null);
            }
        }

        return $this;
    }

    public function getTechnology(): ?Technology
    {
        return $this->technology;
    }

    public function setTechnology(?Technology $technology): self
    {
        $this->technology = $technology;

        return $this;
    }

    public function getPlayliste(): ?Playliste
    {
        return $this->playliste;
    }

    public function setPlayliste(?Playliste $playliste): self
    {
        $this->playliste = $playliste;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }
}
