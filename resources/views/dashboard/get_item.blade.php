<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        @php
            use SimpleSoftwareIO\QrCode\Facades\QrCode;
        @endphp
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="border border-3 border-success"></div>
                <div class="card  bg-white shadow p-5">
                    <div class="mb-4 text-center">
                        <img class="img-fluid w-100 mb-3" src="{{ asset('/storage/' . $item->foto) }}" alt="errorImg">
                        {{ QrCode::size(120)->generate(config('app.url') . '/get_item/' . $item->id); }}
                    </div>
                    <div>
                        <h3 class="text-center">{{ $item->nama }}</h3>
                        <p>{!! $item->info !!}</p>
                        <div class="d-flex justify-content-evenly">
                            <button class="btn btn-outline-success text-center">Pemeliharaan</button>
                            <button class="btn btn-outline-success text-center">Complaint</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

</html>