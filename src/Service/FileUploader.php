<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class FileUploader extends AbstractController {

    /**
     * @param UploadedFile $file
     * @param null $entity
     * @param string $directory
     * @param null $edit
     * @return string
     */
    public function upload(UploadedFile $file, $entity = null, string $directory = 'image_directory', $edit = null)
    {
        // check file exist and delete on edit
        if($entity and $edit == 1) {
            if(file_exists($this->getParameter("$directory").'/'.$entity)) {
                unlink($this->getParameter("$directory").'/'.$entity);
            }
        }
        // upload file
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
        try {
            $file->move($this->getParameter("$directory"), $fileName);
        } catch (FileException $e) {
            new Response('Problème de téléchargement');
        }
        return $fileName;
    }

    /**
     * @param $entity
     * @param string $directory
     * @return RedirectResponse
     */
    public function deleteFile($entity, string $directory = 'image_directory')
    {
        if($entity) {
            if(file_exists($this->getParameter("$directory").'/'.$entity)) {
                unlink($this->getParameter("$directory").'/'.$entity);
            }
        } else {
            return $this->redirectToRoute('admin_images_index');
        }
    }
}