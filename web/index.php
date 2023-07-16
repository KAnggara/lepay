<?php
// Create database connection using config file
include_once 'config.php';

// Fetch all users data from database
$hardware = mysqli_query($mysqli, 'SELECT * FROM hardwares ORDER BY id ASC');
$logs = mysqli_query($mysqli, 'SELECT * FROM logs ORDER BY id DESC limit 4 ');

if (isset($_POST['update'])) {
  $id = $_POST['id'];

  // $state = $_POST['state'];
  $state = $_POST['state'] == 1 ? 0 : 1;
  // update user data
  $update = mysqli_query($mysqli, "UPDATE hardwares SET state='$state' WHERE id=$id");

  // Redirect to homepage to display updated user in list
  header('Location: /');
}

function timer($time)
{
  $now = time();
  $diff = $now - $time;

  if ($diff < 60) {
    return $diff . ' detik yang lalu';
  }

  if ($diff < 3600) {
    $diff = $diff / 60;
    return round($diff) . ' menit yang lalu';
  }

  if ($diff < 86400) {
    $diff = $diff / 3600;
    return round($diff) . ' jam yang lalu';
  }

  if ($diff < 31536000) {
    $diff = $diff / 86400;
    return round($diff) . ' hari yang lalu';
  }

  $diff = $diff / 31536000;
  return number_format($diff, 1) . ' tahun yang lalu';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tugas Akhir | Dashboard</title>
  <link href="./style.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" rel="stylesheet" />
</head>

<body class="relative max-h-screen overflow-hidden bg-blue-50">
  <!-- sidebar -->
  <aside class="fixed inset-y-0 left-0 max-h-screen w-60 bg-white shadow-md">
    <div class="flex h-full flex-col justify-between">
      <div class="flex-grow">
        <div class="border-b p-4 text-center">
          <h1 class="text-xl font-bold leading-none"><span class="text-blue-700">Tugas</span> Akhir</h1>
        </div>
        <div class="p-4">
          <ul class="space-y-1">
            <li>
              <a class="flex items-center rounded-md bg-blue-500 p-3 text-sm font-bold text-white" href="./">
                <span class="material-symbols-outlined mr-4 text-white"> memory </span>
                Dashboard
              </a>
            </li>
            <li>
              <a class="flex items-center rounded-md bg-blue-200 p-3 text-sm font-bold text-blue-900" href="./trigger.php">
                <span class="material-symbols-outlined mr-4"> tune </span>
                Trigger
              </a>
            </li>
            <li>
              <a class="flex items-center rounded-md bg-blue-200 p-3 text-sm font-bold text-blue-900" href="./hardware.php">
                <span class="material-symbols-outlined mr-4"> developer_board </span>
                Hardware
              </a>
            </li>
          </ul>
        </div>
      </div>
      <div class="p-4">
        <ul class="space-y-1">
          <li>
            <a class="flex items-center rounded-xl bg-blue-200 py-3 px-4 text-sm font-bold text-blue-900" href="Documentation.pdf">
              <span class="material-symbols-outlined mr-4"> description </span>
              Documentation
            </a>
          </li>
        </ul>
      </div>
    </div>
  </aside>

  <!-- main Content -->
  <main class="ml-60 max-h-screen overflow-auto">
    <div class="p-4">
      <div class="mx-auto max-w-4xl">
        <div class="mb-5 rounded-xl bg-white p-8">
          <h1 class="mb-4 text-center text-3xl font-bold">
            <span class="text-blue-700">Tugas Akhir</span> | Wahyuda Setiadi
          </h1>
          <hr class="my-3" />
          <div class="grid grid-cols-2 gap-x-20">
            <div>
              <h2 class="mb-4 text-2xl font-bold">Hardware</h2>
              <div class="grid grid-cols-2 gap-4">
                <?php
                while ($hardware_data = mysqli_fetch_array($hardware)) {
                  echo "<form name='update' method='post' action='index.php'>";
                  echo "<div class='col-span-2'><div class='p-4 ";
                  echo $hardware_data['state'] == 1 ? 'bg-green-100' : 'bg-red-100 ';
                  echo " rounded-xl shadow-md'>";
                  echo "<div class='font-bold text-xl text-gray-800 leading-none'>" . $hardware_data['name'] . '</div>';
                  echo "<div class='mt-5'>";
                  echo "<button type='submit' name='update' value='Update' class='inline-flex items-center justify-center p-1 rounded-full bg-white text-gray-800 ";
                  echo $hardware_data['state'] == 1 ? 'hover:text-green-500 ' : 'hover:text-red-500 ';
                  echo "  text-sm font-semibold transition'>";
                  echo "<input type='text' name='id' value='" . $hardware_data['id'] . "' class='hidden'/>";
                  echo "<input type='number' name='state' value='" . $hardware_data['state'] . "' class='hidden'/>";
                  echo "<span class='material-symbols-outlined'>";
                  echo $hardware_data['state'] == 1 ? 'toggle_on' : 'toggle_off';
                  echo '</span></button></div></div></div></form>';
                }
                ?>
              </div>
            </div>
            <div>
              <h2 class="mb-4 text-2xl font-bold">Riwayat Perintah</h2>
              <?php
              while ($log_data = mysqli_fetch_array($logs)) {
                echo "<div class='space-y-4'>";
                echo "<div class='p-4 bg-white border rounded-xl text-gray-800 space-y-2 shadow-md'>";
                echo "<div class='flex justify-between'>";
                echo "<div class='text-gray-400 text-xs'> <a href='https://wa.me/" . $log_data['sender'] . '?text=' . $log_data['text'] . "'>" . $log_data['sender'] . '</a></div>';
                echo "<div class='text-gray-400 text-xs'>" . timer($log_data['time']) . '</div>';
                echo '</div>';
                echo "<p class='font-bold hover:text-green-800'>" . $log_data['text'] . '</p>';
                echo "<div class='text-sm text-gray-600 cursor-pointer'>";
                echo "<span class='material-symbols-outlined rounded-full p-1 border-[1px] text-gray-800 inline align-middle mr-1'>";
                echo 'devices';
                echo '</span>';
                echo $log_data['device_id'];
                echo '</div>';
                echo '</div>';
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
    setTimeout(function() {
      window.location.reload(1);
    }, 5000);
  </script>
</body>

</html>