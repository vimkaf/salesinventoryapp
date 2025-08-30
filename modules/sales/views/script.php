<script>
    function parseLocaleNumber(stringNumber, locale) {
        var thousandSeparator = Intl.NumberFormat(locale).format(11111).replace(/\p{Number}/gu, '');
        var decimalSeparator = Intl.NumberFormat(locale).format(1.1).replace(/\p{Number}/gu, '');

        return parseFloat(stringNumber
            .replace(new RegExp('\\' + thousandSeparator, 'g'), '')
            .replace(new RegExp('\\' + decimalSeparator), '.')
        );
    }

    $(document).ready(function () {

        const salesTable = $("#salesTable");

        const newItemButton = $("#newItem");

        const qtyInputs = $(".quantity");

        const defaultQtyValue = 1;

        let subTotal = 0,
            grandTotal = 0,
            taxEnabled = <?= setting('sales_tax') ?>,
            tax = <?= setting('sales_tax_percentage'); ?>,
            discount = 0,
            tenderMode = '<?= setting('tender_mode'); ?>';

        setup();


        function setup() {

            assignDiscount(discount);
            assignTax(calcTaxValue(subTotal, tax));
            assignSubTotal(subTotal);
            assignGrandTotal(grandTotal);

        }

        function calcTaxValue(total, taxPercentage) {
            return (taxPercentage / 100) * total;
        }

        function assignTax(tax) {

            $("#tax").val(tax);
            $("#tax").next().text((new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN'
            })).format(tax));
        }

        function assignDiscount(discount) {
            $("#discount").val(discount);
            $("#discount").next().text((new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN'
            })).format(discount));
        }

        function assignSubTotal(subTotal) {
            $("#subTotal").val(subTotal);
            $("#subTotal").next().text((new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN'
            })).format(subTotal));
        }

        function assignGrandTotal(grandTotal) {
            $("#grandTotal").val(grandTotal);
            $("#grandTotal").next().text((new Intl.NumberFormat('en-NG', {
                style: 'currency',
                currency: 'NGN'
            })).format(grandTotal));

            if (tenderMode === 'auto') {
                $("#amount_paid").val(grandTotal)
            }
        }

        const reInitSelect2 = function () {
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        };

        const addItem = function (table, currentID, nextID) {

            const tbody = table.find("tbody");

            const tr = $("<tr></tr>");
            tr.attr('data-row-id', nextID);

            const firstColumn = $("<td></td>"),
                secondColumn = $("<td></td>"),
                thirdColumn = $("<td></td>"),
                fourthColumn = $("<td></td>"),
                fifthColumn = $("<td></td>");

            const selectDropDown = $("<select><option value=''>Search or select a product</option></select>");

            selectDropDown.addClass('form-control select2 products');
            selectDropDown.attr('name', 'product[]');
            selectDropDown.attr('data-product-id', nextID);

            const products = <?= json_encode($products); ?>;

            products.forEach(product => {

                const option = $("<option></option>");
                option.attr('data-item-price', product.product_price);
                option.val(product.product_id);
                option.text(`${product.product_code} - ${product.product_name} [${product.unit}]`);

                selectDropDown.append(option);
            });

            firstColumn.append(selectDropDown);

            //second column
            const qtyInput = $("<input />");
            qtyInput.addClass('form-control text-center quantity');
            qtyInput.attr('type', 'number');
            qtyInput.attr('name', 'quantity[]');
            qtyInput.attr('min', defaultQtyValue);
            qtyInput.attr('data-qty-id', nextID);
            qtyInput.val(defaultQtyValue);

            secondColumn.append(qtyInput);



            //third column
            const priceInput = $("<input />");
            priceInput.addClass('form-control text-center');
            priceInput.attr('type', 'text');
            priceInput.attr('readonly', true);
            priceInput.attr('name', 'price[]');
            priceInput.attr('data-price-id', nextID);

            thirdColumn.append(priceInput);


            //fourth column
            const totalInput = $("<input />");
            totalInput.addClass('form-control text-center');
            totalInput.attr('type', 'text');
            totalInput.attr('readonly', true);
            totalInput.attr('name', 'price[]');
            totalInput.attr('data-total-id', nextID);

            fourthColumn.append(totalInput);

            //fifth column
            fifthColumn.addClass('align-middle text-center');
            fifthColumn.append("<i  class='far fa-trash-alt text-danger deleteItem'></i>");

            tr.append(firstColumn, secondColumn, thirdColumn, fourthColumn, fifthColumn);

            tbody.append(tr);

            reInitSelect2();

            selectDropDown.focus();

        };


        newItemButton.on('click', (ev) => {

            const lastRow = salesTable.find("tbody tr").last();

            let currentID = parseInt(lastRow.attr('data-row-id'));

            if (isNaN(currentID)) {
                currentID = 0;
            }

            let nextID = currentID + 1;

            addItem(salesTable, currentID, nextID);

        });

        const moveToQtyField = function (id) {
            $(`input[data-qty-id='${id}']`).focus();
        };


        const calcSubTotal = function () {

            let subTotal = 0;

            const totalInputs = $(`input[data-total-id]`);

            totalInputs.each((index, totalInput) => {
                subTotal += parseLocaleNumber($(totalInput).val());
            });

            assignSubTotal(subTotal);

            calcGrandTotal(subTotal);
        };

        const calcGrandTotal = function (subTotal) {

            taxValue = 0;

            if (taxEnabled) {
                taxValue = calcTaxValue(subTotal, tax);
                assignTax(taxValue);
            }

            grandTotal = (subTotal + taxValue) - discount;

            assignGrandTotal(grandTotal);

        };

        const calcTotal = function (qty, price, id) {
            const total = qty * price;
            const formattedTotal = (new Intl.NumberFormat('en-NG')).format(total);
            const totalInput = $(`input[data-total-id='${id}']`).val(formattedTotal);

            calcSubTotal();
        };

        //delete an item
        $(document).on('click', '.deleteItem', function (ev) {
            $(this).closest("tr").remove();
            calcSubTotal();

        });

        //attach change event to the selectDropdown for products
        $(document).on('change', '.products', function (ev) {

            const selectedOption = $(this).find(':selected');

            const price = isNaN(selectedOption.attr('data-item-price')) ? 0 : selectedOption.attr('data-item-price');

            const id = $(this).attr("data-product-id");

            const priceInput = $(`input[data-price-id='${id}']`);
            const formattedPrice = (new Intl.NumberFormat('en-NG')).format(price);
            priceInput.val(formattedPrice);


            const qtyInput = $(`input[data-qty-id='${id}']`);
            const quantity = parseInt(qtyInput.val());

            moveToQtyField(id);
            calcTotal(quantity, price, id);
            isQtyAvailable(id);

        });

        const isQtyAvailable = (rowID, quantity = null) => {

            const productOptions = $(`select[data-product-id='${rowID}']`);

            const wareHouseInput = $("#warehouse");

            const quantityInput = $(`input[data-qty-id='${rowID}']`);

            const priceInput = $(`input[data-price-id='${rowID}']`);

            const tr = $(`tr[data-row-id='${rowID}']`);

            let isAvailable = false;

            $.ajax({
                url: '<?= base_url('dashboard/sales/checkinventory') ?>',
                method: 'get',
                data: {
                    quantity: quantityInput.val(),
                    product: productOptions.val(),
                    warehouse: wareHouseInput.val()
                },
                beforeSend: function () {
                    tr.block({
                        message: 'Checking inventory'
                    });
                },
                success: function (res) {

                    if (res.status) {

                        isAvailable = true;


                        if (tr.hasClass('error')) {
                            tr.removeClass('error');
                        }

                        if (tr.hasClass('warning')) {
                            tr.removeClass('warning');
                        }

                    }
                },
                error: function (xhr, status, err) {

                    const response = xhr.responseJSON;

                    if (xhr.status === 403) {
                        //set the quantity to the quantity on hand
                        const quantity = parseInt(response.data.quantity_on_hand);

                        if (quantity < 0) {
                            tr.addClass('warning');
                            quantityInput.val(defaultQtyValue);
                        }
                        else {
                            quantityInput.val(response.data.quantity_on_hand);
                        }

                        toastr.warning(response.message);
                    }

                    if (xhr.status === 404) {
                        tr.addClass('error');
                        quantityInput.val(defaultQtyValue);
                        toastr.error(response.message);

                    }


                },
                complete: function (xhr, status) {

                    tr.unblock();
                    // calcSubTotal();

                    const price = parseLocaleNumber(priceInput.val());
                    const qty = parseInt(quantityInput.val());

                    calcTotal(qty, price, rowID);

                }
            });

            return isAvailable;

        };


        //attach change event to the quantity field
        $(document).on('change', '.quantity', function (ev) {

            const id = $(this).attr('data-qty-id');

            const productOptions = $(`select[data-product-id='${id}']`);

            if (productOptions.val() === '') {

                productOptions.focus();

                $(this).val(defaultQtyValue);

                toastr.error('You have not picked a product');

                return;
            }


            const priceInput = $(`input[data-price-id='${id}']`);
            const price = parseLocaleNumber(priceInput.val());
            const qty = parseInt($(this).val());

            isQtyAvailable(id);

            calcTotal(qty, price, id);


        });


        $("#applyDiscount").on('click', function () {

            const discountValue = parseInt($("#discountValue").val());

            discount = discountValue;

            assignDiscount(discount);

            calcSubTotal();

            $("#discountModal").modal('hide');

        });

        let isFormValid = false;

        $("#salesForm").on('submit', function (e) {

            if (isFormValid) {
                return;
            }

            e.preventDefault();

            //check if a customer has been selected
            const customer = $("#customer").val();
            if (customer === '') {
                toastr.error('A customer must be selected');
                return;
            }

            const warehouse = $("#warehouse").val();
            if (warehouse === '') {
                toastr.error('A warehouse must be selected');
                return;
            }

            //check if the sales has at least one product
            const rows = salesTable.find("tbody tr");

            if (rows.length <= 0) {
                toastr.error('You must have at least one item in the sale');
                return;
            }

            let productNotSelected = 0;

            //check if a product has been selected in the row
            rows.each(function (index, row) {
                const id = $(row).attr('data-row-id');
                const productOptions = $(row).find(`select[data-product-id='${id}']`);
                if (productOptions.val() === '') {
                    productNotSelected += 1;
                }

            });

            if (productNotSelected > 0) {
                toastr.error('One of the items selected has no product, pick a product or remove the item(s) from the sale');
                return;
            }

            let rowHasError = 0;

            //check if any row has error or warning on it
            rows.each(function (index, row) {
                if ($(row).hasClass('error') || $(row).hasClass('warning')) {
                    rowHasError += 1;
                }
            });

            if (rowHasError > 0) {
                toastr.error('One of the items selected has an error, remove the item(s) from the sale');
                return;
            }

            isFormValid = true;

            $(this).submit();


        });

        $("#customerForm").submit(function (event) {
            event.preventDefault();
            const formDataArr = $(this).serializeArray();
            const formDataSerial = $(this).serialize();

            console.log(formDataArr, formDataSerial);

            $.ajax({
                url: '<?= base_url('dashboard/sales/add_customer') ?>',
                method: 'post',
                data: formDataArr,
                beforeSend: function () {
                    $("#customerModal").block();
                },
                success: function (res) {

                    $("#customerModal").modal('hide');

                    const option = $("<option></option>");

                    option.val(res.data.id);
                    option.text(formDataArr[0].value.concat(" ", formDataArr[1].value));
                    option.attr('selected', 'true');

                    $("#customer").append(option).focus();

                },
                error: function (xhr, status, error) {
                    toastr.error('Customer not added');
                },
                complete: function () {

                    $("#customerModal").unblock();

                }

            });
        })

    });
</script>