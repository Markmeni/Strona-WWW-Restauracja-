<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin_login.php');
    exit();
}

include '../db_connection.php';

// Handle adding categories
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    
    $stmt = $mysqli->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param('s', $category_name);
    $stmt->execute();
    $stmt->close();
}

// Handle adding menu items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_menu_item'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category_id = $_POST['category_id'];

    $stmt = $mysqli->prepare("INSERT INTO menu (name, description, price, image, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('ssdsi', $name, $description, $price, $image, $category_id);
    $stmt->execute();
    $stmt->close();
}

// Handle editing menu items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_menu_item'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $category_id = $_POST['category_id'];

    $stmt = $mysqli->prepare("UPDATE menu SET name = ?, description = ?, price = ?, image = ?, category_id = ? WHERE id = ?");
    $stmt->bind_param('ssdsii', $name, $description, $price, $image, $category_id, $id);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting menu items
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_menu_item'])) {
    $id = $_POST['id'];

    $stmt = $mysqli->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting reservations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_reservation'])) {
    $reservation_id = $_POST['reservation_id'];

    $stmt = $mysqli->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->bind_param('i', $reservation_id);
    $stmt->execute();
    $stmt->close();
}

// Handle editing reservations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $guests = $_POST['guests'];

    $stmt = $mysqli->prepare("UPDATE reservations SET name = ?, email = ?, phone = ?, date = ?, time = ?, guests = ? WHERE id = ?");
    $stmt->bind_param('ssssssi', $name, $email, $phone, $date, $time, $guests, $reservation_id);
    $stmt->execute();
    $stmt->close();
}

// Handle adding a response to a review
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['respond_review'])) {
    $review_id = $_POST['review_id'];
    $response = $_POST['response'];

    $stmt = $mysqli->prepare("UPDATE reviews SET response = ? WHERE id = ?");
    $stmt->bind_param('si', $response, $review_id);
    $stmt->execute();
    $stmt->close();
}

// Handle deleting reviews
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_review'])) {
    $review_id = $_POST['review_id'];

    $stmt = $mysqli->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param('i', $review_id);
    $stmt->execute();
    $stmt->close();
}

// Fetch categories
$categories = [];
if ($result = $mysqli->query("SELECT * FROM categories")) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    $result->free();
}

// Fetch menu items
$menu_items = [];
if ($result = $mysqli->query("SELECT menu.*, categories.name as category_name FROM menu JOIN categories ON menu.category_id = categories.id")) {
    while ($row = $result->fetch_assoc()) {
        $menu_items[] = $row;
    }
    $result->free();
}

// Fetch reservations
$reservations = [];
if ($result = $mysqli->query("SELECT * FROM reservations")) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
    $result->free();
}

