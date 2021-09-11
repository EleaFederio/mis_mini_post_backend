@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-4">
        <div class="row justify-content-start">
            <div class="col-7">

            </div>
            <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        Price & Items
                    </div>
                    <div class="card-body">
                        <div class="overflow-auto">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th scope="col" class="table-dark text-center">Item</th>
                                    <th scope="col" class="table-dark text-center">Quantity</th>
                                    <th scope="col" class="table-dark text-center">Price</th>
                                    <th scope="col" class="table-dark text-center">Total</th>
                                    <th scope="col" class="table-dark"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Gardenia Toasties</td>
                                    <td>3</td>
                                    <td>₱62.00</td>
                                    <td>₱186.00</td>
                                    <td>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Gardenia Classic</td>
                                    <td>1</td>
                                    <td>₱80.00</td>
                                    <td>₱80.00</td>
                                    <td>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Marby Mongo</td>
                                    <td>2</td>
                                    <td>₱62.00</td>
                                    <td>₱71.00</td>
                                    <td>
                                        <button class="btn btn-danger">Delete</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr>


                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
