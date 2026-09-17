<link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

    <div class="row mt-4">

        <!-- Sales Chart -->

        <div class="col-lg-8 mb-4">

            <div class="chart-card">

                <div class="chart-header">

                    <h5>Sales Analytics</h5>

                    <select class="form-select">

                        <option>Weekly</option>

                        <option>Monthly</option>

                        <option>Yearly</option>

                    </select>

                </div>

                <div id="salesChart"></div>

            </div>

        </div>

        <!-- Order Status -->

        <div class="col-lg-4 mb-4">

            <div class="chart-card">

                <h5 class="mb-3">

                    Order Status

                </h5>

                <div id="orderChart"></div>

            </div>

        </div>

    </div>


    <div class="row mt-4">

        <div class="col-lg-8">
            <div class="">
                <span class="online"><i class="fa fa-map-marker"></i>  Live Delivery Tracking</span>  
                <div class="glass-card"> 
                    <div id="deliveryMap"></div>

                </div>
            </div>

        </div>

        <div class="col-lg-4">

            <div class="glass-card">

                <div class="delivery-info ml-5">

                    <img src="{{ asset('assets/images/b2.png') }}">

                    <h4>Delivery Boy</h4>

                    <h5>Shakil Ahmed</h5>

                    <span class="online">

                        ● Online

                    </span>

                    <hr>

                    <p>

                        Current Order

                    </p>

                    <h3>#ORD-10025</h3>

                    <button class="delivery-btn">

                        View Details

                    </button>

                </div>

            </div>

        </div>

    </div>


<div class="row mt-4">
 

    <div class="col-lg-4 mt-2">
        <div class="glass-card  ">

            <div class="delivery-info ml-5">

                <h4>Live Delivery</h4>

                <span class="online">
                    <i class="fa fa-circle"></i> Online
                </span>

                <hr>

                <div class="delivery-row">
                    <span>Distance</span>
                    <strong id="distanceText">  2.4 KM  </strong>
                </div>


                
                <div class="delivery-row">
                    <span>ETA</span>
                    <strong id="etaText">  12 Min  </strong>
                </div>

 

                <div class="delivery-row">
                    <span>Speed</span>
                    <strong id="speedText">28 km/h</strong>
                </div> 

            </div>
        </div>
    </div>
 
    

 
    <div class="col-lg-4 mt-2">
        <div class="glass-card  ">
    
            <div class="verify-box ml-2">
                <h5 class="mb-4">
                    Delivery Verification
                </h5>
                <label>Customer OTP</label>

                <input
                    type="text"
                    class="form-control otp-input"
                    placeholder="Enter OTP">

                <button class="delivery-btn mt-3">

                    <i class="fa fa-check"></i>

                    Verify OTP

                </button>

                <button class="delivery-btn btn-secondary mt-2">

                    <i class="fa fa-qrcode"></i>

                    Scan QR Code

                </button>

                <hr>

                <button class="delivery-btn btn-success mt-2">

                    <i class="fa fa-phone"></i>

                    Call Customer

                </button>

                <button class="delivery-btn btn-info mt-2">

                    <i class="fa fa-comments"></i>

                    Chat Customer

                </button>

                <button class="delivery-btn btn-danger mt-2">

                    <i class="fa fa-check-circle"></i>

                    Delivery Complete

                </button>

            </div>
    
        </div>
    </div>



    <div class="col-lg-4 mt-2">
        <div class="glass-card  ">

            <div class="delivery-info ml-3">

                <img src="{{ asset('assets/images/b1.png') }}" alt="Rider">

                <h4>Shakil Ahmed</h4>

                <span class="online">
                    <i class="fa fa-circle"></i> Online
                </span>

                <hr>

                <div class="delivery-row">
                    <span>Current Order</span>
                    <strong>#ORD-10025</strong>
                </div>

                <div class="delivery-row">
                    <span>Distance</span>
                    <strong>2.4 KM</strong>
                </div>

                <div class="delivery-row">
                    <span>ETA</span>
                    <strong>12 Minutes</strong>
                </div>

                <div class="delivery-row">
                    <span>Status</span>
                    <strong class="text-warning">
                        On The Way
                    </strong>
                </div>

                

                <button class="delivery-btn mt-3">
                    <i class="fa fa-phone"></i>
                    Call Rider
                </button>

                <button class="delivery-btn btn-dark mt-2">
                    <i class="fa fa-location-arrow"></i>
                    Navigate
                </button>

            </div>
        </div>
    </div>


 

    <div class="col-lg-4 mt-2">
        <div class="glass-card  ">
    
            <div class="delivery-timeline">

                <h5 class="mb-4">
                    <i class="fa fa-road text-warning"></i>
                    Delivery Timeline
                </h5>

                <div class="timeline-item active">

                    <div class="timeline-icon">
                        <i class="fa fa-check"></i>
                    </div>

                    <div class="timeline-content">
                        <h6>Order Confirmed</h6>
                        <small>10:15 AM</small>
                    </div>

                </div>

                <div class="timeline-item active">

                    <div class="timeline-icon">
                        <i class="fa fa-shopping-bag"></i>
                    </div>

                    <div class="timeline-content">
                        <h6>Picked Up</h6>
                        <small>10:42 AM</small>
                    </div>

                </div>

                <div class="timeline-item active">

                    <div class="timeline-icon">
                        <i class="fa fa-motorcycle"></i>
                    </div>

                    <div class="timeline-content">
                        <h6>On The Way</h6>
                        <small>Live</small>
                    </div>

                </div>

                <div class="timeline-item">

                    <div class="timeline-icon">
                        <i class="fa fa-home"></i>
                    </div>

                    <div class="timeline-content">
                        <h6>Delivered</h6>
                        <small>Pending</small>
                    </div>

                </div>

            </div>

        </div>
    </div>


