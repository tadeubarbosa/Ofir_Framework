<?php

namespace Ofir\Http;

Class Router
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        dd($request);
    }

}
