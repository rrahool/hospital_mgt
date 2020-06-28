@extends('layout')

@section('main_content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-body">


        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Items Register</h4>
                            <div class="basic-form">
                                <form  action="{{url('item_register')}}" method="post" target="_blank">


                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Product Name</span>
                                            <div class="input-group">
                                                <input class="form-control input " placeholder="Product Name" autofocus tabindex="1" list="products" id="product_input">
                                                <datalist id="products">
                                                    @foreach($products as $value)
                                                        <option data-id="{{$value->id}}" value="{{ $value->product_name }}">
                                                    @endforeach
                                                </datalist>
                                                <input class="form-control input" type="hidden" id="product_id" name="product_id">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">Start Date</span>
                                            <div class="input-group">
                                                <input type="text" id="startpicker" tabindex="2" name="from_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row margin_top_minus_10">
                                        <div class="form-group col-md-6">
                                            <span class="level_size">End Date</span>
                                            <div class="input-group">
                                                <input type="text" id="enddatepicker" tabindex="3" name="to_date" required  class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-append"><span class="input-group-text"><i class="mdi mdi-calendar-check"></i></span></span>
                                            </div>
                                        </div>
                                    </div>



                                    <button type="submit" class="btn btn-primary" tabindex="4">Submit</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section('js')

    <script>
        function getProducts(selected_option) {
            var cat_id = selected_option.options[selected_option.selectedIndex].value;
            //console.log(cat_id)

            $.ajax({
                //url: 'getUser.php',
                url:'get_products',
                type: 'GET',
                data: 'cat_id='+cat_id,
                //data:{id:uid}
                dataType: 'html'
            })
                .done(function(data){
                    console.log(data);

                    $('#product_id').html(data); // load response
                })
                .fail(function(){
                    $('#product_id').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                });

        }


        $('#product_input').on('input', function() {

            var value = $(this).val();
            var c_id = $('#products [value="' + value + '"]').data('id');
            $('#product_id').val(c_id)
        });



    </script>

@stop
