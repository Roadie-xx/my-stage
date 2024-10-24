<?php

namespace App\Helpers;

class CharacterCollection
{
    private string $type;
    private string $description;
    private array $data;
    private array $info;

    
    public function setType(string $type): void
    {
        if (! in_array($type, ['episode', 'location', 'dimension'])) {
            throw new Exception('Unknown type');
        }

        $this->type = $type;
    }

    public function setDescription(string $query): void
    {
        if (! isset($this->type)) {
            throw new Exception('Set type before description');
        }

        switch ($this->type) {
            case 'episode':
                $this->description = sprintf('Characters in episode "%s"', $query);

                break;
            case 'location':
                $this->description = sprintf('Characters @ "%s"', $query);

                break;
            case 'dimension':
                $this->description = sprintf('Characters in the dimension "%s"', $query);

                break;
            default:
                throw new Exception('Unknown type');
            }
    }

    public function setData(array $data): void 
    {
        $this->data = $data;
    }

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

    public function getData(): array 
    {
        return $this->data;
    }

    public function getInfo(): array 
    {
        return $this->info;
    }
}
