<?php

namespace C3M2H1\Enums;

enum ButtonEnum: int
{
    case A = 65;
    case B = 66;
    case C = 67;
    case D = 68;
    case E = 69;
    case F = 70;
    case G = 71;
    case H = 72;
    case I = 73;
    case J = 74;
    case K = 75;
    case L = 76;
    case M = 77;
    case N = 78;
    case O = 79;
    case P = 80;
    case Q = 81;
    case R = 82;
    case S = 83;
    case T = 84;
    case U = 85;
    case V = 86;
    case W = 87;
    case X = 88;
    case Y = 89;
    case Z = 90;

    public static function toUpperAscii(string $char): ?int
    {
        $ascii = ord(strtoupper($char)) ?? 0;
        $key = self::tryFrom($ascii);

        return $key?->value;
    }
}
