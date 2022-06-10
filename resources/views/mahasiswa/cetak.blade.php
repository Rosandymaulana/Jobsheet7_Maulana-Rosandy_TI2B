<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Dokumen Mahasiswa</title>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h4 class="mb-4">
                    <center>JURUSAN TEKNOLOGI INFORMASI</center>
                    <center>POLITEKNIK NEGERI MALANG</center>
                </h4>

                <b>Nama: </b>{{$mahasiswa->nama}} <br>
                <b>Nim: </b>{{$mahasiswa->nim}}<br>
                <b>Kelas: </b>{{$mahasiswa->kelas->nama_kelas}}<br>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th scope="col">Mata Kuliah</th>
                            <th scope="col">SKS</th>
                            <th scope="col">Semester</th>
                            <th scope="col">Nilai Angka</th>
                            <th scope="col">Nilai Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matakuliah as $mk)
                        <tr scope="row">
                            <td>
                                {{$mk->matakuliah->nama_matakul}}
                            </td>
                            <td>
                                {{$mk->matakuliah->sks}}
                            </td>
                            <td>
                                {{$mk->matakuliah->semester}}
                            </td>
                            <td>
                                {{$mk->nilai_angka}}
                            </td>
                            <td>
                                {{$mk->nilai_huruf}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>