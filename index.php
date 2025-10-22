<?php
include 'db_connect.php';
include 'header.php';
?>

<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-color: #ffc107;">
            <div class="container d-flex align-items-center justify-content-center" style="min-height: 400px;">
                <div class="text-center text-dark">
                    <h1>Seasonal Offers</h1>
                    <p>Get the best deals this season!</p>
                    <a href="category.php" class="btn btn-dark">Shop Now</a>
                </div>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item" style="background-color: #dc3545;">
            <div class="container d-flex align-items-center justify-content-center" style="min-height: 400px;">
                <div class="text-center text-white">
                    <h1>Major Deals</h1>
                    <p>Unbeatable prices on top tech.</p>
                    <a href="category.php" class="btn btn-light">Shop Now</a>
                </div>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item" style="background-color: #212529;">
            <div class="container d-flex align-items-center justify-content-center" style="min-height: 400px;">
                <div class="text-center text-white">
                    <h1>Bold Tech Look</h1>
                    <p>Upgrade your setup today.</p>
                    <a href="category.php" class="btn btn-warning">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Deal of the Day -->
<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <h2 class="mb-4">Deal of the Day</h2>
        </div>
        <div class="col-md-6">
            <img src="https://via.placeholder.com/500" class="img-fluid" alt="Deal of the Day">
        </div>
        <div class="col-md-6">
            <h3>Special Discounted Product</h3>
            <p>This is a fantastic product at an unbeatable price. Don't miss out!</p>
            <h4 id="countdown" class="text-danger"></h4>
            <a href="product.php?id=2" class="btn btn-danger">View Deal</a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Featured Products</h2>
    <div class="row">
        <?php
        $stmt = $conn->prepare("SELECT * FROM products LIMIT 6");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $images = json_decode($row['images'], true);
            $first_image = !empty($images) ? $images[0] : 'https://via.placeholder.com/300';
            echo '
            <div class="col-md-4 mb-4">
                <div class="card product-card">
                    <img src="' . $first_image . '" class="card-img-top" alt="' . $row['name'] . '">
                    <div class="card-body">
                        <h5 class="card-title">' . $row['name'] . '</h5>
                        <p class="card-text">' . $row['brand'] . '</p>
                        <p class="card-text"><strong>$' . $row['price'] . '</strong> <s class="text-muted">$' . $row['original_price'] . '</s></p>
                        <a href="product.php?id=' . $row['id'] . '" class="btn btn-primary">View Details</a>
                    </div>
                    <div class="product-card-overlay">
                        <a href="#" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> Quick View</a>
                        <a href="#" class="btn btn-secondary btn-sm"><i class="fas fa-heart"></i> Wishlist</a>
                        <a href="#" class="btn btn-secondary btn-sm"><i class="fas fa-exchange-alt"></i> Compare</a>
                    </div>
                </div>
            </div>
            ';
        }
        ?>
    </div>
</div>

<!-- Promotional Banners -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card bg-dark text-white">
                <img src="https://via.placeholder.com/400x200" class="card-img" alt="Gaming PCs">
                <div class="card-img-overlay d-flex flex-column justify-content-end">
                    <h5 class="card-title">Gaming PCs</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white">
                <img src="https://via.placeholder.com/400x200" class="card-img" alt="RGB Accessories">
                <div class="card-img-overlay d-flex flex-column justify-content-end">
                    <h5 class="card-title">RGB Accessories</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-dark text-white">
                <img src="https://via.placeholder.com/400x200" class="card-img" alt="Cooling Solutions">
                <div class="card-img-overlay d-flex flex-column justify-content-end">
                    <h5 class="card-title">Cooling Solutions</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabbed Product Section -->
