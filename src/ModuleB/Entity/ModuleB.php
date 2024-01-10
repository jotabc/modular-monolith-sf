<?php

namespace ModuleB\Entity;

class ModuleB
{
    # relacion suave
    private string $moduleAId;

    public function __construct(
        private readonly string $id = 'module_b_id',
    ) { }

    public function getId(): string
    {
        return $this->id;
    }

}
