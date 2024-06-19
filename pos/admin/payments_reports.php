<?php
session_start();
include ('config/config.php');
include ('config/checklogin.php');
check_login();
require_once ('partials/_head.php');
?>

<body>
    <!-- Sidenav -->
    <?php
    require_once ('partials/_sidebar.php');
    ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php
        require_once ('partials/_topnav.php');
        ?>
        <!-- Header -->
        <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;"
            class="header  pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--8">
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            Payment Reports
                        </div>
                        <div class="table-responsive p-3">
                            <table id="example" class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Payment Code</th>
                                        <th scope="col">Payment Method</th>
                                        <th class="text-success" scope="col">Order Code</th>
                                        <th scope="col">Amount Paid</th>
                                        <th class="text-success" scope="col">Date Paid</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT * FROM  rpos_payments ORDER BY `created_at` DESC ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($payment = $res->fetch_object()) {
                                        ?>
                                        <tr>
                                            <th class="text-success" scope="row">
                                                <?php echo $payment->pay_code; ?>
                                            </th>
                                            <th scope="row">
                                                <?php echo $payment->pay_method; ?>
                                            </th>
                                            <td class="text-success">
                                                <?php echo $payment->order_code; ?>
                                            </td>
                                            <td>
                                                ₹<?php echo $payment->pay_amt; ?>
                                            </td>
                                            <td class="text-success">
                                                <?php echo date('d/M/Y g:i', strtotime($payment->created_at)) ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <!-- <tfoot>
                                    <tr>
                                        <th colspan="3">Total Price</th>
                                        <th>₹ <span id="total-price">0.00</span></th>
                                        <th colspan="2"></th>
                                    </tr>
                                </tfoot> -->
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Price Display -->
            <div class="row mt-4">
                 <div class="col">
                     <div class="card shadow">
                         <div class="card-body">
                             <h3 class="">Total Sales: ₹ <span id="total-price">0.00</span></h3>
                         </div>
                     </div>
                 </div>
             </div>
            <!-- Footer -->
            <?php
            require_once ('partials/_footer.php');
            ?>
        </div>
    </div>

    <!-- Argon Scripts -->
    <?php
    require_once ('partials/_scripts.php');
    ?>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                dom: 'frtiBp',
                buttons: [
                    'pdfHtml5',
                    'excelHtml5'
                ],
                oLanguage: {
                    oPaginate: {
                        sNext: '<span class="pagination-fa"><i class="fa fa-chevron-right" ></i></span>',
                        sPrevious: '<span class="pagination-fa"><i class="fa fa-chevron-left" ></i></span>'
                    }
                },
                drawCallback: function () {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                    parseFloat(i.replace(/[\₹,]/g, '')) :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Calculate the total for all pages
            var total = api
                .column(3, { filter: 'applied' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update the total amount paid display
            $('#total-price').html(total.toFixed(2));
        }
    });

    // Trigger the drawCallback initially to set the total price
    table.draw();
        });
    </script>
</body>

</html>