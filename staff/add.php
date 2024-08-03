<?php
session_start();

// Проверка роли пользователя (должен быть администратор)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include 'db.php'; // Подключение к базе данных

// Обработка формы публикации товара
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Путь для сохранения изображений
    $image_path = "uploads/" . basename($image);
    move_uploaded_file($image_tmp, $image_path);

    $sql = "INSERT INTO products (name, description, price, category, subcategory, image) 
            VALUES ('$product_name', '$description', '$price', '$category', '$subcategory', '$image_path')";

    if ($conn->query($sql) === TRUE) {
        echo "პროდუქტი წარმატებით გამოქვეყნდა!";
    } else {
        echo "შეცდომა: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ka">

<head>
    <meta charset="UTF-8">
    <title>ადმინისტრატორის პანელი - პროდუქტის გამოქვეყნება</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>პროდუქტის გამოქვეყნება</h1>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <label for="product_name">პროდუქტის სახელი:</label>
        <input type="text" id="product_name" name="product_name" required class="input-field"><br>

        <label for="description">აღწერა:</label>
        <textarea id="description" name="description" required class="input-field"></textarea><br>

        <label for="price">ფასი:</label>
        <input type="text" id="price" name="price" required class="input-field"><br>

        <label for="category">კატეგორია:</label>
        <select id="category" name="category" required class="input-field">
            <!-- ქვეკატეგორიები, რომლებიც შეესაბამება MyMarket.ge-ს -->
            <option value="ელექტრონიკა">ელექტრონიკა</option>
            <option value="მოდა">მოდა</option>
            <option value="უძრავი ქონება">უძრავი ქონება</option>
            <!-- დაამატეთ სხვა კატეგორიები -->
        </select><br>

        <label for="subcategory">ქვეკატეგორია:</label>
        <select id="subcategory" name="subcategory" required class="input-field">
            <!-- ქვეკატეგორიები, მაგალითები -->
            <option value="სმარტფონები">სმარტფონები</option>
            <option value="ლეპტოპები">ლეპტოპები</option>
            <option value="ტანსაცმელი">ტანსაცმელი</option>
            <!-- დაამატეთ სხვა ქვეკატეგორიები -->
        </select><br>

        <label for="image">პროდუქტის სურათი:</label>
        <input type="file" id="image" name="image" required class="input-field"><br>

        <input type="submit" value="გამოქვეყნება" class="submit-button">
    </form>
</body>

</html>