<?php

namespace Customer\Adapter\Framework\Http\DTO;

use Symfony\Component\HttpFoundation\Request;

class UpdateCustomerRequestDTO implements RequestDTO
{
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $address;
    public readonly ?int $age;

    public function __construct(Request $request)
    {
        // attributes porque viene de parameter en la url osea /:id.
        $this->id = $request->attributes->get('id');

        // lo que viene en el body
        $this->name = $request->request->get('name');
        $this->address = $request->request->get('address');
        $this->age = $request->request->get('age');
    }
}
