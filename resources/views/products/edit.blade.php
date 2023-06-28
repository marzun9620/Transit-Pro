@extends('layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update',$product->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="bus_type" value="{{ $product->bus_type }}" class="form-control" placeholder="Bus Type">
                </div>
            </div>



             <div class="col-xs-12 col-sm-12 col-md-12">
                 <div class="form-group">
                     <strong>Bus Capacity:</strong>
                     <input type="number" name="bus_capacity" value="{{ $product->bus_capacity }}" class="form-control" placeholder="Bus Capacity">
                 </div>
             </div>
             <div class="col-xs-12 col-sm-12 col-md-12">
                 <div class="form-group">
                     <strong>Registration No:</strong>
                     <input type="text" name="reg_no" value="{{ $product->reg_no }}" class="form-control" placeholder="Registration No">
                 </div>
             </div>
             <div class="col-xs-12 col-sm-12 col-md-12">
                 <div class="form-group">
                     <strong>Fitness:</strong>
                     <input type="text" name="bus_fitness" value="{{ $product->bus_fitness }}" class="form-control" placeholder="Fitness">
                 </div>
             </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>

@endsection
