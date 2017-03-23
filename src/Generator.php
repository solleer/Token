<?php
namespace Token;
interface Generator {
    public function generateToken(array $data): string;
    public function isTokenValid($token): bool;
    public function getTokenData($token);
    public function redeemToken($token);
}
