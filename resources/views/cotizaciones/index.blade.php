@extends('layouts.app')
@section('title', 'Cotizaciones | Glory Store')

@section('styles')
    <link rel="stylesheet" href="{{ asset('libs/datatable/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/datatable/datatablesButtons.css') }}">
@endsection

@section('content')
<div class="container-index-user conrtainer-table-d">
    <div class="header-table">
        <div class="bread-cump">
            <a href="{{ route('dashboard') }}">Home</a>
            /
            <a>Cotizaciones</a>
        </div>
        <h2>Cotizaciones</h2>
            <div class="con-filter">
                @can('create.bills')
                    <a class="btn-modal-add" href="{{ route('budgets.create') }}">
                        <i class="fi fi-br-plus-small"></i>
                        Nueva cotizacion
                    </a>
                @endcan
                <p>Filtrar por categorias: </p>
                <div class="con-filter-da"></div>
                <div class="divider-fil"></div>
            </div>
    </div>
    <table id="table-users" class="display" style="width:100%">
        <thead>
            <tr>
                <th style="max-width: 120px">Fecha</th>
                <th style="max-width: 130px">Referencia</th>
                <th>Cliente</th>
                <th style="max-width: 120px">Total</th>
                <th style="max-width: 150px">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($budgets as $budget)
                <tr>
                    <td> {{$budget->created_at}} </td>
                    <td>{{$budget->reference}}</td>
                    <td>{{($budget->customer->nameLast)}}</td>
                    <td class="prices"> {{$budget->total}} </td>
                    <td class="con-actions-table">
                        @can('see.bills')
                            <a href="{{ route('budgets.budget', $budget->id) }}" class="actions-table action__table_show"><i class="fi fi-br-eye"></i></a>
                        @endcan
                        @can('edit.bills')
                            <a href="{{ route('budgets.edit', $budget->id) }}" class="actions-table action__table_edit"><i class="fi fi-sr-pencil"></i></a>
                        @endcan
                        @can('destroy.bills')
                            <a onclick="confirmTrash({{ $budget->id }}, '{{ $budget->reference }}')" class="actions-table action__table_delete"><i class="fi fi-sr-trash-xmark"></i></a>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Fecha</th>
                <th>Referencia</th>
                <th># Cliente</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

@include('cotizaciones.modal')

@endsection
@section('scripts')
    <script src="{{asset('libs/datatable/datatables.min.js')}}"></script>
        <script src="{{ asset('libs/datatable/datatablesButtons.js') }}"></script>
        <script src="{{ asset('libs/datatable/jszip.min.js') }}"></script>
        <script src="{{ asset('libs/datatable/pdfmake.min.js') }}"></script>
        <script src="{{ asset('libs/datatable/vfs_fonts.js') }}"></script>
        <script src="{{ asset('libs/datatable/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('js/products.js') }}"></script>
        <script>
            $(document).ready(function () {
            $('#table-users').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                lengthMenu: [
                    [ 25, 50, 100, -1 ],
                    [ '25', '50', '100', 'Mostrar todo' ]
                ],
                buttons: [
                    'pageLength',
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [ 0, 1,2,3,4]
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [ 0, 1,2,3,4]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3,4 ]
                        }
                    },
                ],
                initComplete: function () {
                    this.api().columns([ 2 ]).every( function () {
                        var column = this;
                        var select = $('<select class="form-select form-select-sm selecttable-lotus"> <option value="">Todos</option> </select>')
                        .appendTo( $('.con-filter-da'))
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                        column.data().unique().sort().each( function ( d, j ) {
                            if(column.search() === '^'+d+'$'){
                                select.append(
                                    '<option value="'+d+'" selected="selected">'
                                    +d+
                                    '</option>'
                                )
                            } else {
                                select.append('<option value="'+d+'">'+d+'</option>')
                            }
                        });
                    });
                },
            });
        });
        </script>
@endsection