<div class="container mt-5">
    <ul class="nav nav-tabs" id="productTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="new-arrivals-tab" data-bs-toggle="tab" data-bs-target="#new-arrivals" type="button" role="tab" aria-controls="new-arrivals" aria-selected="true">New Arrivals</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="top-rated-tab" data-bs-toggle="tab" data-bs-target="#top-rated" type="button" role="tab" aria-controls="top-rated" aria-selected="false">Top Rated</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="best-deals-tab" data-bs-toggle="tab" data-bs-target="#best-deals" type="button" role="tab" aria-controls="best-deals" aria-selected="false">Best Deals</button>
        </li>
    </ul>
    <div class="tab-content" id="productTabsContent">
        <div class="tab-pane fade show active" id="new-arrivals" role="tabpanel" aria-labelledby="new-arrivals-tab">
            <div class="row mt-3">
                <?php
                $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 3");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $images = json_decode($row['images'], true);
                    $first_image = !empty($images) ? $images[0] : 'https://via.placeholder.com/300';
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="' . $first_image . '" class="card-img-top" alt="' . $row['name'] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['name'] . '</h5>
                                <p class="card-text">' . $row['brand'] . '</p>
                                <p class="card-text"><strong>$' . $row['price'] . '</strong></p>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="top-rated" role="tabpanel" aria-labelledby="top-rated-tab">
            <div class="row mt-3">
                <?php
                $stmt = $conn->prepare("SELECT * FROM products ORDER BY price DESC LIMIT 3");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $images = json_decode($row['images'], true);
                    $first_image = !empty($images) ? $images[0] : 'https://via.placeholder.com/300';
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="' . $first_image . '" class="card-img-top" alt="' . $row['name'] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['name'] . '</h5>
                                <p class="card-text">' . $row['brand'] . '</p>
                                <p class="card-text"><strong>$' . $row['price'] . '</strong></p>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
        <div class="tab-pane fade" id="best-deals" role="tabpanel" aria-labelledby="best-deals-tab">
            <div class="row mt-3">
                <?php
                $stmt = $conn->prepare("SELECT * FROM products ORDER BY original_price - price DESC LIMIT 3");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $images = json_decode($row['images'], true);
                    $first_image = !empty($images) ? $images[0] : 'https://via.placeholder.com/300';
                    echo '
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="' . $first_image . '" class="card-img-top" alt="' . $row['name'] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $row['name'] . '</h5>
                                <p class="card-text">' . $row['brand'] . '</p>
                                <p class="card-text"><strong>$' . $row['price'] . '</strong></p>
                            </div>
                        </div>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Special Offer Section -->
<div class="container-fluid mt-5 special-offer-section">
    <div class="container text-center text-white py-5">
        <h2>Gaming Week Special</h2>
        <p>Build your dream rig with our exclusive deals on gaming hardware.</p>
        <a href="category.php" class="btn btn-warning btn-lg">Explore Deals</a>
    </div>
</div>

<!-- Brand Showcase -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Featured Brands</h2>
    <div class="row">
        <div class="col-md-2 col-4 text-center">
            <img src="https://via.placeholder.com/100x50?text=ASUS" class="img-fluid" alt="ASUS">
        </div>
        <div class="col-md-2 col-4 text-center">
            <img src="https://via.placeholder.com/100x50?text=MSI" class="img-fluid" alt="MSI">
        </div>
        <div class="col-md-2 col-4 text-center">
            <img src="https://via.placeholder.com/100x50?text=Corsair" class="img-fluid" alt="Corsair">
        </div>
        <div class="col-md-2 col-4 text-center">
            <img src="https://via.placeholder.com/100x50?text=Logitech" class="img-fluid" alt="Logitech">
        </div>
        <div class="col-md-2 col-4 text-center">
            <img src="https://via.placeholder.com/100x50?text=Razer" class="img-fluid" alt="Razer">
        </div>
        <div class="col-md-2 col-4 text-center">
            <img src="https://via.placeholder.com/100x50?text=Intel" class="img-fluid" alt="Intel">
        </div>
    </div>
</div>

<!-- Expert Picks / Blog Section -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Expert Picks & Tech Blogs</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Blog Post 1">
                <div class="card-body">
                    <h5 class="card-title">The Ultimate Guide to Building a Gaming PC</h5>
                    <p class="card-text">A step-by-step guide for beginners.</p>
                    <a href="#" class="btn btn-outline-primary">Read More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Blog Post 2">
                <div class="card-body">
                    <h5 class="card-title">Top 5 Gaming Mice of 2024</h5>
                    <p class="card-text">Our expert picks for the best gaming mice.</p>
                    <a href="#" class="btn btn-outline-primary">Read More</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="Blog Post 3">
                <div class="card-body">
                    <h5 class="card-title">How to Choose the Right CPU</h5>
                    <p class="card-text">Understanding the difference between Intel and AMD.</p>
                    <a href="#" class="btn btn-outline-primary">Read More</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Countdown Timer
var countDownDate = new Date().setHours(23, 59, 59, 999);

var x = setInterval(function() {
    var now = new Date().getTime();
    var distance = countDownDate - now;

    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    document.getElementById("countdown").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown").innerHTML = "EXPIRED";
    }
}, 1000);
</script>

</body>
</html>
