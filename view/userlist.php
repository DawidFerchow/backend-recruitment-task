<?php
if (isset($message) && $message === true) {
  echo '
    <div id="actionMessage" class="alert '.$actionStatus.'">
      <span class="closebtn">&times;</span>
      '.ucfirst($actionName).' '.$actionStatus.'.';
  if (isset($formMessage)) {
    echo '
      </br>
      Error: '
      .$formMessage;
  }
  echo '
    </div>';
}
?>
<div class="table-container">
  <table id="userListTable">
    <thead>
      <tr>
      <th>Name</th>
      <th>Username</th>
      <th>Email</th>
      <th>Address</th>
      <th>Phone</th>
      <th>Company</th>
      <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($users as $user) {

        echo '
          <tr>
            <td>'.$user->name.'</td>
            <td>'.$user->username.'</td>
            <td><a href="mailto:'.$user->email.'">'.$user->email.'</a></td>
            <td>'.$user->address->street.',
            '.$user->address->zipcode.'
            '.$user->address->city.'
            </td>
            <td>'.$user->phone.'</td>
            <td>'.$user->company->name.'</td>
            <td class="text-center"><a href="?page=delete&id='.$user->id.'"><button class="delete">REMOVE</button></a></td>
          </tr>
        ';

      }
    ?>
      <tr>
        <form action="?page=addUser" method="post">
          <td>
            <!-- name regex by Benjamin: https://regexr.com/3bahr -->
            <input type="text" id="name" name="name" placeholder="John Doe"
            pattern="^([A-Z][a-z]+([ ]?[a-z]?['-]?[A-Z][a-z]+)*)$"
            oninvalid="this.setCustomValidity('Try like this: John Doe')"
            oninput="this.setCustomValidity('')"
            required>
          </td>
          <td>
            <!-- name regex by beta3Designs: https://regexr.com/3e91o -->
            <input type="text" id="username" name="username" placeholder="john.doe"
            pattern="(?!.*[\.\-\_]{2,})^[a-zA-Z0-9\.\-\_]{3,24}$"
            oninvalid="this.setCustomValidity('Try like this: john.doe')"
            oninput="this.setCustomValidity('')"
            required>
          </td>
          <td>
            <!-- want use same regex like in php models but html5 regex is harder to understand -->
            <input type="email" id="email" name="email" placeholder="john.doe@example.com"
            oninvalid="this.setCustomValidity('Try like this: johndoe@mail.com')"
            oninput="this.setCustomValidity('')"
            required>
          </td>
          <td>
            <input type="text" id="address" name="address" placeholder="Sample street, 13245 City"
            pattern="^[a-zA-Z0-9, ]*[,]{1}[ ]{1}[0-9-]*[ ]{1}[a-zA-Z ]+$"
            oninvalid="this.setCustomValidity('Try like this: Sample street, 123456 Street')"
            oninput="this.setCustomValidity('')"
            required>
          </td>
          <td>
            <!-- phone regex by Alex Snet: https://regexr.com/38pvb -->
            <input type="tel" id="phone" name="phone"
            placeholder="123 456 789"
            pattern="^\s*(?:\+?(\d{1,3}))?([-. (]*(\d{3})[-. )]*)?((\d{3})[-. ]*(\d{2,4})(?:[-.x ]*(\d+))?)\s*$"
            oninvalid="this.setCustomValidity('Try like this: 123 456 789')"
            oninput="this.setCustomValidity('')"
            required>
          </td>
          <td>
            <!-- name regex by Benjamin: https://regexr.com/3bahr -->
            <input type="text" id="company" name="company" placeholder="Company Name"
            pattern="^([A-Za-z]+([ ]?[A-Za-z.]?['-]?[A-Za-z.]+)*)$"
            oninvalid="this.setCustomValidity('Try like this: Sample Company')"
            oninput="this.setCustomValidity('')"
            required>
          </td>
          <td class="text-center"><button type="submit" class="add">ADD</button></td>
        </form>
      </tr>

    </tbody>
  </table>
</div>
