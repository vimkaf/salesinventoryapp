<script>
    function parseLocaleNumber(stringNumber, locale) {
        var thousandSeparator = Intl.NumberFormat(locale).format(11111).replace(/\p{Number}/gu, '');
        var decimalSeparator = Intl.NumberFormat(locale).format(1.1).replace(/\p{Number}/gu, '');

        return parseFloat(stringNumber
            .replace(new RegExp('\\' + thousandSeparator, 'g'), '')
            .replace(new RegExp('\\' + decimalSeparator), '.')
        );
    }

    const calcNetTotal = function (returnTotal, saleTotal) {
        const netTotal = parseFloat(saleTotal - returnTotal);
        $("#netTotal").val(netTotal);
        $("#netTotal").next().text(
            '₦' + (new Intl.NumberFormat('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })).format(netTotal)
        );
    }

    const calcReturnTotal = function () {
        let returnTotal = 0;
        const saleTotal = $("#saleTotal").val();
        const totals = $(`input[data-total]`);
        totals.each(function () {
            returnTotal += parseLocaleNumber($(this).val());
        });

        $("#returnTotal").val(returnTotal);
        $("#returnTotal").next().text(
            '₦' + (new Intl.NumberFormat('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })).format(returnTotal)
        );

        $("#less").val(returnTotal);
        $("#less").next().text(
            '₦' + (new Intl.NumberFormat('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })).format(returnTotal)
        );

        calcNetTotal(returnTotal, saleTotal);

    }


    $(document).ready(function () {

        $('.quantity').on('change', function (e) {

            const key = $(this).data('qr');

            const price = $(`input[data-price = ${key}]`).val();
            const qtyReturned = $(this).val();
            const total = price * qtyReturned;

            $(`input[data-total = ${key}]`).val(
                (new Intl.NumberFormat('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 })).format(total)
            );

            calcReturnTotal();
        });

        //delete an item
        $(document).on('click', '.deleteItem', function (ev) {
            $(this).closest("tr").remove();
            calcReturnTotal();
        });


    });

</script>