</div>





<script>

document.addEventListener("DOMContentLoaded", function () {


    /* ==========================================
       SALES ANALYTICS CHART
    ========================================== */

    var salesOptions = {

        series: [
            {
                name: "Sales",
                data: [12000, 18000, 15000, 22000, 28000, 24000, 32000]
            }
        ],

        chart: {
            type: "area",
            height: 350,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },

        stroke: {
            curve: "smooth",
            width: 3
        },

        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.35,
                opacityTo: 0.05
            }
        },

        dataLabels: {
            enabled: false
        },

        xaxis: {
            categories: [
                "Sat",
                "Sun",
                "Mon",
                "Tue",
                "Wed",
                "Thu",
                "Fri"
            ]
        },

        yaxis: {
            labels: {
                formatter: function (value) {
                    return "৳" + value.toLocaleString();
                }
            }
        },

        tooltip: {
            y: {
                formatter: function (value) {
                    return "৳" + value.toLocaleString();
                }
            }
        },

        grid: {
            strokeDashArray: 4
        }

    };


    var salesChart = new ApexCharts(
        document.querySelector("#salesChart"),
        salesOptions
    );

    salesChart.render();



    /* ==========================================
       ORDER STATUS CHART
    ========================================== */

    var orderOptions = {

        series: [45, 25, 20, 10],

        chart: {
            type: "donut",
            height: 350
        },

        labels: [
            "Completed",
            "Processing",
            "Pending",
            "Cancelled"
        ],

        legend: {
            position: "bottom"
        },

        dataLabels: {
            enabled: true
        },

        plotOptions: {
            pie: {
                donut: {
                    size: "65%",

                    labels: {
                        show: true,

                        total: {
                            show: true,
                            label: "Total Orders"
                        }
                    }
                }
            }
        },

        tooltip: {
            y: {
                formatter: function (value) {
                    return value + " Orders";
                }
            }
        }

    };


    var orderChart = new ApexCharts(
        document.querySelector("#orderChart"),
        orderOptions
    );

    orderChart.render();

});

</script>





<script>
document.addEventListener('DOMContentLoaded', function () {

    var map = L.map('deliveryMap').setView([23.8103, 90.4125], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([23.8103, 90.4125])
        .addTo(map)
        .bindPopup('<b>Shakil Ahmed</b><br>Delivery Boy<br>Online')
        .openPopup();

});
</script>




    
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    

<script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>