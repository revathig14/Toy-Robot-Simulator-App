<?php
namespace Tests\Unit;

use App\Repositories\Exceptions\RobotSimulatorRepositoryException;
use App\Repositories\RobotSimulatorRepository;
use Tests\TestCase;

class RobotSimulatorRepositoryTest extends TestCase
{
    /**
     *
     * @var RobotSimulatorRepository $robotSimulator
     */
    protected $robotSimulator;

    /**
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->robotSimulator = new RobotSimulatorRepository();
    }

    /**
     * @dataProvider placeDataProvider
     */
    public function testPlace($input, $expectedResult)
    {
        $robotSimulator = new RobotSimulatorRepository();

        $result = $robotSimulator->place($input);        
        $this->assertEquals($expectedResult, $result);
    }

    /**
     *
     * @return void
     */
    public function placeDataProvider()
    {
        return [
            ['PLACE 0,0,NORTH', true],
            ['PLACE 0,6,WEST', false],
            ['PLACE 6,6,EAST', false],
            ['PLACE 3,3,NORTH', true],
        ];
    }

    public function testMissingArguments()
    {
        $command = 'PLACE 0,0';
        $robotSimulator = new RobotSimulatorRepository();

        // Exception
        $this->expectException(RobotSimulatorRepositoryException::class);
        $this->expectExceptionMessage("Command should have 3 arguments - X, Y and Facing Direction. Eg: PLACE 0,1,WEST");    
        
        $robotSimulator->place($command);
    }


    /**
     *
     * @return void
     */
    public function testIsValidRange()
    {
        $x = 5;
        $y = 7;

        $robotSimulator = new RobotSimulatorRepository();

        $result = $robotSimulator->isValidRange($x, $y); 
        $this->assertEquals(false, $result);

        $x = 0;
        $y = 4;
        $result = $robotSimulator->isValidRange($x, $y); 
        $this->assertEquals(true, $result);
    }
}
