@extends('dashboard.layouts.app')

@section('content')


<style>
    .toggle-switch-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
        margin: 0;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #ccc;
        border-radius: 30px;
        transition: 0.3s;
    }

    .toggle-slider::before {
        content: "";
        position: absolute;
        width: 22px;
        height: 22px;
        left: 3px;
        top: 3px;
        background-color: #fff;
        border-radius: 50%;
        transition: 0.3s;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.25);
    }

    .toggle-switch input:checked + .toggle-slider {
        background-color: #22c55e;
    }

    .toggle-switch input:checked + .toggle-slider::before {
        transform: translateX(24px);
    }

    .toggle-status {
        font-size: 13px;
        font-weight: 600;
        min-width: 28px;
    }
</style>

<div class="container-fluid mt-2">

    <!-- Page Header dashboard_manage -->

    <div class="page-header">

        <div>

            <h3><i class="{{!empty($menuIcon)? $menuIcon : $pageIcon}}"></i> 
            {{!empty($getparentMenuTitle)? $getparentMenuTitle : $pageTitle}}</h3>

            <p><i class="{{$pageIcon}}"></i> {{$pageTitle}} \  

                <a href="{{$currentPage}}"  > 
                    {{$currentPage}}
                </a>
            </p>

        </div>

    </div>

    <!-- Statistics --> 

    

      

    <div class="row mt-4">

        <!-- Recent Orders -->

        <div class="col-lg-12 mb-4">

            <div class="table-card">

                
                <div class="table-header d-flex align-items-center justify-content-between">

                    <!-- Left Side -->
                    <div>
                        <h5 class="mb-0">{{$pageTitle}}</h5>
                    </div>
                     
                    <!-- Right Side Buttons -->
                    <div class="ms-auto">

                        <div class="btn-group-sm d-flex flex-wrap justify-content-end">

                            <input
                                type="text"
                                id="ticketid"
                                onkeyup="searchTable()"
                                class="form-control search-box"
                                placeholder="Type to search..."
                            >

                        </div>

                    </div>

                </div> 
            
                <div class="table-responsive">

                    <table id="dataTable" class="align-middle mb-4 table table-striped table-hover table-bordered">
                        <form id="managewebsite" method="POST">
                        @csrf

                         
                        <thead>
                            <tr> 
                                <th>Setting's Name</th>
                                <th>Value</th> 
                                <th>Setting's Name</th>
                                <th>Value</th>  
                                
                            </tr>
                        </thead>
 
                        <tbody>

                            @forelse($configdata as $datarslt)

                                @if($loop->first)
                                    <tr>
                                @endif

                                <td>
                                    <b>{{ $datarslt->id }}.</b>
                                    {{ $datarslt->setting }}
                                </td>

                                <td>

                                    {{-- fields_type = 0 : Text Input --}}
                                    @if($datarslt->fields_type == 0)

                                        <input
                                            type="text"
                                            value="{{ $datarslt->value }}"
                                            name="fname{{ $datarslt->id }}"
                                            onchange="updateData('{{ $datarslt->id }}', this.value)"
                                        />









                                        {{-- fields_type = 1 : ON / OFF --}}
                                    @elseif(
                                        $datarslt->fields_type == 1 &&
                                        in_array($datarslt->value, ['on', 'off', ''])
                                    )

                                        <div class="toggle-switch-wrapper">

                                            <label class="toggle-switch">

                                                <input
                                                    type="checkbox"
                                                    name="fname{{ $datarslt->id }}"
                                                    value="on"
                                                    onchange="updateData(
                                                        '{{ $datarslt->id }}',
                                                        this.checked ? 'on' : 'off'
                                                    )"
                                                    {{ $datarslt->value == 'on' ? 'checked' : '' }}
                                                >

                                                <span class="toggle-slider"></span>

                                            </label>

                                            <span class="toggle-status">
                                                {{ $datarslt->value == 'on' ? 'ON' : 'OFF' }}
                                            </span>

                                        </div>


                                     
 

                                    {{-- fields_type = 1 : ASC / DSC --}}
                                    @elseif(
                                        $datarslt->fields_type == 1 &&
                                        in_array($datarslt->value, ['ASC', 'DSC'])
                                    ) 
                                        <div class="toggle-switch-wrapper">

                                            <label class="toggle-switch">

                                                <input
                                                    type="checkbox"
                                                    name="fname{{ $datarslt->id }}"
                                                    value="ASC"
                                                    onchange="updateData(
                                                        '{{ $datarslt->id }}',
                                                        this.checked ? 'ASC' : 'DSC'
                                                    )"
                                                    {{ $datarslt->value == 'ASC' ? 'checked' : '' }}
                                                >

                                                <span class="toggle-slider"></span>

                                            </label>

                                            <span class="toggle-status">
                                                {{ $datarslt->value == 'ASC' ? 'ASC' : 'DSC' }}
                                            </span>

                                        </div>


                                    {{-- fields_type = 2 : Date Format --}}
                                    @elseif(
                                        $datarslt->fields_type == 2 &&
                                        in_array(
                                            $datarslt->value,
                                            ['DD/MM/YYYY', 'MM/DD/YYYY', 'YYYY/MM/DD']
                                        )
                                    )

                                        <select
                                            name="fname{{ $datarslt->id }}"
                                            onchange="updateData('{{ $datarslt->id }}', this.value)"
                                        >

                                            <option
                                                value="DD/MM/YYYY"
                                                {{ $datarslt->value == 'DD/MM/YYYY' ? 'selected' : '' }}
                                            >
                                                DD/MM/YYYY
                                            </option>

                                            <option
                                                value="MM/DD/YYYY"
                                                {{ $datarslt->value == 'MM/DD/YYYY' ? 'selected' : '' }}
                                            >
                                                MM/DD/YYYY
                                            </option>

                                            <option
                                                value="YYYY/MM/DD"
                                                {{ $datarslt->value == 'YYYY/MM/DD' ? 'selected' : '' }}
                                            >
                                                YYYY/MM/DD
                                            </option>

                                        </select>


                                    {{-- fields_type = 2 : ONE / TWO / THREE / FOUR / FIVE / SIX --}}
                                    @elseif(
                                        $datarslt->fields_type == 2 &&
                                        in_array(
                                            $datarslt->value,
                                            ['ONE', 'TWO', 'THREE', 'FOUR', 'FIVE', 'SIX']
                                        )
                                    )

                                        <select
                                            name="fname{{ $datarslt->id }}"
                                            onchange="updateData('{{ $datarslt->id }}', this.value)"
                                        >

                                            <option
                                                value="ONE"
                                                {{ $datarslt->value == 'ONE' ? 'selected' : '' }}
                                            >
                                                ONE
                                            </option>

                                            <option
                                                value="TWO"
                                                {{ $datarslt->value == 'TWO' ? 'selected' : '' }}
                                            >
                                                TWO
                                            </option>

                                            <option
                                                value="THREE"
                                                {{ $datarslt->value == 'THREE' ? 'selected' : '' }}
                                            >
                                                THREE
                                            </option>

                                            <option
                                                value="FOUR"
                                                {{ $datarslt->value == 'FOUR' ? 'selected' : '' }}
                                            >
                                                FOUR
                                            </option>

                                            <option
                                                value="FIVE"
                                                {{ $datarslt->value == 'FIVE' ? 'selected' : '' }}
                                            >
                                                FIVE
                                            </option>

                                            <option
                                                value="SIX"
                                                {{ $datarslt->value == 'SIX' ? 'selected' : '' }}
                                            >
                                                SIX
                                            </option>

                                        </select>


                                    {{-- fields_type = 3 : Textarea --}}
                                    @elseif($datarslt->fields_type == 3)

                                        <textarea
                                            name="fname{{ $datarslt->id }}"
                                            onchange="updateData('{{ $datarslt->id }}', this.value)"
                                        >{{ $datarslt->value }}</textarea>

                                    @endif

                                </td>


                                {{-- প্রতি 2টি item পর নতুন row --}}
                                @if($loop->iteration % 2 == 0)

                                    </tr>

                                    @if(!$loop->last)
                                        <tr>
                                    @endif

                                @endif


                            @empty

                                <tr>
                                    <td colspan="4" align="center">
                                        Not Found Any Items
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                        </form> 

                    </table>

                </div>

            </div>

        </div>

        

    </div>

    



