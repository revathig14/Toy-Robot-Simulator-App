<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Interfaces\RobotSimulatorInterface;
use App\Enums\SimulatorCommandsEnum;

class ToyRobotSimulator extends Command
{
    /**
     * Contructor
     *
     * @param RobotSimulatorInterface $robotSimulator
     */
    public function __construct(
        private RobotSimulatorInterface $robotSimulator
    ) {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:toy-robot-simulator';    

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Toy Robot Simulator';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Info - List of commands for help
        $this->commandDescription();       

        do {
            $command = $this->ask('Please enter your command to proceed');

            // Break the loop with STOP command
            if (strtoupper($command) == 'STOP') {
                break;
            } else if (preg_match('/^PLACE /', strtoupper($command))) {
                // Place the robot
                if (!$this->robotSimulator->place($command)) {
                    // Return the error
                    $this->error($this->robotSimulator->error());
                }
            } else if (strtoupper($command) == 'REPORT') {
                // Report the output with co-ordinates with facing direction 
                $this->info('Output: '. $this->robotSimulator->report());
            } else if (in_array(strtoupper($command), SimulatorCommandsEnum::values())) {
                // Call the methods to direct robot
                $function = strtolower($command);
                if (!$this->robotSimulator->$function()) {
                    $this->error($this->robotSimulator->error());
                }
            } else {
                $this->error("Invalid `{$command}`.");
                $this->commandDescription();
            }
        } while (true);
    }

    /**
     * Command Description - Help
     */
    private function commandDescription()
    {
        $this->info("Please enter commands like below:\n" .
                   "\tPLACE x-position,y-position,facing-direction(eg: PLACE 0,0,NORTH)\n" .
                   "\tMOVE\n" .
                   "\tLEFT\n" .
                   "\tRIGHT\n" .
                   "\tREPORT\n");
    }
}