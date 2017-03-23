<?php
namespace Token;
class NoExpire implements Generator {
    private $mapper;
    private $codeGenerator;

    public function __construct(\ArrayAccess $mapper, \Utils\RandomStringGenerator $codeGenerator) {
        $this->mapper = $mapper;
        $this->codeGenerator = $codeGenerator;
    }

    public function generateToken(array $data): string {
        $token = $codeGenerator->generate(20);
        $this->mapper[$token] = (object) $data;
        return $token;
    }

    public function isTokenValid($token): bool {
        return isset($this->mapper[$token]);
    }

    public function getTokenData($token) {
        return $this->mapper[$token] ?? false;
    }

    public function redeemToken($token) {
        unset($this->mapper[$token]);
    }
}
