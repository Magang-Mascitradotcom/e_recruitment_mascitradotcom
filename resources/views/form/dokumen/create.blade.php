@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <!-- Notifikasi menggunakan flash session data -->
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
                @endif

                <div class="card">
                    <div class="card-header">{{ __('DOKUMEN') }}</div>
                    <div class="card-body">
                        <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="form-group row mb-2">
                                <label for="jenis" class="col-sm-3 col-form-label">JENIS</label>
                                <div class="col-sm-9">
                                    <select name="jenis" class="form-select" required>
                                        <option value=""></option>
                                        <option value="IDENTITAS KTP">IDENTITAS KTP</option>
                                        <option value="IJAZAH SLTA">IJAZAH SLTA</option>
                                        <option value="IJAZAH D4 / S1">IJAZAH D4 / S1</option>
                                        <option value="TRANSKRIP UN / UAN SLTA">TRANSKRIP UN / UAN SLTA</option>
                                        <option value="TRANSKRIP NILAI D4 / S1">TRANSKRIP NILAI D4 / S1</option>
                                        <option value="AKREDITASI S1">AKREDITASI S1</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="file" class="col-sm-3 col-form-label">FILE</label>
                                <div class="col-sm-9">
                                    <input type="file" class="custom-file-input" name="file" id="file">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary">Save</button>
                            <a href="{{ route('home') }}" class="btn btn-md btn-secondary">back</a>
                        </form>
                        <div class="table-responsive mt-3">
                            <table class="table table-striped table-bordered" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center align-middle" style="width: 50%">JENIS</th>
                                        <th scope="col" class="text-center align-middle" style="width: 50%">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($dokumens as $dokumen)
                                    <tr>
                                        <td class="text-center align-middle">{{ $dokumen->jenis }}</td>
                                        <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('dokumen.destroy', $dokumen->id) }}" method="POST">
                                                <a type="button" class="btn btn-sm btn-primary mb-1 mt-1" data-bs-toggle="modal" data-bs-target="#exampleModal">PREVIEW</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger mb-1 mt-1">HAPUS</button>
                                            </form>
                                            
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="text-center text-mute" colspan="2">Data Dokumen tidak tersedia</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
        });
    </script>
@endsection