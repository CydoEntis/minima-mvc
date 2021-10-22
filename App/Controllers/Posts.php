<?php
namespace App\Controllers;

use Core\Controller;

class Posts extends Controller
{
  /**
   * Show the index page
   *
   * @return void
   */
  public function indexAction(): void
  {
    echo "Hello from the index action in the Posts controller";
    echo "<pre>";
    echo htmlspecialchars(print_r($_GET, true));
  }

  /**
   * Show the add new page
   *
   * @return void
   */
  public function addNewAction(): void
  {
    echo "Hello from the addNew action in the Posts controller";
  }

  public function editAction() {
    echo "Hello from the edit action in the Posts controller";
    echo "<p>Route Parameters: </p> <prev>" . htmlspecialchars(print_r($this->routeParams, true));
  }

  protected function before() {
    echo "(Before)";
}

protected function after() {
    echo "(After)";
}
}
