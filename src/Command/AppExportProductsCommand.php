<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Writer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppExportProductsCommand extends Command
{
    protected static $defaultName = 'app:export-products';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var string
     */
    private $exportDir;

    public function __construct(
        EntityManagerInterface $entityManager,
        string                 $exportDir
    )
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->exportDir = $exportDir;
    }

    protected function configure()
    {
        $this
            ->setDescription('Export all products as a csv')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $products = $this->entityManager
            ->getRepository(Product::class)
            ->findAllForExport();
        $count = \count($products);
        $filePath = $this->exportDir.'/products_'.date('Ymdhis').'.csv';

        $io->text(\sprintf('%s products to export', $count));
        $io->text(\sprintf('The file is available at "%s"', $filePath));

        $csv = Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['id', 'name', 'description', 'price', 'picture']);
        $csv->insertAll($products);
        $content = $csv->getContent();

        if (!\file_exists($this->exportDir) && !\mkdir($this->exportDir) && !\is_dir($this->exportDir)) {
            $io->error('The export directory could not be created.');
            return;
        }

        if (\file_put_contents($filePath, $content)) {
            $io->success('The csv file is generated.');
        } else {
            $io->error('The csv generation failed.');
        }
    }
}
