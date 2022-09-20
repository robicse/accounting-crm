<style>
    /*.treeview-menu li{*/
    /*    background-color: black;*/
    /*}*/
    .custom_li_bg{
        background-color: gray;
    }
</style>

<aside class="app-sidebar" style="background: url({{asset('backend/sidebar4.png')}})">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{!! asset('backend/user.png') !!} "
                                        alt="User Image" width="60px">
        <div>
            <p class="app-sidebar__user-name">{{ Auth::user()->roles[0]->name }}</p>
            <p class="app-sidebar__user-designation">Welcome To,<br/>{{ Auth::User()->name }}</p>
        </div>
    </div>
    <ul class="app-menu ">
        <li onclick="deletePost"><a class="app-menu__item {{Request ::is('home') ? ' active ' : ''}}" href="{!! URL::to('/home') !!}" ><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        @php
            //if(Auth::User()->getRoleNames()[0] == "Admin"){
            //if(Auth::User()->role=='1'){
        @endphp
        <li><a class="app-menu__item" href="{{ route('service.index') }}"><i class="app-menu__icon fa fa-folder-open"></i><span class="app-menu__label">Service </span><i class="treeview-indicator fa fa-angle-right"></i></a>
        </li>
        <li class="treeview{{Request::is('productCategories*')|| Request::is('free-products*') || Request::is('productBrands') || Request::is('productUnit') || Request::is('products*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">Products </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productCategories.index') }}"><i class="app-menu__icon fa fa-deviantart"></i><span class="app-menu__label">Product Category</span></a></li>
{{--                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productSubCategories.index') }}"><i class="app-menu__icon fa fa-codepen"></i><span class="app-menu__label">Product Sub Category</span></a></li>--}}
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productBrands.index') }}"><i class="app-menu__icon fa fa-bandcamp"></i><span class="app-menu__label">Product Brand</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productUnit.index') }}"><i class="app-menu__icon fa fa-bandcamp"></i><span class="app-menu__label">Product Unit</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('products.index') }}"><i class="app-menu__icon fa fa-dropbox"></i><span class="app-menu__label">Product</span></a></li>
                <li class="custom_li_bg" style="display: none"><a class="app-menu__item custom_li_a_position" href="{{ route('free-products.index') }}"><i class="app-menu__icon fa fa-dropbox"></i><span class="app-menu__label">Free Product</span></a></li>
            </ul>
        </li>
        <li class="treeview{{Request::is('party*')  ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">Customers </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position"  href="{{ route('party.index') }}"><i class="app-menu__icon fa fa-deviantart"></i><span class="app-menu__label">Customer List</span></a></li>
{{--                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position"  href="{!! URL::to('/supplier') !!}"><i class="app-menu__icon fa fa-dropbox"></i><span class="app-menu__label">Supplier List</span></a></li>--}}
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position"  href="{!! URL::to('/whole-sale') !!}"><i class="app-menu__icon fa fa-dropbox"></i><span class="app-menu__label">Whole Sale Customers </span></a></li>
            </ul>
        </li>
        <li><a class="app-menu__item"  href="{!! URL::to('/supplier') !!}"><i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">Supplier </span><i class="treeview-indicator fa fa-angle-right"></i></a>
        </li>
        <li><a class="app-menu__item"  href="{{ route('online_platform.index') }}"><i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">Online Platform </span><i class="treeview-indicator fa fa-angle-right"></i></a>
        </li>
        <li><a class="app-menu__item" href="{{ route('productPurchases.index') }}"><i class="app-menu__icon fa fa-cart-plus"></i><span class="app-menu__label">Stock In </span><i class="treeview-indicator fa fa-angle-right"></i></a>
        </li>


        <li class="treeview{{Request::is('productSales*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-arrow-down"></i><span class="app-menu__label">Sale </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productSales.index') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label"> List</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productSales.create') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Retail Sale Create</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productWholeSales.create') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">WholeSale Create</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productSales.customer.due') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Due List</span></a></li>
            </ul>
        </li>
        <li class="treeview{{Request::is('productSaleReturns*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-arrow-up"></i><span class="app-menu__label">Return Sale Product</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('returnable.sale.product') }}"><i class="app-menu__icon fa fa-circle-o"></i> <span class="app-menu__label">Create </span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productSaleReturns.index') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">List</span></a></li>
{{--                <li><a class="app-menu__item" href="{{ route('productSaleReturns.create') }}"><i class="app-menu__icon fas fa-users"></i> <span class="app-menu__label">Product Sale Create</span></a></li>--}}

            </ul>
        </li>
        <li class="treeview{{Request::is('productPurchaseReturns*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-arrow-up"></i><span class="app-menu__label">Return Purchase Product</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('returnable.purchase.product') }}"><i class="app-menu__icon fa fa-circle-o"></i> <span class="app-menu__label">Create </span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('productPurchaseReturns.index') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">List</span></a></li>
            </ul>
        </li>
{{--        <li class="treeview{{Request::is('officeCostingCategory*') || Request::is('expenses*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-toggle-down"></i><span class="app-menu__label">Office Costing </span><i class="treeview-indicator fa fa-angle-right"></i></a>--}}
{{--            <ul class="treeview-menu">--}}
{{--                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('officeCostingCategory.index') }}"><i class="app-menu__icon fa fa-circle-o"></i><span class="app-menu__label">Office Costing Category</span></a></li>--}}
{{--                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('expenses.index') }}"><i class="app-menu__icon fa fa-circle"></i><span class="app-menu__label">Expense</span></a></li>--}}
{{--            </ul>--}}
{{--        </li>--}}


        <li class="treeview{{Request::is('stock*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-sort-amount-asc"></i><span class="app-menu__label">Stock </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('stock-purchase.allStock') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">All Stock List</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('stock-purchase.index') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Purchase Stock List</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('stock.index' ) }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Sale Stock List</span></a></li>
{{--                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('stock.index') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Stock List</span></a></li>--}}
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('stock.summary.list') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Stock Summary</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('stock.low.list') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Stock Low</span></a></li>
            </ul>
        </li>
        <li class="treeview{{Request::is('transaction*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-signal"></i><span class="app-menu__label">Transaction </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('transaction.store') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Transaction Store</span></a></li>
{{--                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('transaction.index') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Transaction List</span></a></li>--}}
                <li class="custom_li_bg" style="display: none"><a class="app-menu__item custom_li_a_position" href="{{ route('transaction.lossProfit.store') }}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Loss/Profit</span></a></li>
            </ul>
        </li>
        <li class="treeview{{Request::is('deliveryService*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Delivery Service </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('deliveryService.index') }}"><i class="app-menu__icon fas fa-users"></i> <span class="app-menu__label">Delivery Service List</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('deliveryService.create') }}"><i class="app-menu__icon fas fa-users"></i> <span class="app-menu__label">Delivery Service Create</span></a></li>
            </ul>
        </li>
        <li class="treeview{{Request::is('stockTransfers*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-signal"></i><span class="app-menu__label">Stock Transfer  </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('stockTransfers.index') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">Stock Transfer List</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('stockTransfers.create') }}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Stock Transfer Create</span></a></li>
            </ul>
        </li>
        <li class="treeview{{Request::is('voucherType*') || Request::is('voucherType*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-laptop"></i><span class="app-menu__label">Voucher Types</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li  style="background-color: gray"><a class="app-menu__item"  href="{{ route('voucherType.index') }}"><span class="app-menu__label">List</span></a></li>
                <li  style="background-color: gray"><a class="app-menu__item"  href="{{ route('voucherType.create') }}"><span class="app-menu__label">Create</span></a></li>
            </ul>
        </li>
{{--        <li class="treeview{{Request::is('account/officeCostingCategory*') ||Request::is('account/coa_print*') || Request::is('account/coa_print*')|| Request::is('transaction*')|| Request::is('account/cashbook*')|| Request::is('account/trial-balance*')|| Request::is('account/credit-voucher*') || Request::is('account/debit-voucher*') || Request::is('account/generalledger*')  ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-file-text-o"></i> <span class="app-menu__label">Accounts </span><i class="treeview-indicator fa fa-angle-right"></i></a>--}}
{{--            <ul class="treeview-menu">--}}
{{--                <li style="background-color: gray"><a class="app-menu__item" href="{{ route('officeCostingCategory.index') }}"><span class="app-menu__label">Office Costing Category</span></a></li>--}}
{{--                <li style="background-color: gray"><a class="app-menu__item " href="{{ route('expenses.index') }}"><span class="app-menu__label">Expense</span></a></li>--}}
{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{{ route('posting.create') }}"><span class="app-menu__label">Posting</span></a></li>--}}
{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{{ route('posting.index') }}"><span class="app-menu__label">Posting List</span></a></li>--}}
{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{!! URL::to('/account/cashbook') !!}"><span class="app-menu__label">Cash Book</span></a></li>--}}
{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{{ route('account.generalledger') }}"><span class="app-menu__label">Ledger</span></a></li>--}}
{{--                --}}{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{{ route('account.debit.voucher') }}"><span class="app-menu__label">Debit Voucher</span></a></li>--}}
{{--                --}}{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{{ route('account.credit.voucher') }}"><span class="app-menu__label">Credit Voucher</span></a></li>--}}
{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{!! URL::to('/account/trial-balance') !!}"><span class="app-menu__label">Trial Balance</span></a></li>--}}
{{--                --}}{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{!! URL::to('/account/balance-sheet') !!}"><span class="app-menu__label">Balance Sheet</span></a></li>--}}
{{--                <li><a class="treeview-item{{Request::is('accounts')||Request::is('accounts/*') ? ' active': ''}}" href="{!! route('accounts.index') !!}">Chart Of Accounts</a></li>--}}
{{--                <li  style="background-color: gray"><a class="app-menu__item" href="{{ route('account.coa_print') }}"><span class="app-menu__label">COA Prints</span></a></li>--}}

{{--            </ul>--}}
{{--        </li>--}}
        <li class="treeview{{Request::is('ChartOfAccount*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-signal"></i><span class="app-menu__label"> Accounts </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('ChartOfAccount.index') }}"><i class="app-menu__icon fa fa-circle"></i> <span class="app-menu__label">COA</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('Ledger.index') }}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Create Ledger</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('postingForm.index') }}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Voucher Posting</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('account.general.ledger') }}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">General Ledger</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('account.cash.book') }}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Cash Book</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('account.bank.book') }}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Bank Book</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{{ route('account.receipt.payment') }}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Receipt Payment</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{!! URL::to('/account/trial/balance') !!}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Trial Balance</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{!! URL::to('/account/income/statement') !!}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Income Statement</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{!! URL::to('/account/equity') !!}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Changes In Equity</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{!! URL::to('/account/balance/sheet/') !!}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Balance Sheet</span></a></li>
                <li class="custom_li_bg"><a class="app-menu__item custom_li_a_position" href="{!! URL::to('/account/cash-flow/') !!}"><i class="app-menu__icon fas fa fa-circle"></i> <span class="app-menu__label">Cash Flow</span></a></li>
            </ul>
        </li>
        <hr/>
        <li><a class="app-menu__item" href="{{ route('monthly.services') }}"><i class="app-menu__icon fa fa-window-restore"></i><span class="app-menu__label">Monthly Service</span></a></li>
        <li><a class="app-menu__item" href="{{ route('completed.services') }}"><i class="app-menu__icon fa fa-window-restore"></i><span class="app-menu__label">Completed Service</span></a></li>
        <li><a class="app-menu__item" href="{{ route('offers.index') }}"><i class="app-menu__icon fa fa-window-restore"></i><span class="app-menu__label">Offers</span></a></li>
        <li><a class="app-menu__item" href="{{ route('customer_complain.index') }}"><i class="app-menu__icon fa fa-window-restore"></i><span class="app-menu__label">Customer Support</span></a></li>
        <li><a class="app-menu__item" href="{{ route('stores.index') }}"><i class="app-menu__icon fa fa-window-restore"></i><span class="app-menu__label">Stores</span></a></li>
        <li><a class="app-menu__item" {{Request ::is('/users')  ? ' active ' : ''}} href="{{ route('users.index') }}"><i class="app-menu__icon fas fa-users"></i><span class="app-menu__label">Users</span></a></li>
        <li class="treeview{{Request::is('roles*') ? ' is-expanded': ''}}"><a class="app-menu__item" href="{{ route('roles.index') }}"><i class="app-menu__icon fa fa-circle"></i><span class="app-menu__label">Role Permissions </span><i class="treeview-indicator fa fa-angle-right"></i></a>
        </li>
        @php
            //}
        @endphp
    </ul>
</aside>
