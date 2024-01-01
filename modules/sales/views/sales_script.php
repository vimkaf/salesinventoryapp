<script>

    let saleItems = null;

    $(document).ready(function () {

        const populateTable = function () {

            const subTotal = 0;

            const table = $("#saleItemsTable");

            const tbody = table.find("tbody");

            tbody.html('');


            saleItems.forEach((item) => {

                const tr = $("<tr></tr>");

                const total = item.quantity_sold * item.price;

                const formattedPrice = (new Intl.NumberFormat('en-NG')).format(item.price);

                const formattedTotal = (new Intl.NumberFormat('en-NG')).format(total);

                const firstColumn = $(`<td>${item.product_name}</td>`);

                const secondColumn = $(`<td>${item.quantity_sold} ${item.unit}</td>`);

                const thirdColumn = $(`<td>${formattedPrice}</td>`);

                const fourthColumn = $(`<td>${formattedTotal}</td>`);

                tr.append(firstColumn, secondColumn, thirdColumn, fourthColumn);

                tbody.append(tr);


            });

        }

        $("#saleItemsModal").on("shown.bs.modal", function () {
            populateTable();
        });

        $(".saleRow").on('click', function (e) {
            const saleID = $(this).attr('data-sale-id');

            $.ajax({
                url: '<?= base_url('dashboard/sales/items') ?>',
                method: 'get',
                data: {
                    saleid: saleID,
                },
                beforeSend: function () {
                    $(`tr[data-row-id='${saleID}']`).block({
                        message: 'loading information'
                    });
                },
                success: function (res) {
                    if (res.status) {

                        saleItems = res.data.items;

                        $("#saleItemsModal").modal('show');

                    }
                },
                error: function (xhr, status, err) {

                    const response = xhr.responseJSON;

                    toastr.error(response.message);

                },
                complete: function (xhr, status) {

                    $(`tr[data-row-id='${saleID}']`).unblock();

                }
            });

        })
    });

</script>