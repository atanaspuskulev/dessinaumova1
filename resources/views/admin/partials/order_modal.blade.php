<div class="modal" id="orderModal">
    <div class="modal-dialog order-content">
        <div class="modal-content ">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Order Information</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card ">
                            <div class="card-body small bg-gray-200">
                                <h3 class="ml-2 mt-2 mb-2">Order Info</h3>
                                <div class="row">
                                    <div class="col"><b>Order #</b></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col order_id_col"></div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col"><b>Amount</b></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col amount_col"></div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col"><b>Tax</b></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col tax_col">20%</div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col"><b>Total Amount</b></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col total_amount_col"></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col"><b>Customer</b></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col customer_name_col"></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col"><b>E-Mail</b></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col customer_email_col"></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col"><b>Status</b></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col status_col"></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col"><b>Country</b></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col country_col"></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col"><b>Updated</b></div>
                                </div>
                                <div class="row">
                                    <div class="col updated_date_col"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card ">
                            <div class="card-body small items-content bg-gray-100">
                                <h3 class="ml-2 mt-2 mb-2">Items</h3>
                                <div class="items-container"></div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
