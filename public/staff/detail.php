<?php
require_once __DIR__ . "/../../bootstrap/bootstrap.php";

class EmployeeDetailPage extends BasePage
{
    private $rooms;
    private $employee;
    private $keys;

    protected function prepare(): void
    {
        parent::prepare();
        //získat data z GET
        $employeeId = filter_input(INPUT_GET, 'employeeId', FILTER_VALIDATE_INT);
        if (!$employeeId)
            throw new BadRequestException();

        //najít místnost v databázi
        $this->employee = Employee::findByID($employeeId);
        if (!$this->employee)
            throw new NotFoundException();


        $stmt = PDOProvider::get()->prepare("
    SELECT `key`.key_id, `employee`.employee_id, `room`.name AS room_name, `room`.room_id AS room_id
    FROM `key`, `employee`, `room`
    WHERE `key`.employee = :employeeId
    AND `key`.room = `room`.room_id
    GROUP BY `room`.name
    ORDER BY `key`.key_id
");
        $stmt->execute(['employeeId' => $employeeId]);
        $this->keys = $stmt->fetchAll(PDO::FETCH_ASSOC);




        //$stmt = PDOProvider::get()->prepare("SELECT `surname`, `name`, `employee_id` FROM `employee` WHERE `employee_id`= :employeeId ORDER BY `surname`, `name`");
        //$stmt->execute(['employeeId' => $employeeId]);
        //$this->employees = $stmt->fetchAll();

        $this->title = "Detail místnosti {$this->employee->name}";

    }

    protected function pageBody()
    {
        //prezentovat data
        return MustacheProvider::get()->render(
            'employeeDetail',
            ['employee' => $this->employee, 'keys' =>$this->keys]
        );
    }

}

$page = new EmployeeDetailPage();
$page->render();

?>