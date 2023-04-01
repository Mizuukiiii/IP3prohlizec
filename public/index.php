<?php
session_start();
require_once __DIR__ . '/../classes/auth.php';
require_once __DIR__ . "/../bootstrap/bootstrap.php";
require_login();

class IndexPage extends BasePage
{
    public function __construct()
    {
        $this->title = "Prohlížeč databáze firmy";
    }

    protected function pageBody()
    {
        $output = '';

        if ($_SESSION['admin']==1) {
            $output .= '<p>Hello Admin!!!</p>';
        } else {
            $output .= '<p>Hello User!!!</p>';
            $output .= '<form action="changepassword.php" method="POST">
                            <button type="submit" name="changepassword">Change Password</button>
                        </form>';
        }

        $output .= '<form action="logout.php" method="POST">
                        <button type="submit" name="logout">Logout</button>
                    </form>';

        return $output;
    }
}

$page = new IndexPage();
$page->render();

?>
