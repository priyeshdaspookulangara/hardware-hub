
import requests
from playwright.sync_api import sync_playwright, expect

def reset_database():
    """Calls the reset_db.php script to clear and re-initialize the database."""
    # The reset_db.php file no longer exists, so we will just run the migration
    url = "http://localhost:8000/migrate.php"
    try:
        response = requests.get(url)
        response.raise_for_status()
        print("Database migrated successfully.")
    except requests.exceptions.RequestException as e:
        print(f"Error migrating database: {e}")
        raise

def run_verification(playwright):
    reset_database()

    browser = playwright.chromium.launch()
    context = browser.new_context()
    page = context.new_page()

    try:
        # 1. Log in to the admin panel
        page.goto("http://localhost:8000/login.php")

        page.get_by_label("Username").fill("admin")
        page.get_by_label("Password").fill("admin")
        page.get_by_role("button", name="Login").click()

        # Expect to be redirected to the new dashboard
        expect(page).to_have_url("http://localhost:8000/admin/dashboard.php")
        print("Logged in successfully and redirected to new dashboard.")

        # 2. Verify Dashboard page
        expect(page.get_by_role("heading", name="Dashboard")).to_be_visible()
        page.screenshot(path="jules-scratch/verification/01_dashboard.png")
        print("Dashboard screenshot taken.")

        # 3. Verify Categories page
        page.get_by_role("link", name="Categories").click()
        expect(page).to_have_url("http://localhost:8000/admin/categories.php")
        expect(page.get_by_role("heading", name="Manage Categories")).to_be_visible()
        page.screenshot(path="jules-scratch/verification/02_categories.png")
        print("Categories screenshot taken.")

        # 4. Verify Category Properties page
        page.get_by_role("link", name="Category Properties").click()
        expect(page).to_have_url("http://localhost:8000/admin/category_properties.php")
        expect(page.get_by_role("heading", name="Manage Category Properties")).to_be_visible()
        page.screenshot(path="jules-scratch/verification/03_category_properties.png")
        print("Category Properties screenshot taken.")

        # 5. Verify Products page
        page.get_by_role("link", name="Products").click()
        expect(page).to_have_url("http://localhost:8000/admin/products.php")
        expect(page.get_by_role("heading", name="Manage Products")).to_be_visible()
        page.screenshot(path="jules-scratch/verification/04_products.png")
        print("Products screenshot taken.")

        # 6. Verify Add Product page
        page.get_by_role("link", name="Add New Product").click()
        expect(page).to_have_url("http://localhost:8000/admin/product_form.php")
        expect(page.get_by_role("heading", name="Add New Product")).to_be_visible()
        page.screenshot(path="jules-scratch/verification/05_add_product.png")
        print("Add Product screenshot taken.")

        # 7. Verify Orders page
        page.get_by_role("link", name="Orders").click()
        expect(page).to_have_url("http://localhost:8000/admin/orders.php")
        expect(page.get_by_role("heading", name="Manage Orders")).to_be_visible()
        page.screenshot(path="jules-scratch/verification/06_orders.png")
        print("Orders screenshot taken.")

    finally:
        browser.close()

with sync_playwright() as playwright:
    run_verification(playwright)
