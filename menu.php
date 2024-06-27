<?php
session_start();
include 'db_connection.php';

function fetch_categories($mysqli) {
    $result = $mysqli->query("SELECT * FROM categories");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function fetch_menu_items($mysqli) {
    $result = $mysqli->query("SELECT menu.*, categories.name as category_name FROM menu JOIN categories ON menu.category_id = categories.id");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function fetch_reviews($mysqli, $menu_id) {
    $stmt = $mysqli->prepare("SELECT reviews.*, users.username FROM reviews JOIN users ON reviews.user_id = users.id WHERE menu_id = ?");
    $stmt->bind_param('i', $menu_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

$categories = fetch_categories($mysqli);
$menu_items = fetch_menu_items($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu - Grill Restaurant</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php
require_once("./nav.php");
?>
    <main>
        <section>
            <h2>Menu</h2>
            <div id="category-filter">
                <button onclick="filterMenu('all')">All</button>
                <?php foreach ($categories as $category) : ?>
                    <button onclick="filterMenu('<?php echo $category['id']; ?>')"><?php echo htmlspecialchars($category['name']); ?></button>
                <?php endforeach; ?>
            </div>
            <div id="menu-items">
                <?php foreach ($menu_items as $item) : ?>
                    <div class="menu-item" id="menu-item-<?php echo $item['id']; ?>" data-category="<?php echo $item['category_id']; ?>">
                        <img src="images/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="text-white"><?php echo htmlspecialchars($item['description']); ?></p>
                        <p>Price: $<?php echo htmlspecialchars($item['price']); ?></p>
                        
                        <!-- Display Reviews -->
                        <div class="reviews" id="reviews-<?php echo $item['id']; ?>">
                            <h4>Reviews:</h4>
                            <?php 
                            $reviews = fetch_reviews($mysqli, $item['id']);
                            foreach ($reviews as $review) : ?>
                                <div class="review">
                                    <p><strong><?php echo htmlspecialchars($review['username']); ?>:</strong> <?php echo htmlspecialchars($review['comment']); ?> (Rating: <?php echo htmlspecialchars($review['rating']); ?>/5)</p>
                                    <?php if ($review['response']) : ?>
                                        <p><strong>Admin Response:</strong> <?php echo htmlspecialchars($review['response']); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Review Form -->
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form class="review-form" id="review-form-<?php echo $item['id']; ?>" method="post" action="submit_review.php">
                                <input type="hidden" name="menu_id" value="<?php echo $item['id']; ?>">
                                <label for="rating">Rating (1-5):</label>
                                <input type="number" name="rating" min="1" max="5" required>
                                <label for="comment">Comment:</label>
                                <textarea name="comment" required></textarea>
                                <button type="submit">Submit Review</button>
                            </form>
                        <?php else: ?>
                            <p>You need to be logged in to leave a review.</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        &copy; 2023 Grill Restaurant
    </footer>
    <script src="js/main.js"></script>
</body>
</html>
