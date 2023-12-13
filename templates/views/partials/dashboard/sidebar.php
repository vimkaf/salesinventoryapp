<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="<?= base_url('dashboard') ?>" class="nav-link <?= segment(1) === 'dashboard' && segment(2) == "" ? 'active' : '' ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class=""></i>
                </p>
            </a>

        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'products' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-shopping-basket"></i>
                <p>
                    Products
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/products/categories" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/products/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/products/list" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/products/import" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Import Product</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'inventory' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-boxes"></i>
                <p>
                    Inventory
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/inventory/add_stocks" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Stock</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/inventory/add_adjustments" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Quantity</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/inventory/quantity" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Quantity Adjustment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/inventory/stock_count" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stock Counts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/products/count" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Count Stock</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'sales' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-shopping-bag"></i>
                <p>
                    Sales
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/sales/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Sales</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/sales/list" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List Sales</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>POS Sales</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'purchases' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-box"></i>
                <p>
                    Purchases
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>document/purchases/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Create Porchase Order</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List Purchase Order</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'warehouses' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-building"></i>
                <p>
                    Warehouses
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/warehouse/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Warehouse</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/warehouse/list" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List warehouse</p>
                    </a>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'customer' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>
                    Customer
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/customer/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Customer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/customer/view" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>View Customers</p>
                    </a>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'employees' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>
                    Employees
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/employee/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Employee</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/employee/views" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>View Employee</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'settings' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                    Settings
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/settings/site" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Site</p>
                    </a>
                </li>

            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                    Reports
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>dashboard/reports" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sales</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/data.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stock</p>
                    </a>
                </li>

            </ul>
        </li>
        <li class="nav-item">
            <a href="<?= BASE_URL; ?>dashboard/logout" class="nav-link">
                <i class="nav-icon fas fa-power-off text-danger"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>