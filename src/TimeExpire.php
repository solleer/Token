<?php
namespace Token;
class TimeExpire implements Generator {
    private $mapper;
    private $randGenerator;
    private $experationHours;

    public function __construct(\ArrayAccess $mapper, \Utils\RandomStringGenerator $randGenerator) {
        $this->mapper = $mapper;
        $this->randGenerator = $randGenerator;
        $this->experationHours = 24;
    }

    public function generateToken(array $data): string {
        $token = $randGenerator->generate(20);
        $data['timestamp'] = new \DateTime();
        $this->mapper[$token] = (object) $data;
        return $token;
    }

    public function isTokenValid($token): bool {
        if (!isset($this->mapper[$token])) return false;
        $now = new \DateTime();
        $diffHours = $now->diff($this->mapper[$token]->timestamp)->format('rh');
        return -$this->experationHours < $diffHours && $diffHours < 0;
    }

    public function getTokenData($token) {
        if ($this->isTokenValid($token)) return false;
        return $this->mapper[$token] ?? false;
    }

    public function redeemToken($token) {
        $datetime = (new \DateTime())->modify('-' . $this->experationHours + 1 . ' hours');
        $this->mapper[$token] = (object) ['timestamp' => $datetime];
    }
}
