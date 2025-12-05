<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/img/home', name: 'app_img_home')]
    public function home(): Response
    {
        return $this->render('img/home.html.twig', [
            'title' => 'Site Image',
        ]);
    }

    public function menu(): Response
    {
        return $this->render('img/_imageList.html.twig', [
            'images' => $this->getImages(),
        ]);
    }

    #[Route('/image/download/{filename}', name: 'app_image_download')]
    public function downloadImage(string $filename): BinaryFileResponse
    {
        $imagePath = $this->kernel->getProjectDir() . '/public/images/' . $filename;

        return $this->file($imagePath);
    }

    private function getImages(): array
    {
        $imagesDir = $this->kernel->getProjectDir() . '/public/images';
        $files = scandir($imagesDir);

        $images = [];
        foreach ($files as $file) {
            if (!is_dir($imagesDir . '/' . $file)) {
                $images[] = $file;
            }
        }
        return $images;
    }
}
