<?php
// Create database connection using config file
include_once 'config.php';

// Fetch all users data from database
$hardware = mysqli_query($mysqli, 'SELECT * FROM hardwares ORDER BY id DESC');

if (isset($_POST['add'])) {
  $state = $_POST['state'] == 'ON' ? 1 : 0;
  $name = $_POST['hardware'];

  $add = mysqli_query($mysqli, "INSERT INTO `hardwares` (`name`, `state`) VALUES ('$name', '$state');");

  // Redirect to homepage to display updated user in list
  header('Location: hardware.php');
}


if (isset($_POST['delete'])) {
  $id = $_POST['id'];

  $delete = mysqli_query($mysqli, "DELETE FROM hardwares WHERE `id` = '$id';");

  // Redirect to homepage to display updated user in list
  header('Location: hardware.php');
}

function timer($time)
{
  $now = time();
  $diff = $now - $time;
  if ($diff < 60) {
    return $diff . ' detik yang lalu';
  } elseif ($diff > 60) {
    if ($diff > 3600) {
      $diff = $diff / 3600;
      return round($diff) . ' jam yang lalu';
    } else {
      $diff = $diff / 60;
      return round($diff) . ' menit yang lalu';
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tugas Akhir | Hardware</title>
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
              <a class="flex items-center rounded-md bg-blue-200 p-3 text-sm font-bold text-blue-900" href="./">
                <span class="material-symbols-outlined mr-4"> memory </span>
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
              <a class="flex items-center rounded-md bg-blue-500 p-3 text-sm font-bold text-white" href="./hardware.php">
                <span class="material-symbols-outlined mr-4 text-white"> developer_board </span>
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
          <!-- component -->
          <form class="mb-4 rounded bg-white px-8 pt-6 pb-8" action="hardware.php" method="post">
            <div class="-mx-3 mb-2 md:flex">
              <div class="mb-6 px-3 md:mb-0 md:w-1/2">
                <label class="text-grey-darker mb-2 block text-xs font-bold uppercase tracking-wide" for="hardware">
                  Name
                </label>
                <input class="bg-grey-lighter text-grey-darker border-grey-lighter block w-full appearance-none rounded border py-3 px-4" id="hardware" name="hardware" type="text" placeholder="ESP32">
              </div>
              <div class="px-3 md:w-1/2">
                <label class="text-grey-darker mb-2 block text-xs font-bold uppercase tracking-wide" for="state">
                  State
                </label>
                <div class="relative">
                  <select class="bg-grey-lighter border-grey-lighter text-grey-darker block w-full appearance-none rounded border py-3 px-4 pr-8" id="state" name="state">
                    <option>OFF</option>
                    <option>ON</option>
                  </select>
                </div>
              </div>
              <div class="mt-7 ml-4 items-center justify-center md:w-1/2">
                <button class="rounded-lg bg-green-300 px-2 py-1 text-xl font-bold text-white" id="add" name="add" type="submit">Add</button>
              </div>
            </div>
          </form>
          <hr class="my-3" />
          <h1 class="mb-4 text-center text-xl">
            List Hardware
          </h1>
          <div class="mx-auto flex items-center justify-center">
            <table class="table w-screen border-collapse space-y-6 border text-sm text-black">
              <thead class="border text-gray-500">
                <tr>
                  <th class="border p-2">ID</th>
                  <th class="border p-2">Name</th>
                  <th class="border p-2">State</th>
                  <th class="border p-2">Action</th>
                </tr>
              </thead>
              <tbody class="border text-gray-500">
                <?php
                while ($hardware_data = mysqli_fetch_array($hardware)) {
                  echo "<tr class='border text-gray-500'>";
                  echo "<td class='border p-3 text-center'>";
                  echo $hardware_data['id'];
                  echo '</td>';
                  echo "<td class='border p-3 font-bold text-center'>";
                  echo $hardware_data['name'];
                  echo '</td>';
                  echo "<td class='border p-3 text-center'>";
                  echo "<span class='border rounded-md ";
                  echo $hardware_data['state'] == 1 ? 'bg-green-400' : 'bg-red-400 ';
                  echo " px-2 text-gray-50'>";
                  echo $hardware_data['state'] == 1 ? 'ON' : 'OFF';
                  echo '</span>';
                  echo '</td>';
                  echo "<td class='border p-3 text-center'>";
                  echo "<form name='delete' method='post' action='hardware.php'>";
                  echo "<input type='hidden' name='id' value='" . $hardware_data['id'] . "'>";
                  echo "<button class='cursor-pointer' type='submit' name='delete'>";
                  echo "<i class='material-symbols-outlined text-base text-white rounded-full p-1 bg-red-400 hover:bg-red-500'>delete_outline</i>";
                  echo '</form></button>';
                  echo '</td>';
                  echo '</tr>';
                }
                ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
    </div>
  </main>
</body>

</html>