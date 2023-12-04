<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="<?= BASE_URL. '/dashboard'; ?>" class="nav-link <?= segment(1) === 'dashboard' && segment(2) == "" ? 'active' : '' ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class=""></i>
                </p>
            </a>

        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'products' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-shopping-bag"></i>
                <p>
                    Products
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/dashboard/products/add" class="nav-link  <?= segment(2) === 'products' ? 'active' : '' ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/products/list" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/products/import" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Import Product</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link <?= segment(2) === 'products' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-shopping-bag"></i>
                <p>
                    Inventory
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/dashboard/products/add_stocks" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Stock</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/products/add_adjustments" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Quantity</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/products/quantity" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Quantity Adjustment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/products/stock" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Stock Counts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/products/count" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Count Stock</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                    Sales
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/dashboard/sales/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Sales</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/sales/list" class="nav-link">
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
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                    Purchases
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/document/purcheses/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Create Porchase Order</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/UI/icons.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List Porchase Order</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    Werehouses
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/dashboard/warehouse/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Warehouse</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/warehouse/list" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>List warehouse</p>
                    </a>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    Customer
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/dashboard/customer/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Customer</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/customer/view" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>View Customers</p>
                    </a>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    Employees
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/dashboard/employee/add" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Employee</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/dashboard/employee/views" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>View Employee</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                    Returns
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/tables/simple.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Simple Tables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/data.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>DataTables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/jsgrid.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>jsGrid</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                    Settings
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="pages/tables/simple.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Simple Tables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/data.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>DataTables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/jsgrid.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>jsGrid</p>
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
                    <a href="pages/tables/simple.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Simple Tables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/data.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>DataTables</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="pages/tables/jsgrid.html" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>jsGrid</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="/dashboard/logout" class="nav-link">
                <i class="nav-icon fas fa-power-off text-danger"></i>
                <p>Logout</p>
            </a>
        </li>
    </ul>
</nav>