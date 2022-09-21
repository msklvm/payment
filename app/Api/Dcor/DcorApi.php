<?php

namespace App\Api\Dcor;

use App\Api\Interfaces\RestApiInterface;
use Illuminate\Http\Request;

class DcorApi extends RestApiInterface
{
    public function __construct(Request $request)
    {
        $this->setHost($this->getEnv('DCOR_API_URL'));
        $this->setToken($this->getEnv('DCOR_API_TOKEN'));

        $this->setHeader([
            "Content-type: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Authorization: " . $this->getToken(),
        ]);

        parent::__construct($request, self::HTTP_METHOD_GET);
    }

    public function contract()
    {
        return $this->setPath('contract_exist');
    }
}
