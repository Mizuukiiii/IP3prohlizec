<?php
// ChangePasswordPage.php

require_once __DIR__ . '/BasePage.php';

class ChangePasswordPage extends BasePage
{
    public function __construct()
    {
        $this->title = "Change Password";
    }

    protected function pageBody()
    {
        return '
            <h1>Change Password</h1>
            <form method="post">
                <label>
                    Current Password:
                    <input type="password" name="current_password">
                </label>
                <br>
                <label>
                    New Password:
                    <input type="password" name="new_password">
                </label>
                <br>
                <button type="submit">Change Password</button>
            </form>
        ';
    }
}
