<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class InvoiceUploader
 */
class InvoiceUploader
{
    private $invoiceDirectory;

    /**
     * InvoiceUploader constructor.
     *
     * @param $invoiceDirectory
     */
    public function __construct($invoiceDirectory)
    {
        $this->invoiceDirectory = $invoiceDirectory;
    }

    /**
     * @param UploadedFile $file
     *
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->getInvoiceDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    /**
     * @return mixed
     */
    public function getInvoiceDirectory()
    {
        return $this->invoiceDirectory;
    }
}