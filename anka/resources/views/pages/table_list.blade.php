@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Table Lists')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Participants</h4>
            <p class="card-category"> Table showing participant details</p>
          </div>
          <div class="card-body">
            <div class="table-responsive"> 
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    ID
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Product
                  </th>
                  <th>
                    DOB
                  </th>
                  <th>
                    Points
                  </th>
                </thead>
                <tbody>
                  @foreach ($participants as $participant) 
                  <tr>
                    <td>{{$participant->id}}</td>
                    <td>{{$participant->name}}</td>
                    <td>{{$participant->product}}</td>
                    <td>{{$participant->DOB}}</td>  
                    <td>{{$participant->points}}</td>                    
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Products</h4>
            <p class="card-category"> Table showing products</p>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th>
                    ID
                  </th>
                  <th>
                    Name
                  </th>
                  <th>
                    Description
                  </th>
                  <th>
                    Quantity
                  </th>
                  <th>
                    Rate
                  </th>
                  <th>
                    Participant 
                  </th>
                </thead>
                <tbody>
                  @foreach ($products as $product) 
                  <tr>
                    <td>{{$product->id}}</td> 
                    <td>{{$product->name}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->quantity}}</td>  
                    <td>{{$product->rate}}</td>
                    <td>{{$product->participant->name}}</td>                    
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection