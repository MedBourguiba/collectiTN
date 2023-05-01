<?php

namespace App\Command;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SetStatusCommand extends Command
{
    protected static $defaultName = 'set-status';
    
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Set the status of items with an end time less than the current time.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Setting status of items...');

        while (true) {
            $currentTime = new \DateTime();
            $items = $this->entityManager->getRepository(Item::class)
                ->createQueryBuilder('i')
                ->where('i.end_time < :currentTime')
                ->setParameter('currentTime', $currentTime)
                ->getQuery()
                ->getResult();

            foreach ($items as $item) {
                $item->setStatus(1);
                $this->entityManager->persist($item);
            }

            $this->entityManager->flush();

            sleep(10);
        }

        return Command::SUCCESS;
    }
}

