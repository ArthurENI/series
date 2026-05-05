<?php

namespace App\Utils;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    public function upload(UploadedFile $file,string $directory,$namePrefix=''): string
    {
        $newFileName = ($namePrefix? $namePrefix.'-':'').uniqid().'.'.$file->guessExtension();
//       ou     $file->move($this->getParameter('serie_poster_dir'), $newFileName);
        $file->move($directory, $newFileName);
        return $newFileName;
    }

    public function delete(string $filename , string $directory): void
    {
        unlink($directory.DIRECTORY_SEPARATOR.$filename);
    }

    public function update(string $oldfilename,string $directory,UploadedFile $file,$namePrefix=''): string
    {
        $this->delete($oldfilename,$directory);
        return $this->upload($file,$directory,$namePrefix);
    }

}
