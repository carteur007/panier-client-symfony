<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDirectory;
    private $logger;

    public function __construct($targetDirectory, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            $this->getLogger()->info("Erreur durant l\'upload de fichier | ".$e->getMessage());
        }

        return $fileName;
    }

    public function getLogger()
    {
        return $this->logger;
    }
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
