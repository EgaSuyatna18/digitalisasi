<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            @media (max-width: 768px) {
                .d-flex {
                    flex-direction: column;
                    
                }

                .btn {
                    margin-bottom: 10px;
                }
            }
        </style>
    </head>

    <body>
        @php
            use SimpleSoftwareIO\QrCode\Facades\QrCode;
        @endphp
        <div class="vh-50 d-flex justify-content-center align-items-center">
            
            <div class="col-md-8">
                <div class="border border-3 border-success"></div>
                <div class="card bg-white shadow p-5">
                    <div class="mb-4 row">
                        <div class="col-sm-12 col-md-3 mb-3 text-center" id="img_data">
                            {{ QrCode::size(120)->generate(config('app.url') . '/get_item/' . $item->id); }}
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <img class="img-fluid w-100 mb-3 d-block m-auto" src="{{ asset('/storage/' . $item->foto) }}" alt="errorImg" style="max-width: 300px; max-height: 300px;">
                        </div>
                    </div>
                    <div>
                        <h3 class="text-center">{{ $item->nama }}</h3>
                        <div class="w-50 m-auto my-5">
                            <p>{!! $item->info !!}</p>
                        </div>
                        <div class="d-flex justify-content-evenly">
                            <a class="btn btn-outline-success text-center" href="https://docs.google.com/forms/d/e/1FAIpQLSfTh1TbGqDUns0twaVvnLqWsrLEcAoMXjRoj7iYDf-MlLzQlg/viewform?usp=pp_url&entry.226714165={{ $item->nama }}">Pemeliharaan</a>
                            <a class="btn btn-outline-success text-center" href="https://docs.google.com/forms/d/e/1FAIpQLScR4svPzLrBJ3E1TZdUhRixdwfDi9yMANgdPZiqIkQMimc7OQ/viewform?usp=pp_url&entry.760230794={{ $item->nama }}">Keluhan</a>
                            <button type="button" id="downloadBtn" class="btn btn-outline-success">Download QR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script>
        // Menambahkan event listener pada tombol
        document.getElementById('downloadBtn').addEventListener('click', function () {
            const parent = document.getElementById('img_data');
                const svg = parent.children[0];
                const padding = 20; // Padding putih di sekeliling gambar

                // Mengatur ukuran canvas dengan padding
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Mengatur ukuran kanvas dengan menambahkan padding
                canvas.width = svg.clientWidth + padding * 2;
                canvas.height = svg.clientHeight + padding * 2;

                // Mengatur latar belakang putih
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                // Mengonversi SVG ke Data URL
                const svgData = new XMLSerializer().serializeToString(svg);
                const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
                const url = URL.createObjectURL(svgBlob);

                // Membuat gambar dari Data URL
                const img = new Image();
                img.onload = function() {
                    // Menggambar gambar SVG pada kanvas dengan padding
                    ctx.drawImage(img, padding, padding);
                    
                    // Mengonversi kanvas ke Data URL PNG
                    const pngDataURL = canvas.toDataURL('image/png');
                    
                    // Mengunduh PNG
                    const link = document.createElement('a');
                    link.href = pngDataURL;
                    link.download = '{{ $item->nama }}.png';
                    link.click();
                    
                    // Membebaskan URL objek
                    URL.revokeObjectURL(url);
                };
                img.src = url;
            });
    </script>

</html>