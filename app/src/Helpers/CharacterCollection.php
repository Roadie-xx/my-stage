<?php

namespace App\Helpers;

use Exception;

class CharacterCollection
{
    private string $type;
    private string $description;
    /**
     * @var array<string, mixed> $data
     */
    private array $data;
    /**
     * @var array<string, mixed> $info
     */
    private array $info;

    /**
     * @throws Exception
     */
    public function setType(string $type): void
    {
        if (! in_array($type, ['episode', 'location', 'dimension'])) {
            throw new Exception('Unknown type');
        }

        $this->type = $type;
    }

    /**
     * @throws Exception
     */
    public function setDescription(string $query): void
    {
        if (! isset($this->type)) {
            throw new Exception('Set type before description');
        }

        $this->description = match ($this->type) {
            'episode' => sprintf('Characters in episode "%s"', $query),
            'location' => sprintf('Characters @ "%s"', $query),
            'dimension' => sprintf('Characters in the dimension "%s"', $query),
            default => throw new Exception('Unknown type'),
        };
    }

    /**
     * @param array<string, mixed> $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @param array<string, mixed> $info
     */
    public function setInfo(array $info): void
    {
        $this->info = $info;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array<string, mixed>
     */
    public function getInfo(): array
    {
        return $this->info;
    }
}
