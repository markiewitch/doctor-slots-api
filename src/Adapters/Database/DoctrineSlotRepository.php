<?php

declare(strict_types=1);

namespace App\Adapters\Database;

use App\Domain\Model\Doctor;
use App\Domain\Model\Slot;
use App\Domain\Ports\SlotRepository;
use App\SlotSorting\SlotsSorter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Ulid;

class DoctrineSlotRepository extends ServiceEntityRepository implements SlotRepository
{
    /** @var SlotsSorter[] */
    private array $sorters;

    public function __construct(ManagerRegistry $registry, string $entityClass, private LoggerInterface $logger, \Traversable $sorters)
    {
        parent::__construct($registry, $entityClass);
        $this->sorters = iterator_to_array($sorters);
    }

    public function save(Slot $slot): void
    {
        $this->getEntityManager()->persist($slot);
        $this->getEntityManager()->flush();
    }

    public function findByDoctorTimeslot(Doctor $doctor, \DateTimeImmutable $from, \DateTimeImmutable $to): ?Slot
    {
        return $this->findOneBy(['doctor' => $doctor, 'dateFrom' => $from, 'dateTo' => $to]);
    }

    public function queryBy(?string $cursor = null, string $orderBy = null, ?\DateTimeImmutable $from = null, ?\DateTimeImmutable $to = null, int $limit): CursorDelimitedCollection
    {
        $qb = $this->createQueryBuilder('s');

        $qb->setMaxResults($limit);

        if (($sorter = $this->sorters[$orderBy] ?? null) !== null) {
            /** @var SlotsSorter $sorter */
            $sorter->apply($qb);
        }

        $qb->addOrderBy('s.id', 'ASC');

        if ($from instanceof \DateTimeImmutable) {
            $qb->andWhere('s.dateFrom > :date_from');
            $qb->setParameter('date_from', $from);
        }

        if ($to instanceof \DateTimeImmutable) {
            $qb->andWhere('s.dateFrom < :date_to');
            $qb->setParameter('date_to', $to);
        }

        if ($cursor !== null) {
            $cursor = Cursor::decrypt($cursor);
            $this->logger->debug("Cursor decrypted", ['value' => $cursor]);
            foreach ($cursor ?? [] as $pointer) {
                $this->logger->debug("Cursor parameter applied", ['value' => $pointer]);
                // todo move to dedicated code piece
                [$column, $operator, $value] = $pointer;
                if ($column === 'id' && $operator === '>' && is_string($value)) {
                    $id = Ulid::fromBase32($value);
                    $qb->andWhere('s.id > :id_cursor');
                    $qb->setParameter('id_cursor', $id, 'ulid');
                }
            }
        }

        $items = $qb->getQuery()->getResult();
        $nextCursor = [['id', '>', end($items)->getId()]];
        return new CursorDelimitedCollection($items, Cursor::encode($nextCursor));
    }
}