</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
 
    
    function updateData(id, val){
        if (val <= 0 || id <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Data!',
                text: 'Please provide valid ID and Value.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            return;
        }

        var fd = new FormData($("#managewebsite")[0]);
        fd.append("id", id);
        fd.append("val", val);

        Swal.fire({
            title: 'Updating...',
            text: 'Please wait...',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Try Again',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: 'updateSettings',
            data: fd,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {
                Swal.close();

                if (data.stts == "OK") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.msg,
                        confirmButtonColor: '#28a745',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        reloadDashboardBody(); 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.msg,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Try Again'
                    });
                }
            }
        });
    }






    function reloadDashboardBody() 
    {

    
        $('#myPage').modal('hide');
        $('#myPagexl').modal('hide');

        
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');

        
        $('#dashboardBodyLoad').html(`
            <div class="text-center p-5">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p class="mt-2">Loading... <img src="{{ asset('assets/images/loading.gif') }}"  />
                </p>
            </div>
        `);

        $.ajax({
            url: window.location.href,
            type: 'GET',

            success: function(response) {

                let newBody = $(response)
                    .find('#dashboardBodyLoad')
                    .html();

                $('#dashboardBodyLoad').html(newBody);
            },

            error: function(xhr) {

                Swal.fire({
                    title: 'Error!',
                    text: 'Content reload failed.',
                    icon: 'error'
                });

            }
        });
    }


 
    function searchTable() {

        const input = document.getElementById("ticketid");
        const table = document.getElementById("dataTable");

        if (!input || !table) {
            console.log("Input or table not found");
            return;
        }

        const filter = input.value.toUpperCase();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function(row) {

            const rowText = row.textContent.toUpperCase();

            if (rowText.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }

        });
    }
</script>

@endsection