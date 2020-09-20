<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test Upload</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', serif;
        }

    </style>
</head>

<body>
    <div class="container py-3">
        <div class="row">
            <div class="col-sm-8">
                <h3>Files List</h3>
                @isset($uploads)
                    @foreach($uploads as $upload)
                        <img src="{{ "data:image/" .$upload->image_type. ";base64," .base64_encode( $upload->attachment ) }}" alt="..." class="img-thumbnail">
                    @endforeach
                @else
                    <p class="alert alert-info">No files found</p>
                @endisset
            </div>
            <div class="col-sm-4">
                <h3>Upload Image</h3>
                <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <div class="form-group">
                        <label for="file_type">File Type*</label>
                        <input type="text" name="file_type" id="file_type" class="form-control" placeholder="eg. Passport Photo"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="attachment">Attachment*</label>
                        <input type="file" name="attachment" id="attachment" class="form-control" placeholder="eg. attachment" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
