<?php

namespace App\Repositories;

use App\Interfaces\RobotSimulatorInterface;
use App\Enums\DirectionEnum;
use App\Repositories\Exceptions\RobotSimulatorRepositoryException;

class RobotSimulatorRepository implements RobotSimulatorInterface
{
    protected $isPlaced = false;
    protected $x = 0;
    protected $y = 0;
    protected $f = '';
    protected $error;

    /**
     * Place the toy robot on the table
     *
     * @param string $command
     * @return boolean
     * @throws Exception
     */
    public function place($command): bool
    {
        //add exceptions
        if ($this->isPlaced()) {
            $this->error = 'Toy Robot already placed on the table. Please use other command for operations.';
            return false;
        }

        $arguments = explode(',', str_replace('PLACE ', '', $command));

        //Check no of arguments
        if (count($arguments) !== 3) {
            throw new RobotSimulatorRepositoryException('Command should have 3 arguments - X, Y and Facing Direction. Eg: PLACE 0,1,WEST');
        }

        // check x and y range
        if (is_numeric($arguments[0]) 
            && is_numeric($arguments[1]) 
            && in_array(strtoupper($arguments[2]), DirectionEnum::values())
        ) {
            //Check the x and y co-ordinates is in valid range
            if (!$this->isValidRange($arguments[0], $arguments[1])) {
                $this->error = 'X and Y co-ordinates are invalid. X should be in the given range between '.
                config('simulator.x_min_value') . ' to ' .config('simulator.x_max_value') . 
                'and Y should be in the range between ' .
                config('simulator.y_min_value') . ' to ' .config('simulator.y_max_value');
                return false;
            } else {
                //Place the toy robot
                $this->x = $arguments[0];
                $this->y = $arguments[1];
                $this->f = strtoupper($arguments[2]);
                $this->isPlaced = true;
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * Check whether the robot is placed
     *
     * @return boolean
     */
    public function isPlaced(): bool
    {
        return $this->isPlaced;
    }

    /**
     * Get the error
     *
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * Check the X and Y range
     *
     * @param int $x
     * @param int $y
     * @return boolean
     */
    public function isValidRange($x, $y): bool
    {
        return ($x >= config('simulator.x_min_value') && $x <= config('simulator.x_max_value') 
            && $y >= config('simulator.y_min_value') && $y <= config('simulator.y_max_value'));
    }

    /**
     * Move the robot one unit forward in same direction
     *
     * @return boolean
     */
    public function move(): bool
    {
        if (!$this->isPlaced()) {
            $this->error = 'Robot is not placed on the table yet. Please place the robot with Command `PLACE x,y,direction`';
            return false;
        }

        $x = $this->x;
        $y = $this->y;

        // to move robot one unit forward in same direction
        if ($this->f == 'NORTH') {
            $y++;
        } else if ($this->f == 'EAST') {
            $x++;
        } else if ($this->f == 'SOUTH') {
            $y--;            
        } else if ($this->f == 'WEST') {
            $x--;
        }

        // Check if the robot is in the valid range after move
        if (!$this->isValidRange($x, $y)) {
            $this->error = 'Invalid command, this will make the robot out of range.';
            return false;
        }

        // set value to class variable
        $this->x = $x;
        $this->y = $y;

        // return true after move
        return true;
    }

    /**
     * Rotate the robot 90 degrees to the left direction
     *
     * @return boolean
     */
    public function left(): bool
    {
        if (!$this->isPlaced()) {
            $this->error = 'Robot is not placed on the table yet. Please place the robot with Command `PLACE x,y,direction`';
            return false;
        }

        // Rotate 90 degrees to left
        $direction = DirectionEnum::tryFrom($this->f);
        $this->f   = $direction->getLeftDirection($this->f);

        // return true after rotate
        return true;
    }

    /**
     * Rotate the robot 90 degrees to the right direction
     *
     * @return boolean
     */
    public function right(): bool
    {
        if (!$this->isPlaced()) {
            $this->error = 'Robot is not placed yet. Please place the robot with Command `PLACE x,y,direction`';
            return false;
        }
        
        // Rotate 90 degrees to right
        $direction = DirectionEnum::tryFrom($this->f);
        $this->f   = $direction->getRightDirection($this->f);

        // return true after rotate
        return true;
    }

    /**
     * Return the report with x, y and facing direction
     *
     * @return string
     */
    public function report(): string
    {
        //return result format as per request
        return $this->x .','. $this->y .','. $this->f;
    }
}