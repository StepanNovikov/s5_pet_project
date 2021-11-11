<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileManagerServiceInterface
{
    public function imagePostUpload(UploadedFile $file): string;
    public function removePostImage(string $fileName);
}