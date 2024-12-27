<?php

include_once('snippets/ministers_office_header.php');

// insert post into database room_reservations table
$affectedRows = '';
$success = false;
$errors = [];
// table
$collection = $db->table('room_reservations');

// get all the reservations after the current date and time
$reservations = $collection
      ->select('*')
      ->where('date', '>', date('Y-m-d'))
      ->where('start_time', '>', date('H:i:s'))
      ->all();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $date = $_POST['date'];
      $time_start = $_POST['time_start'];
      $time_end = $_POST['time_end'];
      $id = $_POST['id'];
      $user = $_SESSION['username'];



      // check if the room is available
      $reservations =  $collection->select('*')->where('date', '=', $date)->all();

      if (count($reservations) > 0) {
            // make sure that reservations do not overlap by looking at the time intervals
            foreach ($reservations as $reservation) {
                  if ($time_start >= $reservation->start_time && $time_start <= $reservation->end_time) {
                        $errors[] = 'Someone has already reserved the room at that time';
                        $success = false;
                        break;
                  } else {
                        $success = true;
                  }
            }
      }

      // before inserting the reservation, make sure that the time_start is before time_end AND the date is in the future
      // AND that they are of the correct format
      if ($time_start >= $time_end) {
            $errors[] = 'Time start must be before time end';
            $success = false;
      }
      if (strtotime($date) < strtotime(date('Y-m-d'))) {
            $errors[] = 'Date must be in the future';
            $success = false;
      }
      if (!strtotime($time_start)) {
            $errors[] = 'Time start must be in the correct format';
            $success = false;
      }
      if (!strtotime($time_end)) {
            $errors[] = 'Time end must be in the correct format';
            $success = false;
      }


      if (count($errors) === 0) {
            $affectedRows = $collection->insert(array(
                  'date' => $date,
                  'start_time' => $time_start,
                  'end_time' => $time_end,
                  'reserved_by' => $user,
                  'room' => 'ministers office'
            ));
      }


      if ($affectedRows > 0) {
            $success = true;
            header('Location: /ministers-office');
      }
}
?>
<main>
      <?php if ($success) { ?>
            <div class="alert bg-success p-4 mb-8" role="alert">
                  <p class="color-beta">Room reserved successfully</p>
            </div>
      <?php } ?>
      <?php if (count($errors) > 0) { ?>
            <ul class="alert bg-danger p-4 mb-8" role="alert">
                  <?php foreach ($errors as $error) { ?>
                        <li class="ms-4 ps-2"><?= $error ?></li>
                  <?php } ?>
            </ul>
      <?php } ?>

      <section class="mt-8 mb-4">
            <h3 class="mb-4">current reservations</h3>
            <table class="table">
                  <thead>
                        <tr>
                              <th>Date</th>
                              <th>From</th>
                              <th>To</th>
                              <th>Reserved By</th>
                              <th>Time in hrs</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php foreach ($reservations as $reservation) { ?>
                              <tr>
                                    <td><?php echo date('M d, Y', strtotime($reservation->date)); ?></td>
                                    <td><?= $reservation->start_time ?></td>
                                    <td><?= $reservation->end_time ?></td>
                                    <td><?= $reservation->reserved_by ?></td>
                                    <td><?= ceil((strtotime($reservation->end_time) - strtotime($reservation->start_time)) / 3600) ?></td>
                              </tr>
                        <?php } ?>
                  </tbody>
            </table>
      </section>

      <form action="/ministers-office.php" method="post">
            <div class="mb-4">
                  <label for="date">Date:</label>
                  <input type="date" id="date" name="date" required><br>
            </div>
            <div class="mb-4">
                  <label for="time_start">Time Start:</label>
                  <input type="time" id="time_start" name="time_start" required><br>
            </div>
            <div>
                  <label for="time_end">Time End:</label>
                  <input type="time" id="time_end" name="time_end" required><br>
            </div>
            <div>
                  <input type="hidden" id="id" name="id" value="<?php echo uniqid(); ?>"><br>
            </div>
            <!-- <input type="hidden" id="user" name="user" value="<?php echo $_SESSION['user']; ?>"><br> -->

            <button type="submit" class="btn bg-delta text-center w-100 color-alpha">Schedule</button>
      </form>
</main>

<?php
include_once('app/snippets/app_footer.php');
