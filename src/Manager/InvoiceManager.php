<?php

namespace App\Manager;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class InvoiceManager
 */
class InvoiceManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * InvoiceManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param InvoiceRepository      $invoiceRepository
     * @param LoggerInterface        $logger
     */
    public function __construct(InvoiceRepository $invoiceRepository, LoggerInterface $logger, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->invoiceRepository = $invoiceRepository;
        $this->logger = $logger;
    }

    /**
     * @return Invoice
     */
    public function createInvoice(): Invoice
    {
        $invoice = new Invoice();
        $invoice->setEnabled(true);
        
        return $invoice;
    }

    /**
     * @param $slug
     *
     * @return int|mixed[]|string
     */
    public function getAllInvoiceByClient($slug)
    {
        return $this->invoiceRepository->findAllInvoiceByClient($slug);
    }

    /**
     * @param Invoice $invoice
     * @param bool    $andFlush
     */
    public function save(Invoice $invoice, $andFlush = true)
    {
        $this->em->persist($invoice);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}