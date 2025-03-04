@extends('layouts.app-home')
@section('Title')
    History Transaksi
@endsection
@section('style')
<style>
    .card-title {
        color: #273A8B;
    }
    .card-text {
        color: #7D829B;
    }
    table.dataTable thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #b0b3bd;
    }
    table.dataTable tbody tr {
        border-bottom: 1px solid #d1d3e2;
    }
    table.dataTable tbody tr:hover {
        background-color: #f1f1f1;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: none !important;
        background: none !important;
    }
</style>
@endsection
@section('content')
    <section class="p-5">
        <div class="container-fluid p-5" style="background-color:white; border-radius: 10px;">
            <h5 class="mb-4" style="color: #273A8B;">Riwayat Transaksi</h5>
            <div class="table-responsive">
                <table id="transactionTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Event</th>
                            <th>Nomor Transaksi</th>
                            <th>Tanggal</th>
                            <th>Bukti Transfer</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $key => $transaction)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $transaction->event->event_name }}</td>
                                <td>{{ $transaction->transaction_number }}</td>
                                <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                                <td>
                                    @if($transaction->bukti_tf)
                                        <a href="{{ asset('bukti-tf/' . $transaction->bukti_tf) }}" target="_blank">
                                            Lihat Bukti Transfer
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($transaction->is_confirmed == 1)
                                        <p class="text-muted mb-1" style="border-radius: 5px; padding: 3%; width: 90%; font-weight: bold; font-style: italic; font-size: 0.8rem; 
                                                       color: #273A8B !important; background-image: linear-gradient(to right, #44eb16, rgba(255, 99, 71, 0));">
                                            Dikonfirmasi
                                        </p>
                                    @elseif ($transaction->is_confirmed == -1)
                                        <p class="text-muted mb-1" style="border-radius: 5px; padding: 3%; width: 90%; font-weight: bold; font-style: italic; font-size: 0.8rem; 
                                                       color: white !important; background-image: linear-gradient(to right, #eb1616, rgba(255, 99, 71, 0));">
                                            Ditolak
                                        </p>
                                    @else
                                        <p class="text-muted mb-1" style="border-radius: 5px; padding: 3%; width: 90%; font-weight: bold; font-style: italic; font-size: 0.8rem; 
                                                       color: #273A8B !important; background-image: linear-gradient(to right, #FCBB22, rgba(255, 99, 71, 0));">
                                            Pending
                                        </p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#transactionTable').DataTable({
            "ordering": false,
            "lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "All"]],
            "language": {
                "paginate": {
                    "previous": "<",
                    "next": ">"
                },
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            }
        });
    });
</script>
@endsection
