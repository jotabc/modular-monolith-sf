<?php

namespace Customer\Adapter\Framework\Http\DTO;

use Symfony\Component\HttpFoundation\Request;

class GetCustomersRequest implements RequestDTO
{
    public readonly int $page;
    public readonly int $limit;
    public readonly ?string $employeeId;

    public function __construct(Request $request)
    {
        $this->page = $request->query->getInt('page');
        $this->limit = $request->query->getInt('limit');
        $this->employeeId = $request->query->get('employeeId');
    }
}
