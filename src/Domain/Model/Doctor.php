<?php
declare(strict_types=1);

namespace App\Domain\Model;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Uid\Ulid;

#[Entity]
class Doctor
{
    #[Id]
    #[Column(type: 'ulid')]
    private Ulid $id;

    #[Column(type: 'integer', unique: true)]
    private int $externalId;

    #[Column(type: 'string')]
    private string $name;

    public function __construct(int $externalId, string $name,)
    {
        $this->id = new Ulid();
        $this->name = $name;
        $this->externalId = $externalId;
    }
}
