<?php 

namespace App\Enums; 

use ArchTech\Enums\Values;

enum DirectionEnum:string {

    use Values;

    case North = 'NORTH';
    case South = 'SOUTH';
    case East  = 'EAST';
    case West  = 'WEST';

    /**
     * 90 degrees Rotated Direction
     *
     * @param string $facing
     * @return string
     */
    public function getLeftDirection($facing): string {
        $direction = [
            'SOUTH' => 'EAST',
            'EAST'  => 'NORTH',
            'NORTH' => 'WEST',
            'WEST'  => 'SOUTH',
        ];

        return $direction[$facing];
    }

    /**
     * 90 degrees Rotated Direction
     *
     * @param string $facing
     * @return string
     */
    public function getRightDirection($facing): string {
        $direction = [
            'EAST'  => 'SOUTH', 
            'NORTH' => 'EAST', 
            'WEST'  => 'NORTH',
            'SOUTH' => 'WEST',
        ];

        return $direction[$facing];
    }
}