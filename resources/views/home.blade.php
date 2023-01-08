@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        Pilih Barang
                    </div>
                    <div class="card-body">
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" id="itemId">

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control mb-2" name="item_name" id="itemName"
                                        placeholder="Pilih barang..." disabled required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                            data-bs-target="#pilihBarang">Pilih</button>
                                    </div>
                                </div>

                                <div class="modal fade" id="pilihBarang">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Pilih Barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <table class="table table-stripped">
                                                    <thead class="table-dark">
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Nama Barang</th>
                                                            <th scope="col">Kategori</th>
                                                            <th scope="col">Deskripsi</th>
                                                            <th scope="col">Harga</th>
                                                            <th scope="col">Stok</th>
                                                            <th scope="col">Opsi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($items as $item)
                                                            <tr>
                                                                <th scope="row">{{ $loop->iteration }}</th>
                                                                <td>{{ $item->name }}</td>
                                                                <td>{{ $item->category->name }}</td>
                                                                <td>{{ $item->description }}</td>
                                                                <td>Rp {{ $item->price }}</td>
                                                                <td>{{ $item->stock }}</td>
                                                                <td>
                                                                    <button type="button" class="btn btn-sm btn-primary"
                                                                        data-bs-dismiss="modal"
                                                                        onclick="
                                                                    $('#itemId').val('{{ $item->id }}')
                                                                    $('#itemName').val('{{ $item->name }}')
                                                                    $('#itemQty').attr('max', '{{ $item->stock }}')">
                                                                        Pilih
                                                                    </button>
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

                            <div class="form-group">
                                <div class="input-group">
                                    <input id="itemQty" type="number" min="1" value="1" class="form-control"
                                        name="quantity" placeholder="Masukkan jumlah..." required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Unit</span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-end mt-2">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        Pembayaran
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transaction.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Total Harga</label>

                                <div class="input-group col-sm-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control" value="{{ 
                                    $itemCarts->sum(function ($item) {
                                        return $item->price * $item->cart->quantity;
                                    }) }}" name="total" placeholder="0" disabled
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jumlah Bayar</label>

                                <div class="input-group col-sm-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input min="{{ $itemCarts->sum(function ($item) {
                                        return $item->price * $item->cart->quantity;
                                    }) }}" type="number" class="form-control" name="pay-total" placeholder="0" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal</label>

                                <div class="col-sm-6 input-group">
                                    <input type="text" class="form-control" name="date" value="{{ date('d F Y') }}"
                                        disabled>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-end mt-2">Bayar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-stripped">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itemCarts as $item)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>
                            <img src="{{ asset($item->image) }}" alt="" width="50px" height="50px">
                        </td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->cart->quantity }}</td>
                        <td>Rp {{ $item->price * $item->cart->quantity }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#ubahJumlah{{ $loop->iteration }}">
                                Ubah
                            </button>

                            <form action="{{ route('cart.destroy', $item->cart) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>

                            <div class="modal fade" id="ubahJumlah{{ $loop->iteration }}">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ubah Jumlah '{{ $item->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('cart.update', $item->cart) }}" method="post">
                                                @csrf
                                                @method('PATCH')

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input 
                                                        type="number"
                                                        min="1"
                                                        max="{{ $item->stock }}"
                                                        value="{{ $item->cart->quantity }}"
                                                        class="form-control"
                                                        name="quantity"
                                                        placeholder="Masukkan Jumlah"
                                                        required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">Unit</span>
                                                            <button
                                                            type="submit"
                                                            class="btn btn-primary float-end">
                                                            Ubah
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
