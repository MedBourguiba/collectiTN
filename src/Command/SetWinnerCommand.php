<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Item;
use App\Entity\Bids;

#[AsCommand(
    name: 'set-winner',
    description: 'Set the winner of closed items',
)]
class SetWinnerCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Set the winner of closed items');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Setting winner of closed items...');
        $io->writeln('');

        while (true) {
            // Get all closed items
            $closedItems = $this->entityManager->getRepository(Item::class)
                ->findBy(['status' => 1]);

            foreach ($closedItems as $item) {
                // Check if the item already has a winner
                if ($item->getWinner()) {
                    continue;
                }

                // Retrieve the highest bid for the item
                $highestBid = $this->entityManager
                    ->getRepository(Bids::class)
                    ->findLastBidForItem($item);

                // If there are no bids, set the winner to null
                if (!$highestBid) {
                    $winner = null;
                } else {
                    // Otherwise, set the winner to the bidder of the highest bid
                    $winner = $highestBid->getUser();
                }

                // Set the winner of the item
                $item->setWinner($winner);

                // Persist the changes
                $this->entityManager->persist($item);
                $this->entityManager->flush();

                $io->writeln(sprintf('Set winner of item #%d', $item->getId()));
            }

            sleep(10);
        }

        return Command::SUCCESS;
    }
}
