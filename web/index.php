<?php
// Create database connection using config file
include_once("config.php");

// Fetch all users data from database
$hardware = mysqli_query($mysqli, "SELECT * FROM hardwares ORDER BY id ASC");
$logs = mysqli_query($mysqli, "SELECT * FROM logs ORDER BY id DESC limit 4 ");


if (isset($_POST['update'])) {
  $id = $_POST['id'];

  // $state = $_POST['state'];
  $state = $_POST['state'] == 1 ? 0 : 1;
  // update user data
  $update = mysqli_query($mysqli, "UPDATE hardwares SET state='$state' WHERE id=$id");

  // Redirect to homepage to display updated user in list
  header("Location: /");
}

function timer($time)
{
  $now = time();
  $diff = $now - $time;
  if ($diff < 60) {
    return $diff . " detik yang lalu";
  } else if ($diff > 60) {
    if ($diff > 3600) {
      $diff = $diff / 3600;
      return round($diff) . " jam yang lalu";
    } else {
      $diff = $diff / 60;
      return round($diff) . " menit yang lalu";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tugas Akhir</title>
  <link rel="stylesheet" href="./style.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>

<body class="relative bg-blue-50 overflow-hidden max-h-screen">
  <!-- sidebar -->
  <aside class="fixed inset-y-0 left-0 bg-white shadow-md max-h-screen w-60">
    <div class="flex flex-col justify-between h-full">
      <div class="flex-grow">
        <div class="p-4 text-center border-b">
          <h1 class="text-xl font-bold leading-none"><span class="text-blue-700">Tugas</span> Akhir</h1>
        </div>
        <div class="p-4">
          <ul class="space-y-1">
            <li>
              <a href="./" class="flex items-center bg-blue-200 rounded-md font-bold text-sm text-blue-900 p-3">
                <span class="material-symbols-outlined mr-4"> memory </span>
                Dashboard
              </a>
            </li>
            <li>
              <a href="./trigger" class="flex items-center bg-blue-200 rounded-md font-bold text-sm text-blue-900 p-3">
                <span class="material-symbols-outlined mr-4"> tune </span>
                Trigger
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="p-4">
        <ul class="space-y-1">
          <li>
            <a href="#" onclick="close_window();return false;" class="flex items-center bg-blue-200 rounded-xl font-bold text-sm text-blue-900 py-3 px-4">
              <span class="material-symbols-outlined mr-4"> logout </span>
              Exit
            </a>
          </li>
        </ul>
      </div>
    </div>
  </aside>

  <!-- main Content -->
  <main class="ml-60 max-h-screen overflow-auto">
    <div class="p-4">
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl p-8 mb-5">
          <h1 class="text-3xl font-bold mb-4 text-center">
            <span class="text-blue-700">Tugas Akhir</span> | Wahyuda Setiadi
          </h1>
          <hr class="my-1" />
          <div class="grid grid-cols-2 gap-x-20">
            <div>
              <h2 class="text-2xl font-bold mb-4">Hardware</h2>
              <div class="grid grid-cols-2 gap-4">

                <?php
                while ($hardware_data = mysqli_fetch_array($hardware)) {
                  echo "<form name='update' method='post' action='index.php'>";
                  echo "<div class='col-span-2'>
                  <div class='p-4 ";
                  echo $hardware_data['state'] == 1 ? "bg-green-100" : "bg-red-100 ";
                  echo " rounded-xl shadow-md'>";
                  echo "<div class='font-bold text-xl text-gray-800 leading-none'>" . $hardware_data['name'] . "</div>";
                  echo "<div class='mt-5'>";
                  echo "<button type='submit' name='update' value='Update' class='inline-flex items-center justify-center p-1 rounded-full bg-white text-gray-800 ";
                  echo $hardware_data['state'] == 1 ? "hover:text-green-500 " : "hover:text-red-500 ";
                  echo "  text-sm font-semibold transition'>";
                  echo "<input type='text' name='id' value='" . $hardware_data['id'] . "' class='hidden'/>";
                  echo "<input type='number' name='state' value='" . $hardware_data['state'] . "' class='hidden'/>";
                  echo "<span class='material-symbols-outlined'>";
                  echo $hardware_data['state'] == 1 ? "toggle_on" : "toggle_off";

                  echo "</span>
                  </button></div></div></div></form>";
                }
                ?>
              </div>
            </div>
            <div>
              <h2 class="text-2xl font-bold mb-4">Riwayat Perintah</h2>
              <?php
              while ($log_data = mysqli_fetch_array($logs)) {
                echo "<div class='space-y-4'>";
                echo "<div class='p-4 bg-white border rounded-xl text-gray-800 space-y-2 shadow-md'>";
                echo "<div class='flex justify-between'>";
                echo "<div class='text-gray-400 text-xs'> <a href='https://wa.me/" . $log_data['sender'] . "?text=" . $log_data['text'] . "'>" . $log_data['sender'] .  "</a></div>";
                echo "<div class='text-gray-400 text-xs'>" . timer($log_data['time']) . "</div>";
                echo "</div>";
                echo "<p class='font-bold hover:text-green-800'>" . $log_data['text'] . "</p>";
                echo "<div class='text-sm text-gray-600 cursor-pointer'>";
                echo "<span class='material-symbols-outlined rounded-full p-1 border-[1px] text-gray-800 inline align-middle mr-1'>";
                echo "devices";
                echo "</span>";
                echo $log_data['device_id'];
                echo "</div>";
                echo "</div>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </main>
  <script>
    function close_window() {
      confirm("Close Window?");
    }
    setTimeout(function() {
      window.location.reload(1);
    }, 5000);
  </script>
</body>

</html>