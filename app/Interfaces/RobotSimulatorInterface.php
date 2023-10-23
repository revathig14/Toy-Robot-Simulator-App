<?php

namespace App\Interfaces;

interface RobotSimulatorInterface
{
    public function place($command): bool;
    public function isPlaced(): bool;
    public function isValidRange(int $x, int $y): bool;
    public function move(): bool;
    public function left(): bool;
    public function right(): bool;
    public function report(): string;
    public function getError(): string;
}