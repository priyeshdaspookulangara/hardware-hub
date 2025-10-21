
from playwright.sync_api import sync_playwright

with sync_playwright() as p:
    browser = p.chromium.launch()
    page = browser.new_page()

    # 1. Login
    page.goto("http://localhost:8000/admin.php")
    page.get_by_label("Username").fill("admin")
    page.get_by_label("Password").fill("admin")
    page.get_by_role("button", name="Login").click()

    # 2. Add a new category
    page.get_by_label("Category Name").fill("New Test Category")
    page.get_by_role("button", name="Add Category").click()
    page.screenshot(path="jules-scratch/verification/admin_page_after_add.png")

    # 3. Verify the new category on the category page
    page.goto("http://localhost:8000/category.php")
    page.screenshot(path="jules-scratch/verification/category_page_with_new_category.png")

    browser.close()
