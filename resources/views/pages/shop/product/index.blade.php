@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Список товаров/услуг</h4>
                    <a href="{{ route('product.create') }}" class="btn btn-success btn-fw">Добавить <i
                            class="mdi mdi-plus"></i></a>

                    @foreach($shops as $shop)
                        <h4 class="card-title mt-4">{{ $shop->title }}</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Code</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($shop->products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ Str::limit($product->title, 50) }}</td>
                                        <td>
                                            @if($product->price)
                                                {{ $product->price }}
                                            @else
                                                свободная
                                            @endif
                                        </td>
                                        <td>{!! Str::limit($product->description, 50) !!}</td>
                                        <td>{{ $product->code }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="">
                                                <a href="{{ route('product.edit', $product->id) }}"
                                                   class="btn btn-secondary">
                                                    <i class="mdi mdi-file-edit"></i>
                                                    Edit
                                                </a>
                                                <a href="{{ $product->payLink() }}" target="_blank"
                                                   class="btn btn-primary">
                                                    <i class="mdi mdi-view-dashboard"></i>
                                                    Preview
                                                </a>

                                                <form action="{{ route('product.destroy', $product->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button class="btn btn-danger">
                                                        <i class="mdi mdi-delete"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                                {{--                                            <button type="button" class="btn btn-danger">Remove</button>--}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
