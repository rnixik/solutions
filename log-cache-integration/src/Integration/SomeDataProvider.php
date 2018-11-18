<?php

namespace src\Integration;

class SomeDataProvider implements SomeDataProviderInterface
{
    private $host;
    private $user;
    private $password;

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     */
    public function __construct(string $host, string $user, string $password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @inheritdoc
     */
    public function get(array $request)
    {
        // returns a response from external service
    }
}
