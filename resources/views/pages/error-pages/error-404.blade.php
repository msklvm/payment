@extends('layout.master-mini')

@section('content')
    <div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one"
         style="background-image: url({{ url('assets/images/auth/login_1.jpg') }}); background-size: cover;">
        <div class="row w-100">
            <div class="col-lg-4 mx-auto">
                <div class="card">
                    <div class="card-header">
                        Страница не найдена
                    </div>
                    <div class="card-body">
                            <a href="{{ url()->previous() }}">Вернуться назад</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
