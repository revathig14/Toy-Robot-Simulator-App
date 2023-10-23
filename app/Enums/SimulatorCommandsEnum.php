<?php 

namespace App\Enums; 

use ArchTech\Enums\Values;

enum SimulatorCommandsEnum:string {

    use Values;

    case Move  = 'MOVE';
    case Left  = 'LEFT';
    case Right = 'RIGHT';
}