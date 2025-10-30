<?php
$page_title = "Manage Category Properties";
include 'includes/header.php';

// Fetch all categories for the dropdown
$sql_fetch_cats = "SELECT * FROM categories ORDER BY name ASC";
$result_cats = mysqli_query($link, $sql_fetch_cats);
$categories = [];
if ($result_cats) {
    while ($row = mysqli_fetch_assoc($result_cats)) {
        $categories[] = $row;
    }
}

// Handle form submission for adding a new property
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_property'])) {
    $category_id = $_POST['category_id'];
    $property_name = trim($_POST['property_name']);
    if (!empty($category_id) && !empty($property_name)) {
        $cat_id = mysqli_real_escape_string($link, $category_id);
        $prop_name = mysqli_real_escape_string($link, $property_name);
        $sql = "INSERT INTO category_properties (category_id, property_name) VALUES ('$cat_id', '$prop_name')";
        if (mysqli_query($link, $sql)) {
            echo '<div class="alert alert-success">Property added successfully.</div>';
        } else {
            echo '<div class="alert alert-danger">Error: ' . mysqli_error($link) . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger">Both category and property name are required.</div>';
    }
}

$selected_category_id = isset($_GET['category_id_view']) ? $_GET['category_id_view'] : null;
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title; ?></li>
    </ol>
</nav>

<h1 class="mt-4"><?php echo $page_title; ?></h1>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Add Property to a Category</div>
            <div class="card-body">
                <form method="POST" action="category_properties.php">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select a category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="property_name" class="form-label">Property Name</label>
                        <input type="text" class="form-control" id="property_name" name="property_name" required>
                    </div>
                    <button type="submit" name="add_property" class="btn btn-primary">Add Property</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">View Properties by Category</div>
            <div class="card-body">
                <form method="GET" action="category_properties.php">
                    <div class="input-group mb-3">
                        <select class="form-select" name="category_id_view" onchange="this.form.submit()">
                            <option value="">Select a category to view its properties</option>
                            <?php foreach ($categories as $category): ?>
                                <?php $selected = ($category['id'] == $selected_category_id) ? 'selected' : ''; ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>

                <?php if ($selected_category_id): ?>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Property Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_props = "SELECT * FROM category_properties WHERE category_id = " . mysqli_real_escape_string($link, $selected_category_id);
                            $result_props = mysqli_query($link, $sql_props);
                            if ($result_props && mysqli_num_rows($result_props) > 0):
                                while ($prop = mysqli_fetch_assoc($result_props)):
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($prop['property_name']); ?></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-danger">Delete</a>
                                    </td>
                                </tr>
                            <?php
                                endwhile;
                            else:
                            ?>
                                <tr>
                                    <td colspan="2" class="text-center">No properties found for this category.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
