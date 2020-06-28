<div class="navbar-default sidebar" role="navigation" style="background-color:#545454;">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <img src="{{ asset('admin/images/logo.jpg') }}" alt="" width="200px" style="margin-left:20px;"/>
            </li>
            <li>
                <a href="{{ url('dashboard') }}" class="active"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-cubes"></i>&nbsp;Products<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('product_status') }}">Product Status</a>
                    </li>
                    <li>
                        <a href="{{ url('product_list') }}">Product List</a>
                    </li>
                    <li>
                        <a href="{{ url('product_category') }}">Product Category </a>
                    </li>
                    <li>
                        <a href="{{ url('add_product') }}">Add New Product</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-bookmark"></i>&nbsp;Suppliers<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('supplier_payment') }}">Supplier Payments List</a>
                    </li>
                    <li>
                        <a href="{{ url('supplier_list') }}">Supplier List </a>
                    </li>
                    <li>
                        <a href="{{ url('add_supplier') }}">Add New Supplier</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-users"></i>&nbsp;Clients<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('client_payment') }}">Clients Payments</a>
                    </li>
                    <li>
                        <a href="{{ url('client_payment_list') }}">Clients Payment List </a>
                    </li>
                    <li>
                        <a href="{{ url('client_list') }}">Clients List </a>
                    </li>
                    <li>
                        <a href="{{ url('add_client') }}">Add New Client</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-shopping-cart"></i>&nbsp;Purchase<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('purchase_entry') }}">Purchase Entry</a>
                    </li>
                    <li>
                        <a href="{{ url('purchase_list') }}">Purchase List</a>
                    </li>
                    <li>
                        <a href="{{ url('purchase_return') }}">Purchase Return</a>
                    </li>
                    <li>
                        <a href="{{ url('purchase_return_list') }}">Purchase Return List</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-files-o fa-fw"></i>&nbsp;Quotation<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('quotation_input') }}">Quotation Input</a>
                    </li>
                    <li>
                        <a href="{{ url('quotation_list') }}">Quotation List</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i>&nbsp;Sale<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('create_sell') }}">Create Sale</a>
                    </li>
                    <li>
                        <a href="{{ url('sale_list') }}">Sale List</a>
                    </li>
                    <li>
                        <a href="{{ url('sale_return') }}">Sale Return</a>
                    </li>
                    <li>
                        <a href="{{ url('sale_return_list') }}">Sales Return List</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-wrench fa-fw"></i> Customer Support<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('call_entry') }}">Call Entry </a>
                    </li>
                    <li>
                        <a href="{{ url('call_entry_report') }}">Call Entry Report</a>
                    </li>
                    <li>
                        <a href="{{ url('complain_entry') }}">Complain Entry </a>
                    </li>
                    <li>
                        <a href="{{ url('complain_report') }}">Complain Report </a>
                    </li>

                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-calculator"></i> Expenses <span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="{{ url('create_expense') }}">Create New Expense</a>
                    </li>
                    <li>
                        <a href="{{ url('expense_list') }}">Expense Lists</a>
                    </li>
                    <li>
                        <a href="{{ url('expense_search') }}">Expense Search</a>
                    </li>
                    <li>
                        <a href="{{ url('expense_type') }}">Create Expense Type </a>
                    </li>
                    <li>
                        <a href="{{ url('create_project') }}">Create Project </a>
                    </li>
                </ul>
                <!-- /.nav-third-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-print"></i>&nbsp;Reports<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('purchase_report') }}">Show Purchase Reports</a>
                    </li>
                    <li>
                        <a href="{{ url('invoice_report') }}">Show Invoice Reports</a>
                    </li>
                    <li>
                        <a href="{{ url('merge_quotation_bill') }}">Merge Quotation Bill </a>
                    </li>
                    <li>
                        <a href="{{ url('cheque_manager') }}">Check Manager </a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
            <li>
                <a href="#"><i class="fa fa-pie-chart"></i>&nbsp;Ledger<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('client_ledger') }}">Client Ledger</a>
                    </li>
                    <li>
                        <a href="{{ url('supplier_ledger') }}">Supplier Ledger</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>



            <li>
                <a href="{{ url('settings') }}"><i class="fa fa-cog"></i> Setting<span class="fa arrow"></span></a>
                <!-- /.nav-second-level -->
            </li>

        </ul>

    </div>
</div>