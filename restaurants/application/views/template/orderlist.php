


<!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
        <!-- page start-->

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    
                    <header class="panel-heading">
                        Order List
                    </header>
                   <div class="panel-body">
                        <!-----------Papge Content------------>
                       
                    		<div class="adv-table">
                    <table  class="display table table-bordered table-striped" id="dynamic-table">
                    <thead>
                    <tr>
                        <th rowspan="2">Order</th>
                        <th rowspan="2">Waiter</th>
                        <th rowspan="2">Table</th>
                        <th rowspan="2">Customer</th>
                        <th rowspan="2">Amount</th>
                        <th colspan="2">Status</th>
                    </tr>
                    <tr>
                        
                        <th>Pending</th>
                        <th>Complete</th>
                    </tr>
                    </thead>
                    <tbody id="orderlist">
                       
                     </tbody>
                    
                    </table>
                    </div>
                        <script>
                             //code for showing staff information
                             var timeInterval = 0;
                            setInterval(function(){

                                        var xmlhttp = new XMLHttpRequest();
                                        xmlhttp.onreadystatechange = function() {
                                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                                str_msg = xmlhttp.responseText;
                                                var arr = JSON.parse(str_msg);
                                                var i;
                                                var out = "";
                                                var PENDING = "";
                                                var COMPLETE = "";
                                                for(i = 0; i < arr.length; i++) {
                                                    if(arr[i].orderstatus=="Pending")
                                                    {
                                                        PENDING = "<i class='fa fa-check'></i>";
                                                        COMPLETE = "";
                                                    }
                                                    else
                                                    {
                                                        PENDING = "";
                                                        COMPLETE = "<i class='fa fa-check'></i>";
                                                    }
                                                    out += "<tr><td>" +
                                                    arr[i].orderid +
                                                    "</td><td>" +
                                                     arr[i].guest +
                                                    "</td><td>" +
                                                     arr[i].waiter +
                                                    "</td><td>" +
                                                     arr[i].total +
                                                    "</td><td>" +
                                                     arr[i].table_no +
                                                    "</td><td align='center'>" +
                                                     PENDING+
                                                    "</td><td  align='center'>" +
                                                    COMPLETE +
                                                    "</td></tr>";
                                                }
                                                
                                                document.getElementById("orderlist").innerHTML = out;
                                                timeInterval =3;
                                            }
                                        }
                                        xmlhttp.open("GET", "<?php echo base_url();?>index.php/outletAdmin/getOrderDetails", true);
                                        xmlhttp.send();



                            },timeInterval);
                        </script>
                       <!-----------!Papge Content------------>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
        </section>
    </section>
    <!--main content end-->
<!--right sidebar start-->
