<?php

namespace App\Dto;

class ApiResponse
{
    /**
     * @var DragonDto[]
     */
    private array $items = [];

    public function getItems(): array
    {
        return $this->items;
    }

    public function setItems(array $items): void
    {
        $this->items = $items;
    }



}
