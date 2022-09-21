@extends('layout.master')

@section('content')
    <div class="row">
        <div class="col grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Список доступных магазинов</h4>

                    @if(auth()->user()->hasRole('Super admin'))
                        <a href="{{ route('shop.create') }}" class="btn btn-success btn-fw">
                            Добавить <i class="mdi mdi-plus"></i>
                        </a>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th></th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Token</th>
                                <th>created</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shops as $shop)
                                <tr>
                                    <td>{{ $shop->id }}</td>
                                    <td><img src="{{ $shop->getLogo() }}" alt="logo"></td>
                                    <td>{{ $shop->title }}</td>
                                    <td>{{ Str::limit($shop->description, 50) }}</td>
                                    <td>{{ $shop->token }}</td>
                                    <td>{{ $shop->created_at }}</td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="">
                                            <a href="{{ route('shop.edit', $shop->id) }}" class="btn btn-secondary">
                                                <i class="mdi mdi-file-edit"></i>
                                                Edit
                                            </a>

                                            @if(auth()->user()->hasRole('Super admin'))
                                                <a href="{{ route('shop.form', $shop->id) }}" class="btn btn-primary">
                                                    <i class="mdi mdi-file-edit"></i>
                                                    Payform
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
