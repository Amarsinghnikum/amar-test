<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E Buils Bazaar Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- <b>IT LABS TEST</b> -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item {{ request()->is('posts*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('posts.index') }}">Posts</a>
                </li>
                <li class="nav-item {{ request()->is('tasks*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @if(session('status'))
    <script>
    swal("{{ session('status') }}");
    </script>
    @endif

    <script>
   function submitForm(event) {
        event.preventDefault();

        var formData = new FormData($('#createPostForm')[0]);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{ route("posts.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                swal({
                    title: 'Success',
                    text: response.message,
                    icon: 'success',
                    button: 'OK',
                }).then(() => {
                    window.location.replace('{{ route("posts.index") }}');
                });
            },
            error: function(error) {
                console.log(error);
                if (error.responseJSON && error.responseJSON.errors) {
                    $('.alert-danger').remove();
                    $.each(error.responseJSON.errors, function(field, messages) {
                        var inputField = $('#' + field);
                        inputField.after('<div class="alert alert-danger">' + messages.join('<br>') + '</div>');
                    });
                } else {
                    alert('Error creating post. Please check the console for details.');
                }
            }
        });
    }

    $(document).ready(function() {
        $('#createPostForm').submit(submitForm);
    });
    
    $(document).ready(function () {
        $('#updatePostForm').submit(function (event) {
            event.preventDefault();

            var postId = $(this).data('post-id');
            var formData = new FormData($(this)[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/posts/' + postId,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    swal({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        button: 'OK',
                    }).then(() => {
                        window.location.replace('{{ route("posts.index") }}');
                    });
                },
                error: function (error) {
                    console.log(error);
                    if (error.responseJSON && error.responseJSON.errors) {
                        var errorMessage = '';

                        $.each(error.responseJSON.errors, function (field, messages) {
                            errorMessage += messages.join('\n') + '\n';
                        });

                        $('#error-container').text(errorMessage).show();
                    } else {
                        alert('Error updating post. Please check the console for details.');
                    }
                }
            });
        });
    });
    
    function deletePost(postId) {
        if (confirm('Are you sure you want to delete this post?')) {
            $.ajax({
                url: '/posts/' + postId,
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    swal({
                        title: 'Success',
                        text: response.message,
                        icon: 'success',
                        button: 'OK',
                    }).then(() => {
                        location.reload();
                    });
                },
                error: function(error) {
                    console.log(error);
                    swal({
                        title: 'Error',
                        text: 'Error deleting post. Please check the console for details.',
                        icon: 'error',
                        button: 'OK',
                    });
                }
            });
        }
    }
    
    </script>

</body>
</html>