// Fetch reviews
$reviews = [];
if ($result = $mysqli->query("SELECT reviews.*, users.username, menu.name as menu_name FROM reviews JOIN users ON reviews.user_id = users.id JOIN menu ON reviews.menu_id = menu.id")) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    $result->free();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>
<body>
<header>
<nav>
    <div class="logo-container">
        <div class="logo-nav">
            <img src="../images/logo.png" alt="Grill Restaurant Logo" class="logo" onclick="window.location.href='index.php'">
        </div>
        <div class="links-nav">
            <a href="../index.php">Home</a>
            <a href="../menu.php">Menu</a>
            <a href="../reservation.php">Reservation</a>
            <a href="../contact.php">Contact</a>
            
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == "admin"): ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="../logout.php">Logout</a>
            <?php else: ?>
                <a href="../login.php">Login</a>
                <a href="../register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>


    </header>
    <main>
        <section>
            <h2>Manage Categories</h2>
            <form method="post">
                <label for="category_name">Category Name:</label>
                <input type="text" name="category_name" required>
                <button type="submit" name="add_category">Add Category</button>
            </form>
            <h3>Existing Categories</h3>
            <ul>
                <?php foreach ($categories as $category) : ?>
                    <li><?php echo htmlspecialchars($category['name']); ?></li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section>
            <h2>Manage Menu Items</h2>
            <form id="menu-item-form" method="post">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
                <label for="description">Description:</label>
                <textarea name="description" required></textarea>
                <label for="price">Price:</label>
                <input type="text" name="price" required>
                <label for="image">Image URL:</label>
                <input type="text" name="image" required>
                <label for="category_id">Category:</label>
                <select name="category_id" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" name="add_menu_item">Add Menu Item</button>
            </form>
            <h3>Existing Menu Items</h3>
            <ul>
                <?php foreach ($menu_items as $item) : ?>
                    <li>
                        <?php echo htmlspecialchars($item['name']) . ' (' . htmlspecialchars($item['category_name']) . ') - $' . htmlspecialchars($item['price']); ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <button type="submit" name="delete_menu_item">Delete</button>
                        </form>
                        <button onclick="document.getElementById('edit-menu-item-<?php echo $item['id']; ?>').style.display='block'">Edit</button>
                        <form id="edit-menu-item-<?php echo $item['id']; ?>" method="post" style="display:none;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" required>
                            <label for="description">Description:</label>
                            <textarea name="description" required><?php echo htmlspecialchars($item['description']); ?></textarea>
                            <label for="price">Price:</label>
                            <input type="text" name="price" value="<?php echo htmlspecialchars($item['price']); ?>" required>
                            <label for="image">Image URL:</label>
                            <input type="text" name="image" value="<?php echo htmlspecialchars($item['image']); ?>" required>
                            <label for="category_id">Category:</label>
                            <select name="category_id" required>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category['id']; ?>" <?php if ($category['id'] == $item['category_id']) echo 'selected'; ?>><?php echo htmlspecialchars($category['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" name="edit_menu_item">Save</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section>
            <h2>Manage Reservations</h2>
            <h3>Existing Reservations</h3>
            <ul>
                <?php foreach ($reservations as $reservation) : ?>
                    <li>
                        <?php echo htmlspecialchars($reservation['name']) . ' - ' . htmlspecialchars($reservation['date']) . ' ' . htmlspecialchars($reservation['time']); ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                            <button type="submit" name="delete_reservation">Delete</button>
                        </form>
                        <button onclick="document.getElementById('edit-reservation-<?php echo $reservation['id']; ?>').style.display='block'">Edit</button>
                        <form id="edit-reservation-<?php echo $reservation['id']; ?>" method="post" style="display:none;">
                            <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?php echo htmlspecialchars($reservation['name']); ?>" required>
                            <label for="email">Email:</label>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($reservation['email']); ?>" required>
                            <label for="phone">Phone:</label>
                            <input type="tel" name="phone" value="<?php echo htmlspecialchars($reservation['phone']); ?>" required>
                            <label for="date">Date:</label>
                            <input type="date" name="date" value="<?php echo htmlspecialchars($reservation['date']); ?>" required>
                            <label for="time">Time:</label>
                            <input type="time" name="time" value="<?php echo htmlspecialchars($reservation['time']); ?>" required>
                            <label for="guests">Number of Guests:</label>
                            <input type="number" name="guests" value="<?php echo htmlspecialchars($reservation['guests']); ?>" required>
                            <button type="submit" name="edit_reservation">Save</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <section>
            <h2>Manage Reviews</h2>
            <h3>Existing Reviews</h3>
            <ul>
                <?php foreach ($reviews as $review) : ?>
                    <li>
                        <strong><?php echo htmlspecialchars($review['username']); ?></strong> on <strong><?php echo htmlspecialchars($review['menu_name']); ?></strong><br>
                        Rating: <?php echo htmlspecialchars($review['rating']); ?>/5<br>
                        Comment: <?php echo htmlspecialchars($review['comment']); ?><br>
                        Response: <?php echo htmlspecialchars($review['response']); ?><br>
                        <form method="post" action="admin.php">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <textarea name="response" required></textarea>
                            <button type="submit" name="respond_review">Respond</button>
                        </form>
                        <form method="post" action="admin.php">
                            <input type="hidden" name="review_id" value="<?php echo $review['id']; ?>">
                            <button type="submit" name="delete_review">Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>
</html>
