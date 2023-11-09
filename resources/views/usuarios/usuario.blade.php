@extends('layouts.app')
@section('title', 'Usuario | Glory Store')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/account.css') }}">
@endsection

@section('content')
@foreach ($user as $item)
<div class="container-index-user conrtainer-table-d">
    <div class="header-table header__table__left">
        <div class="bread-cump">
            <a href="{{ route('dashboard') }}">Home</a>
            /
            <a href="{{ route('usuarios') }}">Usuarios</a>
            /
            <a>{{ $item->nameLast }}</a>
        </div>
        <h2> {{$item->nameLast}} - {{$item->cc}}</h2>
    </div>

    <div class="content-account">
        <div class="info-general-u">
            <div class="con-picture-profi">
                <img src="{{ asset('img/profileImages/' . $item->profileImg) }}" alt="image-profile">
            </div>
            <div class="con-info-u-b">
                <h2> {{$item->fullName}} </h2>
                <p><i class="fi fi-sr-briefcase"></i> {{$item->getRoleNames()->first()}}</p>
                <p><i class="fi fi-sr-phone-call"></i> {{$item->phone_number}}</p>
                <p><i class="fi fi-sr-envelope"></i> {{$item->emailV}} </p>
            </div>
            <div class="acti-acco">
                <a href="{{route('usuarios.edit', $item->cc)}}">Editar</a>
                <a onclick="confirmTrash({{ $item->id }}, '{{ $item->full_name }}', 1)" class="btn-elim-user">Eliminar</a>
            </div>
            <div class="con-src-accounts">
                <a href="{{ route('usuarios.usuario', $item->cc) }}" class="acco-active">Detalle</a>
                <a href="{{route('usuarios.edit', $item->cc)}}">Editar</a>
                @if ($item->getRoleNames()->first() == 'Vendedor')
                <a href="">Permisos</a>
                @endif

                @if ($item->getRoleNames()->first() == 'Cliente')
                    <a href="">Vehículos</a>
                @endif
            </div>
        </div>

        <div class="main-sec-acco">
            <div class="header-sec-ac">
                <i class="fi fi-sr-id-badge"></i>
                <h2>Detalle</h2>
                <div class="divider"></div>
                <a href="{{route('usuarios.edit', $item->cc)}}">Editar</a>
            </div>
            <div class="content-sec-ac">
                <div class="con-detail-us">
                    <label>Documento</label>
                    <span> {{$item->cc}} </span>
                    <label>Nombre completo</label>
                    <span> {{$item->fullname}} </span>
                    <label>Email</label>
                    <span>{{$item->emailV}}</span>
                    <label>Telefono</label>
                    <span>{{$item->phone_number}}</span>
                    <label>Dirección</label>
                    <span>{{$item->address}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@extends('usuarios.modal')

@endsection
@section('scripts')
<script src="{{ asset('js/user.js') }}"></script>
@endsection
