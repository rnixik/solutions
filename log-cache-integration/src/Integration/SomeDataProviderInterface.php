<?php

namespace src\Integration;

interface SomeDataProviderInterface
{
    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request);
}
