<?php
include_once("model/User.php");

class UserController{

  protected $model;

  public function __construct() {
    $this->model = new User();
  }

  public function invoke() {

    if(isset($_GET['page'])) {
      $page = $_GET['page'];
    } else {
      $page = '';
    }

    switch($page){

      case 'addUser';
      $data = $_POST;
      if ($this->model->checkIsFilled($data) === false){

          $formMessage = htmlspecialchars('Complete all required fields!');
          header("location: ?action=add&status=failure&message=$formMessage");

      } elseif ($this->model->checkIsValid($data) === false) {

          $formMessage = htmlspecialchars('Incorrectly filled fields!!');
          header("location: ?action=add&status=failure&message=$formMessage");

      } elseif ($this->model->addUser($data) === false) {

          $formMessage = htmlspecialchars('Data could not be saved!');
          header("location: ?action=add&status=failure&message=$formMessage");

      } else {
          header("location: ?action=add&status=success");
      }
      break;

      case 'delete';
        $userID = $_GET['id'];
        $idToDelete = $this->model->testInput($userID);
        $userDelete = $this->model->deleteUser($idToDelete);

        if ($userDelete === false) {

          header("location: index.php?action=delete&status=failure");

        } else {

          header("location: index.php?action=delete&status=success");

        }
      break;

      default:
        if(isset($_GET['action']) && isset($_GET['status']) || isset($_GET['message'])) {

          $actionName = $this->model->testInput($_GET['action']);
          $actionStatus = $this->model->testInput($_GET['status']);

          if (isset($_GET['message'])) {

            $formMessage = $this->model->testInput($_GET['message']);

          }

          $message = true;

        }

        $users = $this->model->getAllUser();
        $users = json_decode($users, false);

        include ("view/userlist.php");
      break;
   }

  }

}
