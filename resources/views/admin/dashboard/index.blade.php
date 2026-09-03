@extends('admin.layouts.app')
@section('title', 'Dashboard | Constant Emails')
@push('styles')

@endpush

@section('content')
    <div class="page-header">
        <div class="page-title">
            <h3>Dashboard</h3>
        </div>
    </div>


    <div class="row layout-spacing ">

        <div class="col-xl-3 mb-xl-0 col-lg-6 mb-4 col-md-6 col-sm-6">
            <div class="widget-content-area  data-widgets br-4">
                <div class="widget  t-sales-widget">
                    <div class="media">
                        <div class="icon ml-2">
                            <i class="flaticon-line-chart"></i>
                        </div>
                        <div class="media-body text-right">
                            <p class="widget-text mb-0">Sales</p>
                            <p class="widget-numeric-value">98,225</p>
                        </div>
                    </div>
                    <p class="widget-total-stats mt-2">94% New Sales</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 mb-xl-0 col-lg-6 mb-4 col-md-6 col-sm-6">
            <div class="widget-content-area  data-widgets br-4">
                <div class="widget  t-order-widget">
                    <div class="media">
                        <div class="icon ml-2">
                            <i class="flaticon-cart-bag"></i>
                        </div>
                        <div class="media-body text-right">
                            <p class="widget-text mb-0">Orders</p>
                            <p class="widget-numeric-value">24,017</p>
                        </div>
                    </div>
                    <p class="widget-total-stats mt-2">552 New Orders</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-sm-0 mb-4">
            <div class="widget-content-area  data-widgets br-4">
                <div class="widget  t-customer-widget">
                    <div class="media">
                        <div class="icon ml-2">
                            <i class="flaticon-user-11"></i>
                        </div>
                        <div class="media-body text-right">
                            <p class="widget-text mb-0">Customers</p>
                            <p class="widget-numeric-value">92,251</p>
                        </div>
                    </div>
                    <p class="widget-total-stats mt-2">390 New Customers</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">

            <div class="widget-content-area  data-widgets br-4">
                <div class="widget  t-income-widget">
                    <div class="media">
                        <div class="icon ml-2">
                            <i class="flaticon-money"></i>
                        </div>
                        <div class="media-body text-right">
                            <p class="widget-text mb-0">Income</p>
                            <p class="widget-numeric-value">9.5 M</p>
                        </div>
                    </div>
                    <p class="widget-total-stats mt-2">$2.1 M This Week</p>
                </div>
            </div>
        </div>

    </div>



    <div class="row">

        <div class="col-xl-8 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area monthly-chart  br-4">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-2 col-12  align-self-center">
                        <h3>Statistics</h3>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-10 col-12 mt-sm-0 mt-3">
                        <ul class="nav justify-content-sm-end justify-content-center monthly-chart-tab nav-pills"
                            id="monthly-chart" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="monthly-chart-weekly-tab" data-toggle="pill"
                                    href="#monthly-chart-weekly" role="tab" aria-controls="monthly-chart-weekly"
                                    aria-selected="true">Weekly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="monthly-chart-monthly-tab" data-toggle="pill"
                                    href="#monthly-chart-monthly" role="tab" aria-controls="monthly-chart-monthly"
                                    aria-selected="true">Monthly</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="monthly-chart-yearly-tab" data-toggle="pill"
                                    href="#monthly-chart-yearly" role="tab" aria-controls="monthly-chart-yearly"
                                    aria-selected="false">Yearly</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 mt-3">
                        <div class="tab-content" id="monthly-chartContent">
                            <div class="tab-pane fade show active" id="monthly-chart-weekly" role="tabpanel"
                                aria-labelledby="monthly-chart-weekly-tab">
                                <div class="v-pv-weekly" style="height: 300px; width: 100%; margin-top: 30px;"></div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row mt-3">
                                        <div
                                            class="col-lg-5 col-md-5 col-sm-5 col-12 text-sm-right text-center mb-3 mr-sm-3 px-xl-0">
                                            <div class="d-flex justify-content-sm-end  justify-content-center">
                                                <div class="d-m-visitors data-marker align-self-center"></div>
                                                <span class="visitors">Visitors : 9,823</span>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-5 col-md-5 col-sm-5 col-12 text-sm-left text-center mb-3 ml-sm-3 px-xl-0">
                                            <div class="d-flex justify-content-sm-start  justify-content-center">
                                                <div class="d-m-page-view data-marker align-self-center"></div>
                                                <span class="page-view">Pageviews : 21,655</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="monthly-chart-monthly" role="tabpanel"
                                aria-labelledby="monthly-chart-monthly-tab">
                                <div class="v-pv-monthly" style="height: 300px; width: 100%; margin-top: 30px;"></div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row mt-3">
                                        <div
                                            class="col-lg-5 col-md-5 col-sm-5 col-12 text-sm-right text-center mb-3 mr-sm-3 px-xl-0">
                                            <div class="d-flex justify-content-sm-end  justify-content-center">
                                                <div class="d-m-visitors data-marker data-marker-success align-self-center">
                                                </div>
                                                <span class="visitors">Visitors : 19,823</span>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-5 col-md-5 col-sm-5 col-12 text-sm-left text-center mb-3 ml-sm-3 px-xl-0">
                                            <div class="d-flex justify-content-sm-start  justify-content-center">
                                                <div
                                                    class="d-m-page-view data-marker data-marker-secondary align-self-center">
                                                </div>
                                                <span class="page-view">Pageviews : 61,655</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="monthly-chart-yearly" role="tabpanel"
                                aria-labelledby="monthly-chart-yearly-tab">
                                <div class="v-pv-yearly" style="height: 300px; width: 100%; margin-top: 30px;"></div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="row mt-3">
                                        <div
                                            class="col-lg-5 col-md-5 col-sm-5 col-12 text-sm-right text-center mb-3 mr-sm-3 px-xl-0">
                                            <div class="d-flex justify-content-sm-end  justify-content-center">
                                                <div class="d-m-visitors data-marker data-marker-success align-self-center">
                                                </div>
                                                <span class="visitors">Visitors : 80,823</span>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-5 col-md-5 col-sm-5 col-12 text-sm-left text-center mb-3 ml-sm-3 px-xl-0">
                                            <div class="d-flex justify-content-sm-start  justify-content-center">
                                                <div
                                                    class="d-m-page-view data-marker data-marker-secondary align-self-center">
                                                </div>
                                                <span class="page-view">Pageviews : 1,21,655</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-12 col-sm-12 col-12 layout-spacing">
            <div class="statbox widget box">
                <div class="widget-header ">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Revenue and Profit</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area  monthly-profit-chart">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-12 mt-3">
                                    <div class="s-r mx-auto" style="height: 300px; width: 100%; max-width: 275px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-12 mt-2 mb-2">
                            <div class="row mt-4">
                                <div class="col-lg-6 col-md-6 col-6 px-xl-0 text-right">
                                    <div class="d-flex justify-content-end">
                                        <div class="d-m-revenue data-marker align-self-center"></div>
                                        <span class="page-view mr-sm-3">Revenue</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-6 px-xl-0 text-left">
                                    <div class="d-flex justify-content-start">
                                        <div class="d-m-profit data-marker align-self-center"></div>
                                        <span class="page-view">Profit</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="statbox widget box">
                <div class="widget-header ">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>New Packages</h4>
                        </div>
                    </div>
                </div>

                <div class="widget-content-area ">

                    <div class="table-responsive new-products">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="form-check-column text-center">
                                        <label for="checkAll"
                                            class="new-control new-checkbox new-checkbox-rounded checkbox-primary pb-2">
                                            <input type="checkbox" id="checkAll" class="new-control-input">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </th>
                                    <th>Package</th>
                                    <th>Type</th>
                                    <th>SKU</th>
                                    <th class="text-center">Quantity</th>
                                    <th>Image</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input chkbox">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Camera</td>
                                    <td><span class="badge badge-info badge-pill">Simple</span></td>
                                    <td>#0001</td>
                                    <td class="text-center">1</td>
                                    <td>
                                        <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" class="img-fluid"
                                            alt="img-1" style="border-color: #3862f5;">
                                    </td>
                                    <td class="text-center">$848.95</td>
                                    <td class="text-center">
                                        <div class="toolbar">
                                            <div class="toolbar-toggle">...</div>
                                            <ul class="toolbar-dropdown animated fadeInUp table-controls list-inline">
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="View"><i
                                                            class="flaticon-view-3"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Edit"><i
                                                            class="flaticon-edit-5"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Remove"><i
                                                            class="flaticon-delete-6"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input chkbox">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Mobile</td>
                                    <td><span class="badge badge-info badge-pill">Simple</span></td>
                                    <td>#0002</td>
                                    <td class="text-center">1</td>
                                    <td>
                                        <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" class="img-fluid"
                                            alt="img-1" style="border-color: #07e0c4;">
                                    </td>
                                    <td class="text-center">$529.95</td>
                                    <td class="text-center">
                                        <div class="toolbar">
                                            <div class="toolbar-toggle">...</div>
                                            <ul class="toolbar-dropdown animated fadeInUp table-controls list-inline">
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="View"><i
                                                            class="flaticon-view-3"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Edit"><i
                                                            class="flaticon-edit-5"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Remove"><i
                                                            class="flaticon-delete-6"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input chkbox">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Windows 10</td>
                                    <td><span class="badge badge-success badge-pill">Digital</span></td>
                                    <td>#0003</td>
                                    <td class="text-center">3</td>
                                    <td>
                                        <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" class="img-fluid"
                                            alt="img-1" style="border-color: #00b1f4;">
                                    </td>
                                    <td class="text-center">$1584.00</td>
                                    <td class="text-center">
                                        <div class="toolbar">
                                            <div class="toolbar-toggle">...</div>
                                            <ul class="toolbar-dropdown animated fadeInUp table-controls list-inline">
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="View"><i
                                                            class="flaticon-view-3"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Edit"><i
                                                            class="flaticon-edit-5"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Remove"><i
                                                            class="flaticon-delete-6"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input chkbox">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Watch</td>
                                    <td><span class="badge badge-info badge-pill">Simple</span></td>
                                    <td>#0004</td>
                                    <td class="text-center">5</td>
                                    <td>
                                        <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" class="img-fluid"
                                            alt="img-1" style="border-color: #f8538d;">
                                    </td>
                                    <td class="text-center">$595.99</td>
                                    <td class="text-center">
                                        <div class="toolbar">
                                            <div class="toolbar-toggle">...</div>
                                            <ul class="toolbar-dropdown animated fadeInUp table-controls list-inline">
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="View"><i
                                                            class="flaticon-view-3"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Edit"><i
                                                            class="flaticon-edit-5"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Remove"><i
                                                            class="flaticon-delete-6"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input chkbox">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Drone</td>
                                    <td><span class="badge badge-info badge-pill">Simple</span></td>
                                    <td>#0005</td>
                                    <td class="text-center">1</td>
                                    <td>
                                        <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" class="img-fluid"
                                            alt="img-1" style="border-color: #ffbb44;">
                                    </td>
                                    <td class="text-center">$58.00</td>
                                    <td class="text-center">
                                        <div class="toolbar">
                                            <div class="toolbar-toggle">...</div>
                                            <ul class="toolbar-dropdown animated fadeInUp table-controls list-inline">
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="View"><i
                                                            class="flaticon-view-3"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Edit"><i
                                                            class="flaticon-edit-5"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Remove"><i
                                                            class="flaticon-delete-6"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input chkbox">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Sunglasses</td>
                                    <td><span class="badge badge-secondary badge-pill">Bundled</span></td>
                                    <td>#0006</td>
                                    <td class="text-center">6</td>
                                    <td>
                                        <img src="{{  asset('assets/admin/assets/img/90x90.jpg') }}" class="img-fluid"
                                            alt="img-1" style="border-color: #25d5e4;">
                                    </td>
                                    <td class="text-center">$123.00</td>
                                    <td class="text-center">
                                        <div class="toolbar">
                                            <div class="toolbar-toggle">...</div>
                                            <ul class="toolbar-dropdown animated fadeInUp table-controls list-inline">
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="View"><i
                                                            class="flaticon-view-3"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Edit"><i
                                                            class="flaticon-edit-5"></i></a>
                                                </li>
                                                <li class="list-inline-item"><a href="javascript:void(0);"
                                                        class="bs-tooltip" data-original-title="Remove"><i
                                                            class="flaticon-delete-6"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="pagination-section">
                        <ul class="pagination pagination-style-1 pagination-rounded justify-content-end mt-3 mb-3">
                            <li><a href="javascript:void(0);">«</a></li>
                            <li><a href="javascript:void(0);">1</a></li>
                            <li><a href="javascript:void(0);">2</a></li>
                            <li><a href="javascript:void(0);">3</a></li>
                            <li><a href="javascript:void(0);">4</a></li>
                            <li><a href="javascript:void(0);">5</a></li>
                            <li><a href="javascript:void(0);">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-xl-6 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area event-calendar p-0  h-100 br-4">
                <div class="calendar"></div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="top-searches widget-content-area p-0 widget-content-container  h-100 br-4">
                <div class="col-lg-12 col-md-12 col-12 map-title">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-6">
                            <p class="mb-4 mt-2">Top Searches</p>
                        </div>
                    </div>
                </div>
                <div class="child-content">
                    <div id="world-map" style="height: 435px; max-height: 100%;"></div>
                    <div class="world-map-section">
                        <div class="">
                            <div class="table-responsive top-search-scroll">
                                <table class="table table-highlight-head">
                                    <thead>
                                        <tr>
                                            <th class="align-center">
                                                <div class="d-flex justify-content-center">
                                                    <div class="d-m-data-1 data-marker align-self-center"></div>
                                                    <span class="page-view mr-sm-3">USA</span>
                                                </div>
                                            </th>
                                            <th class="align-center">
                                                <div class="d-flex justify-content-center">
                                                    <div class="d-m-data-2 data-marker align-self-center"></div>
                                                    <span class="page-view mr-sm-3">Australia</span>
                                                </div>
                                            </th>
                                            <th class="align-center">
                                                <div class="d-flex justify-content-center">
                                                    <div class="d-m-data-3 data-marker align-self-center"></div>
                                                    <span class="page-view mr-sm-3">Spain</span>
                                                </div>
                                            </th>
                                            <th class="align-center">
                                                <div class="d-flex justify-content-center">
                                                    <div class="d-m-data-4 data-marker align-self-center"></div>
                                                    <span class="page-view mr-sm-3">France</span>
                                                </div>
                                            </th>
                                            <th class="align-center">
                                                <div class="d-flex justify-content-center">
                                                    <div class="d-m-data-5 data-marker align-self-center"></div>
                                                    <span class="page-view mr-sm-3">India</span>
                                                </div>
                                            </th>
                                            <th class="align-center">
                                                <div class="d-flex justify-content-center">
                                                    <div class="d-m-data-6 data-marker align-self-center"></div>
                                                    <span class="page-view mr-sm-3">Other</span>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-center data-value-1">55%</td>
                                            <td class="align-center data-value-2">30%</td>
                                            <td class="align-center data-value-3">10%</td>
                                            <td class="align-center data-value-4">4%</td>
                                            <td class="align-center data-value-5">0.6%</td>
                                            <td class="align-center data-value-6">0.4%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8 col-md-8 col-12 layout-spacing">
            <div class="statbox widget box box-shadow latest-invoice ">
                <div class="widget-header ">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Latest Invoice</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content-area ">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="form-check-column text-center">
                                        <label for="invoiceAll" class="new-control new-checkbox checkbox-primary pb-2">
                                            <input type="checkbox" id="invoiceAll" class="new-control-input">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </th>
                                    <th>Package</th>
                                    <th>Invoice no.</th>
                                    <th>Date</th>
                                    <th class="text-center">Amount</th>
                                    <th class="text-center">Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input invoicechk">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Camera</td>
                                    <td>#0001</td>
                                    <td>16 Jan</td>
                                    <td class="align-center">$15,202</td>
                                    <td class="text-center">
                                        <span class="badge badge-pills outline-badge-secondary">In Progress</span>
                                    </td>
                                    <td>
                                        <i class="flaticon-view-1 bs-tooltip" data-placement="top"
                                            data-original-title="View"></i>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input invoicechk">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Iphone</td>
                                    <td>#0002</td>
                                    <td>16 Jan</td>
                                    <td class="align-center">$650</td>
                                    <td class="text-center">
                                        <span class="badge badge-pills outline-badge-success">Approved</span>
                                    </td>
                                    <td>
                                        <i class="flaticon-view-1 bs-tooltip" data-placement="top"
                                            data-original-title="View"></i>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input invoicechk">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Headphone</td>
                                    <td>#0003</td>
                                    <td>16 Jan</td>
                                    <td class="align-center">$25</td>
                                    <td class="text-center">
                                        <span class="badge badge-pills outline-badge-warning">Pending</span>
                                    </td>
                                    <td>
                                        <i class="flaticon-view-1 bs-tooltip" data-placement="top"
                                            data-original-title="View"></i>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input invoicechk">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Speakers</td>
                                    <td>#0004</td>
                                    <td>16 Jan</td>
                                    <td class="align-center">$100</td>
                                    <td class="text-center">
                                        <span class="badge badge-pills outline-badge-secondary">In Progress</span>
                                    </td>
                                    <td>
                                        <i class="flaticon-view-1 bs-tooltip" data-placement="top"
                                            data-original-title="View"></i>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input invoicechk">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Watch</td>
                                    <td>#0005</td>
                                    <td>16 Jan</td>
                                    <td class="align-center">$85</td>
                                    <td class="text-center">
                                        <span class="badge badge-pills outline-badge-success">Approved</span>
                                    </td>
                                    <td>
                                        <i class="flaticon-view-1 bs-tooltip" data-placement="top"
                                            data-original-title="View"></i>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="form-check-column text-center">
                                        <label class="new-control new-checkbox checkbox-primary pb-2">
                                            <input type="checkbox" class="new-control-input invoicechk">
                                            <span class="new-control-indicator mt-2"></span><span class="invisible">s</span>
                                        </label>
                                    </td>
                                    <td>Sunglasses</td>
                                    <td>#0006</td>
                                    <td>16 Jan</td>
                                    <td class="align-center">$19</td>
                                    <td class="text-center">
                                        <span class="badge badge-pills outline-badge-danger">Cancelled</span>
                                    </td>
                                    <td>
                                        <i class="flaticon-view-1 bs-tooltip" data-placement="top"
                                            data-original-title="View"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4 col-md-4 col-12 layout-spacing">
            <div class="widget-content-area p-0 card-widget-content ">
                <div id="user-profile-card-1" class="card br-4" style="">
                    <div class="card-body p-0">
                        <div class="usr-img-meta mx-auto">
                            <img alt="admin-profile" src="{{  asset('assets/admin/assets/img/120x120.jpg') }}"
                                class="rounded-circle">
                        </div>
                        <div class="usr-info-meta text-center">
                            <p class="usr-name mb-0">Sean Freeman</p>
                            <p class="usr-occupation">Designer</p>
                            <button class="btn btn-secondary btn-rounded">View Profile</button>
                        </div>
                        <div class="row mt-5">
                            <div class="col-lg-12 text-center mt-4">
                                <button class="btn btn-light-info rounded-circle mb-2 mr-2"><i
                                        class="flaticon-twitter-logo flaticon-circle-p"></i>
                                </button>
                                <button class="btn btn-light-success rounded-circle mb-2 mr-2"><i
                                        class="flaticon-behance-logo flaticon-circle-p"></i>
                                </button>
                                <button class="btn btn-light-primary rounded-circle mb-2 mr-2"><i
                                        class="flaticon-facebook-logo flaticon-circle-p"></i>
                                </button>
                                <button class="btn btn-light-warning rounded-circle mb-2 mr-2"><i
                                        class="flaticon-dribbble-bold flaticon-circle-p"></i>
                                </button>
                                <button class="btn btn-light-danger rounded-circle mb-2 mr-2"><i
                                        class="flaticon-youtube-logo flaticon-circle-p"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-5 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area page-views p-0  br-4">
                <ul class="nav nav-pills py-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">Daily</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab"
                            aria-controls="pills-profile" aria-selected="false">Weekly</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab"
                            aria-controls="pills-contact" aria-selected="false">Monthly</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 text-center">
                                <div class="daily">
                                    <p class="d-count mb-0">5,067</p>
                                    <p>Total Page Views</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div id="daily"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 text-center">
                                <div class="weekly">
                                    <p class="w-count mb-0">25,067</p>
                                    <p>Total Page Views</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div id="weekly"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 text-center">
                                <div class="month">
                                    <p class="m-count mb-0">276,097</p>
                                    <p>Total Page Views</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div id="month"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="row">

                <div class="col-sm-4 col-12 mb-sm-0 mb-4">
                    <div class="widget-content-area social-likes text-center p-0  br-4">
                        <div class="card facebook">
                            <div class="icon mb-4">
                                <i class="flaticon-facebook-logo"></i>
                            </div>
                            <div class="card-content">
                                <h5>Facebook</h5>
                                <p>13K Followers</p>
                            </div>
                            <div class="card-btn-section">
                                <p>View Profile</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-12 mb-sm-0 mb-4">
                    <div class="widget-content-area social-likes text-center p-0  br-4">
                        <div class="card dribbble">
                            <div class="icon mb-4">
                                <i class="flaticon-dribbble-bold"></i>
                            </div>
                            <div class="card-content">
                                <h5>Dribbble</h5>
                                <p>4K Followers</p>
                            </div>
                            <div class="card-btn-section">
                                <p>Check Work</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-12 mb-sm-0 mb-4">
                    <div class="widget-content-area social-likes text-center p-0  br-4">
                        <div class="card twitter">
                            <div class="icon mb-4">
                                <i class="flaticon-twitter-logo"></i>
                            </div>
                            <div class="card-content">
                                <h5>Twitter</h5>
                                <p>7.2K Followers</p>
                            </div>
                            <div class="card-btn-section">
                                <p>Read Tweets</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush