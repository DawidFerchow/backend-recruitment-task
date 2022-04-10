<?php
class User {

  protected $fileLocation = 'dataset/users.json';

  public function loadDataFromFile() {

    // think more developmental is define array or object later
    $json = file_get_contents($this->fileLocation);
    return $json;

  }

  public function saveDataToFile($data) {

    // think more developmental is define array or object later
    $json = file_put_contents($this->fileLocation, $data);
    return $json;

  }

  public function getAllUser() {

    $json = $this->loadDataFromFile();
    return $json;

  }

  public function getLastId() {

    $users = $this->getAllUser();
    $users = json_decode($users, false);

    foreach ($users as $user) {
       $ids[] = $user->id;
    }

    return max($ids);

  }

  //w3schools sugestion for security user input
  function testInput($data) {

    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;

  }

  public function checkIsFilled($data) {
    if (
        empty($_POST["name"])
        || empty($_POST["username"])
        || empty($_POST["email"])
        || empty($_POST["address"])
        || empty($_POST["phone"])
        || empty($_POST["company"])
      )
      {
        return false;
      } else {
        return true;
      }
  }

  public function checkIsValid($data) {

    if (
      /* name regex by Benjamin: https://regexr.com/3bahr */
      preg_match("^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$", $_POST["name"]) === 0
      /* name regex by beta3Designs: https://regexr.com/3e91o */
      || preg_match("(?!.*[\.\-\_]{2,})^[a-zA-Z0-9\.\-\_]{3,24}$", $_POST["username"]) === 0
      /* email regex from: https://emailregex.com/ */
      || preg_match("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?", $_POST["email"]) === 0
      /* simplest is my, must train more regex :p */
      || preg_match("^[a-zA-Z0-9, ]*[,]{1}[ ]{1}[0-9-]*[ ]{1}[a-zA-Z ]+$", $_POST["address"]) === 0
      /* phone regex by Alex Snet: https://regexr.com/38pvb */
      || preg_match("^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$", $_POST["phone"]) === 0
      /* name regex by Benjamin: https://regexr.com/3bahr */
      || preg_match("^([A-Za-z]+([ ]?[A-Za-z.]?['-]?[A-Za-z.]+)*)$$", $_POST["company"]) === 0
    ) {
      return false;
    } else {
      return true;
    }


  }

  public function addUser($data) {

    $name = $this->testInput($data["name"]);
    $username = $this->testInput($data["username"]);
    $email = $this->testInput($data["email"]);
    $address = $this->testInput($data["address"]);
    $phone = $this->testInput($data["phone"]);
    $company = $this->testInput($data["company"]);

    // get highest ID from file because we know
    // which ID set to new user. Think must set
    // highest from json file
    $id = $this->getLastId();
    $id++;

    $newUser = new stdClass();
    $newUser->id = $id;
    $newUser->name = $name;
    $newUser->username = $username;
    $newUser->email = $email;
    $newUser->address = new stdClass();
    // format address is xxx, xxx xxx so:
    $newUser->address->street = explode(',', $address)[0];
    // bypass if user have two string in street name
    $zipcodeWithCity = explode(',', $address)[1];
    $newUser->address->zipcode = explode(' ', trim($zipcodeWithCity))[0];
    // bypass if city have two string..
    $newUser->address->city = str_replace($newUser->address->zipcode, '', $zipcodeWithCity);
    $newUser->phone = $phone;
    $newUser->company = new stdClass();
    $newUser->company->name = $company;


    $users = $this->getAllUser(); // string json
    $users = json_decode($users, true); // object
    $users[] = $newUser; // array
    $users = json_encode($users); // string json
    $saveUser = $this->saveDataToFile($users);

    return $saveUser;
  }

  public function deleteUser($id) {

    $users = $this->getAllUser();
    $users = json_decode($users, true);

    foreach ($users as $key => $user) {
      if ($user['id'] == $id) {
        unset($users[$key]);
        break;
      }
    }
    // reindex
    $usersReindexed = array_values($users);
    $usersToSave = json_encode($usersReindexed);
    $saveUser = $this->saveDataToFile($usersToSave);

    return $saveUser;

  }

}
?>
