<?php
// run code once for database initialization,
// after which remove if statement or set value to false
// you do not have to, but it should eliminate unnecessary code from running
if (true) {
  // setup users table
  // if it fails, remove the table completely to ensure all works
  try {
    $conn->query("CREATE TABLE IF NOT EXISTS `User` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `name` VARCHAR(100) NOT NULL,
      `surname` VARCHAR(100) NOT NULL,
      `username` VARCHAR(100) NOT NULL UNIQUE,
      `password` VARCHAR(100) NOT NULL
    )");
  } catch (Throwable $th) {
    $conn->query("DROP TABLE IF EXISTS `User`");
    echo "\n User: " . json_encode($th) . "\n";
  }

  // setup cinema table
  // if it fails, remove the table completely to ensure all works
  try {
    $conn->query("CREATE TABLE IF NOT EXISTS `Cinema` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `location` VARCHAR(100) NOT NULL
    )");

    $testValues = $conn->prepare("SELECT COUNT(id) FROM `Cinema`");

    if (!$testValues->execute()) {
      throw new Exception("Could not run query", 1);
    }

    if ($testValues->rowCount() > 0) {
      echo "\n- Cinema has data \n";
    } else {
      $prep = $conn->prepare("INSERT INTO `Cinema` (
        `location`
      ) VALUES (
        :location
      )");

      foreach ([
        [':location' => 'Centurion Mall'],
        [':location' => 'Cresta Shopping Center'],
        [':location' => 'Eastgate'],
        [':location' => 'Gateway Theater Of Shopping'],
        [':location' => 'Mall Of Africa'],
        [':location' => 'Menlyn Park Shopping Center'],
        [':location' => 'Northgate'],
        [':location' => 'Sandton City'],
        [':location' => 'The Pavilion'],
        [':location' => 'Westwood'],
      ] as $value) {
        $prep->execute($value);
      }
    }
  } catch (Throwable $th) {
    $conn->query("DROP TABLE IF EXISTS `Cinema`");
    echo "\n Cinema: " . json_encode($th) . "\n";
  }

  // setup theatres table
  // if it fails, remove the table completely to ensure all works
  try {
    $conn->query("CREATE TABLE IF NOT EXISTS `Theatre` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `cinema` INT NOT NULL,
      `code` VARCHAR(100) NOT NULL
    )");

    // $prep = $conn->prepare("INSERT INTO `Theatre` (
    //   `cinema`, `code`
    // ) VALUES (
    //   (SELECT id FROM `Cinema` WHERE `location` = :location LIMIT 1),
    //   :code
    // )");

    // foreach ([
    //   [':location' => 'Centurion Mall', ':code' => '1'],
    //   [':location' => 'Centurion Mall', ':code' => '2'],
    //   [':location' => 'Centurion Mall', ':code' => '3'],
    //   [':location' => 'Cresta Shopping Center', ':code' => '1'],
    //   [':location' => 'Cresta Shopping Center', ':code' => '2'],
    //   [':location' => 'Cresta Shopping Center', ':code' => '3'],
    //   [':location' => 'Eastgate', ':code' => '1'],
    //   [':location' => 'Eastgate', ':code' => '2'],
    //   [':location' => 'Eastgate', ':code' => '3'],
    //   [':location' => 'Gateway Theater Of Shopping', ':code' => '1'],
    //   [':location' => 'Gateway Theater Of Shopping', ':code' => '2'],
    //   [':location' => 'Gateway Theater Of Shopping', ':code' => '3'],
    //   [':location' => 'Mall Of Africa', ':code' => '1'],
    //   [':location' => 'Mall Of Africa', ':code' => '2'],
    //   [':location' => 'Mall Of Africa', ':code' => '3'],
    //   [':location' => 'Menlyn Park Shopping Center', ':code' => '1'],
    //   [':location' => 'Menlyn Park Shopping Center', ':code' => '2'],
    //   [':location' => 'Menlyn Park Shopping Center', ':code' => '3'],
    //   [':location' => 'Northgate', ':code' => '1'],
    //   [':location' => 'Northgate', ':code' => '2'],
    //   [':location' => 'Northgate', ':code' => '3'],
    //   [':location' => 'Sandton City', ':code' => '1'],
    //   [':location' => 'Sandton City', ':code' => '2'],
    //   [':location' => 'Sandton City', ':code' => '3'],
    //   [':location' => 'The Pavilion', ':code' => '1'],
    //   [':location' => 'The Pavilion', ':code' => '2'],
    //   [':location' => 'The Pavilion', ':code' => '3'],
    //   [':location' => 'Westwood', ':code' => '1'],
    //   [':location' => 'Westwood', ':code' => '2'],
    //   [':location' => 'Westwood', ':code' => '3'],
    // ] as $value) {
    //   $prep->execute($value);
    // }
  } catch (Throwable $th) {
    $conn->query("DROP TABLE IF EXISTS `Theatre`");
    echo "\n Theatre: " . json_encode($th) . "\n";
  }

  // setup films
  // if it fails, remove the table completely to ensure all works
  try {
    $conn->query("CREATE TABLE IF NOT EXISTS `Film` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `name` VARCHAR(100) NOT NULL,
      `genre` VARCHAR(100) NOT NULL,
      `description` VARCHAR(1000) NOT NULL,
      `image` VARCHAR(1000) NOT NULL
    )");

    // $prep = $conn->prepare("INSERT INTO `Film` (
    //   `name`, `genre`, `description`, `image`
    // ) VALUES (
    //   :name, :genre, :description, :image
    // )");

    // foreach ([
    //   [
    //     ':name' => 'Knives Out',
    //     ':genre' => 'Comedy, Crime, Drama',
    //     ':description' => 'A detective investigates the death of a patriarch of an eccentric, combative family. ',
    //     ':image' => 'ttps://m.media-amazon.com/images/M/MV5BMGUwZjliMTAtNzAxZi00MWNiLWE2NzgtZGUxMGQxZjhhNDRiXkEyXkFqcGdeQXVyNjU1NzU3MzE@._V1_UX182_CR0,0,182,268_AL_.jpg'
    //   ], [
    //     ':name' => 'Joker',
    //     ':genre' => 'Crime, Drama, Thriller',
    //     ':description' => 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime. This path brings him face-to-face with his alter-ego: the Joker.',
    //     ':image' => 'https://m.media-amazon.com/images/M/MV5BNGVjNWI4ZGUtNzE0MS00YTJmLWE0ZDctN2ZiYTk2YmI3NTYyXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_UX182_CR0,0,182,268_AL_.jpg'
    //   ], [
    //     ':name' => 'Inception',
    //     ':genre' => 'Action, Adventure, Sci-Fi',
    //     ':description' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
    //     ':image' => 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_UX182_CR0,0,182,268_AL_.jpg'
    //   ], [
    //     ':name' => 'The Shawshank Redemption',
    //     ':genre' => 'Drama',
    //     ':description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
    //     ':image' => 'https://m.media-amazon.com/images/M/MV5BMDFkYTc0MGEtZmNhMC00ZDIzLWFmNTEtODM1ZmRlYWMwMWFmXkEyXkFqcGdeQXVyMTMxODk2OTU@._V1_UX182_CR0,0,182,268_AL_.jpg'
    //   ],
    // ] as $value) {
    //   $prep->execute($value);
    // }
  } catch (Throwable $th) {
    $conn->query("DROP TABLE IF EXISTS `Film`");
    echo "\n Film: " . json_encode($th) . "\n";
  }

  // setup films in theatre
  // if it fails, remove the table completely to ensure all works
  try {
    $conn->query("CREATE TABLE IF NOT EXISTS `FilmInTheatre` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `film` INT NOT NULL,
      `theatres` INT NOT NULL,
      `startDate` DATE NOT NULL,
      `endDate` DATE NOT NULL
    )");
  } catch (Throwable $th) {
    $conn->query("DROP TABLE IF EXISTS `FilmInTheatre`");
    echo "\n FilmInTheatre: " . json_encode($th) . "\n";
  }

  // setup times films are showing in theatres
  // if it fails, remove the table completely to ensure all works
  try {
    $conn->query("CREATE TABLE IF NOT EXISTS `Time` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `filmInTheatre` INT NOT NULL,
      `time` TIME NOT NULL
    )");
  } catch (Throwable $th) {
    $conn->query("DROP TABLE IF EXISTS `Time`");
    echo "\n Time: " . json_encode($th) . "\n";
  }

  // setup a transaction table that tracks user transactions
  // if it fails, remove the table completely to ensure all works
  try {
    $conn->query("CREATE TABLE IF NOT EXISTS `Booking` (
      `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `user` INT NOT NULL,
      `time` INT NOT NULL,
      `quantity` INT NOT NULL
    )");
  } catch (Throwable $th) {
    $conn->query("DROP TABLE IF EXISTS `Booking`");
    echo "\n Booking: " . json_encode($th) . "\n";
  }
}
