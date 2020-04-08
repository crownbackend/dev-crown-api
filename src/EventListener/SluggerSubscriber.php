<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Entity\Playliste;
use App\Entity\Technology;
use App\Entity\Video;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;

class SluggerSubscriber implements EventSubscriber
{

    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [
            Events::preUpdate,
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->sluggerVideo('persist', $args);
        $this->sluggerArticle('persist', $args);
        $this->sluggerTechnology('persist', $args);
        $this->sluggerPlaylist('persist', $args);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->sluggerVideo('update', $args);
        $this->sluggerArticle('update', $args);
        $this->sluggerTechnology('update', $args);
        $this->sluggerPlaylist('update', $args);
    }

    public function sluggerVideo(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Video) {
            return;
        }
        $slug = $this->slugify($entity->getTitle());
        $entity->setSlug($slug);
    }

    public function sluggerArticle(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Article) {
            return;
        }
        $slug = $this->slugify($entity->getTitle());
        $entity->setSlug($slug);
    }

    public function sluggerPlaylist(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Playliste) {
            return;
        }
        $slug = $this->slugify($entity->getName());
        $entity->setSlug($slug);
    }

    public function sluggerTechnology(string $action, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if(!$entity instanceof Technology) {
            return;
        }
        $slug = $this->slugify($entity->getName());
        $entity->setSlug($slug);
    }

    private function slugify(string $text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}