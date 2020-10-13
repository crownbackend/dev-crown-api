<?php

namespace App\Controller;

use App\Entity\Image;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class ImageController
 * @package App\Controller
 */
class ImageController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ImageRepository
     */
    private $imageRepository;
    /**
     * @var FileUploader
     */
    private $fileUploader;

    public function __construct(UserRepository $userRepository, ImageRepository $imageRepository,
                                FileUploader $fileUploader)
    {
        $this->userRepository = $userRepository;
        $this->imageRepository = $imageRepository;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Route("/images/upload", name="upload_images", methods={"POST"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function uploadImages(Request $request, JWTEncoderInterface $JWTEncoder): JsonResponse
    {
        $errorSizeFile = [];
        if($request->headers->get("authorization")) {
            $tokenValid = $JWTEncoder->decode($request->headers->get('authorization'));
            if($tokenValid) {
                if(count($request->files->get('files')) > 5) {
                    return $this->json(["errorCountFile" => 1], 400);
                } else {
                    $em = $this->getDoctrine()->getManager();
                    $user = $this->userRepository->findOneBy(["id" => $request->request->get('id')]);
                    foreach ($request->files->get("files") as $file) {
                        if($file->getSize() > 5000000) {
                            array_push($errorSizeFile, $file->getClientOriginalName());
                        } else {
                            $image = new Image();
                            $imageFileName = $this->fileUploader->upload($file, null, "topic_directory");
                            $image->setName($imageFileName);
                            $image->setUser($user);
                            $em->persist($image);
                        }
                    }
                    $em->flush();
                    return $this->json(["success" => 1, "imagesNotUpload" => $errorSizeFile,
                        "images" => $this->imageRepository->findBy(["user" => $user])],
                        200, [], ["groups" => "images"]);
                }
            }
        } else {
            return $this->json(["token" => 0], 400);
        }
    }

    /**
     * @Route("/images/{id}", name="images", methods={"GET"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param $id
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function images(Request $request, JWTEncoderInterface $JWTEncoder, $id): JsonResponse
    {
        if($request->headers->get("authorization")) {
            $tokenValid = $JWTEncoder->decode($request->headers->get('authorization'));
            if($tokenValid) {
                $user = $this->userRepository->findOneBy(["id" => $id]);
                return $this->json(["images" => $this->imageRepository->findBy(["user" => $user])],
                    200, [], ["groups" => "images"]);
            }
        } else {
            return $this->json(["token" => 0], 400);
        }
    }

    /**
     * @Route("/image/{id}/{userId}", name="delete_image", methods={"DELETE"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param $id
     * @param $userId
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function deleteImage(Request $request, JWTEncoderInterface $JWTEncoder, $id, $userId): JsonResponse
    {
        if($request->headers->get("authorization")) {
            $tokenValid = $JWTEncoder->decode($request->headers->get('authorization'));
            if($tokenValid) {
                $em = $this->getDoctrine()->getManager();
                $image = $this->imageRepository->findOneBy(["id" => $id]);
                $this->fileUploader->deleteFile($image->getName(), "topic_directory");
                $em->remove($image);
                $em->flush();
                $user = $this->userRepository->findOneBy(["id" => $userId]);
                return $this->json(["images" => $this->imageRepository->findBy(["user" => $user])],
                    200, [], ["groups" => "images"]);
            }
        } else {
            return $this->json(["token" => 0], 400);
        }
    }
}